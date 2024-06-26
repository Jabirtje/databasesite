<?php

$database = "netland";
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $length_in_minutes = $_POST['length_in_minutes'];
    $released_at = $_POST['released_at'];
    $country_of_origin = $_POST['country_of_origin'];
    $summary = $_POST['summary'];
    $youtube_trailer_id = $_POST['youtube_trailer_id'];

    $stmt = $conn->prepare('
        UPDATE movies SET 
            title = :title, 
            length_in_minutes = :length_in_minutes, 
            released_at = :released_at, 
            country_of_origin = :country_of_origin, 
            summary = :summary, 
            youtube_trailer_id = :youtube_trailer_id 
        WHERE id = :id
    ');
    $stmt->execute([
        'title' => $title,
        'length_in_minutes' => $length_in_minutes,
        'released_at' => $released_at,
        'country_of_origin' => $country_of_origin,
        'summary' => $summary,
        'youtube_trailer_id' => $youtube_trailer_id,
        'id' => $id
    ]);

    header("Location: detail_film.php?id=$id");
    exit;
} else {
    $stmt = $conn->prepare('SELECT * FROM movies WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $film = $stmt->fetch();
}
?>

<h2>Bewerk film</h2>
<form method="post">
    <label>Titel: <input type="text" name="title" value="<?= $film['title'] ?>"></label><br>
    <label>Lengte (minuten): <input type="number" name="length_in_minutes" value="<?= $film['length_in_minutes'] ?>"></label><br>
    <label>Uitgebracht op: <input type="date" name="released_at" value="<?= $film['released_at'] ?>"></label><br>
    <label>Land van herkomst: <input type="text" name="country_of_origin" value="<?= $film['country_of_origin'] ?>"></label><br>
    <label>Samenvatting: <textarea name="summary"><?= $film['summary'] ?></textarea></label><br>
    <label>YouTube Trailer ID: <input type="text" name="youtube_trailer_id" value="<?= $film['youtube_trailer_id'] ?>"></label><br>
    <button type="submit">Opslaan</button>
</form>
<a href="detail_film.php?id=<?= $film['id'] ?>">Annuleer</a>
