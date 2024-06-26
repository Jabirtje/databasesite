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
    $rating = $_POST['rating'];
    $summary = $_POST['summary'];
    $has_won_awards = $_POST['has_won_awards'];
    $seasons = $_POST['seasons'];
    $country = $_POST['country'];
    $spoken_in_language = $_POST['spoken_in_language'];

    $stmt = $conn->prepare('
        UPDATE series SET 
            title = :title, 
            rating = :rating, 
            summary = :summary, 
            has_won_awards = :has_won_awards, 
            seasons = :seasons, 
            country = :country, 
            spoken_in_language = :spoken_in_language 
        WHERE id = :id
    ');
    $stmt->execute([
        'title' => $title,
        'rating' => $rating,
        'summary' => $summary,
        'has_won_awards' => $has_won_awards,
        'seasons' => $seasons,
        'country' => $country,
        'spoken_in_language' => $spoken_in_language,
        'id' => $id
    ]);

    header("Location: detail_serie.php?id=$id");
    exit;
} else {
    $stmt = $conn->prepare('SELECT * FROM series WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $serie = $stmt->fetch();
}
?>

<h2>Bewerk serie</h2>
<form method="post">
    <label>Titel: <input type="text" name="title" value="<?= $serie['title'] ?>"></label><br>
    <label>Beoordeling: <input type="text" name="rating" value="<?= $serie['rating'] ?>"></label><br>
    <label>Samenvatting: <textarea name="summary"><?= $serie['summary'] ?></textarea></label><br>
    <label>Awards: 
        <select name="has_won_awards">
            <option value="1" <?= $serie['has_won_awards'] ? 'selected' : '' ?>>Ja</option>
            <option value="0" <?= !$serie['has_won_awards'] ? 'selected' : '' ?>>Nee</option>
        </select>
    </label><br>
    <label>Seizoenen: <input type="number" name="seasons" value="<?= $serie['seasons'] ?>"></label><br>
    <label>Land: <input type="text" name="country" value="<?= $serie['country'] ?>"></label><br>
    <label>Taal: 
        <select name="spoken_in_language">
            <option value="NL" <?= $serie['spoken_in_language'] == 'NL' ? 'selected' : '' ?>>NL</option>
            <option value="EN" <?= $serie['spoken_in_language'] == 'EN' ? 'selected' : '' ?>>EN</option>
        </select>
    </label><br>
    <button type="submit">Opslaan</button>
</form>
<a href="detail_serie.php?id=<?= $serie['id'] ?>">Annuleer</a>
