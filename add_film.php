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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $length_in_minutes = $_POST['length_in_minutes'];
    $released_at = $_POST['released_at'];
    $country_of_origin = $_POST['country_of_origin'];
    $summary = $_POST['summary'];
    $youtube_trailer_id = $_POST['youtube_trailer_id'];

    $stmt = $conn->prepare('
        INSERT INTO movies (title, length_in_minutes, released_at, country_of_origin, summary, youtube_trailer_id) 
        VALUES (:title, :length_in_minutes, :released_at, :country_of_origin, :summary, :youtube_trailer_id)
    ');
    $stmt->execute([
        'title' => $title,
        'length_in_minutes' => $length_in_minutes,
        'released_at' => $released_at,
        'country_of_origin' => $country_of_origin,
        'summary' => $summary,
        'youtube_trailer_id' => $youtube_trailer_id
    ]);

    header("Location: index.php");
    exit;
}
?>

<h2>Voeg een nieuwe film toe</h2>
<form method="post">
    <label>Titel: <input type="text" name="title" required></label><br>
    <label>Lengte (minuten): <input type="number" name="length_in_minutes" required></label><br>
    <label>Uitgebracht op: <input type="date" name="released_at" required></label><br>
    <label>Land van herkomst: <input type="text" name="country_of_origin" required></label><br>
    <label>Samenvatting: <textarea name="summary" required></textarea></label><br>
    <label>YouTube Trailer ID: <input type="text" name="youtube_trailer_id" required></label><br>
    <button type="submit">Toevoegen</button>
</form>
<a href="index.php">Annuleer</a>
