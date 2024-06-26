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
$stmt = $conn->prepare('SELECT * FROM series WHERE id = :id');
$stmt->execute(['id' => $id]);
$serie = $stmt->fetch();
?>

<h2>Details van de serie</h2>
<ul>
    <li>Titel: <?= $serie['title'] ?></li>
    <li>Beoordeling: <?= $serie['rating'] ?></li>
    <li>Samenvatting: <?= $serie['summary'] ?></li>
    <li>Awards: <?= $serie['has_won_awards'] ? 'Ja' : 'Nee' ?></li>
    <li>Seizoenen: <?= $serie['seasons'] ?></li>
    <li>Taal: <?= $serie['spoken_in_language'] ?></li>
    <li>Land: <?= $serie['country'] ?></li>
</ul>
<a href="edit_serie.php?id=<?= $serie['id'] ?>">Bewerk serie</a>
