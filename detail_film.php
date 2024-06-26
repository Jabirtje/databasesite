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
}

$id = $_GET['id'];
$stmt = $conn->prepare('SELECT * FROM movies WHERE id = :id');
$stmt->execute(['id' => $id]);
$film = $stmt->fetch();
?>

<h2><?= $film['title'] ?></h2>
<p><strong>Lengte:</strong> <?= $film['length_in_minutes'] ?> minuten</p>
<p><strong>Uitgebracht op:</strong> <?= $film['released_at'] ?></p>
<p><strong>Land van herkomst:</strong> <?= $film['country_of_origin'] ?></p>
<p><strong>Samenvatting:</strong> <?= $film['summary'] ?></p>
<p><a href="edit_film.php?id=<?= $film['id'] ?>">Wijzigen</a></p>