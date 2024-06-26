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
    $rating = $_POST['rating'];
    $summary = $_POST['summary'];
    $has_won_awards = $_POST['has_won_awards'];
    $seasons = $_POST['seasons'];
    $country = $_POST['country'];
    $spoken_in_language = $_POST['spoken_in_language'];

    $stmt = $conn->prepare('
        INSERT INTO series (title, rating, summary, has_won_awards, seasons, country, spoken_in_language) 
        VALUES (:title, :rating, :summary, :has_won_awards, :seasons, :country, :spoken_in_language)
    ');
    $stmt->execute([
        'title' => $title,
        'rating' => $rating,
        'summary' => $summary,
        'has_won_awards' => $has_won_awards,
        'seasons' => $seasons,
        'country' => $country,
        'spoken_in_language' => $spoken_in_language
    ]);

    header("Location: index.php");
    exit;
}
?>

<h2>Voeg een nieuwe serie toe</h2>
<form method="post">    
    <label>Titel: <input type="text" name="title" required></label><br>
    <label>Beoordeling: <input type="number" name="rating" step="0.1" required></label><br>
    <label>Samenvatting: <textarea name="summary" required></textarea></label><br>
    <label>Awards: 
        <select name="has_won_awards" required>
            <option value="1">Ja</option>
            <option value="0">Nee</option>
        </select>
    </label><br>
    <label>Seizoenen: <input type="number" name="seasons" required></label><br>
    <label>Land: <input type="text" name="country" required></label><br>
    <label>Taal: <input type="text" name="spoken_in_language" required></label><br>
    <button type="submit">Toevoegen</button>
</form>
<a href="index.php">Annuleer</a>
