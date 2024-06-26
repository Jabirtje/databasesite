<?php
session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

$database = "netland";
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Verbonden met database " . $database . " met versie: " . $conn->query('select version()')->fetchColumn() . "<br>";
} catch (PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
}

$movieOrder = isset($_GET['movieOrder']) ? $_GET['movieOrder'] : 'title';
$movieSort = isset($_GET['movieSort']) ? $_GET['movieSort'] : 'ASC';
$seriesOrder = isset($_GET['seriesOrder']) ? $_GET['seriesOrder'] : 'title';
$seriesSort = isset($_GET['seriesSort']) ? $_GET['seriesSort'] : 'ASC';
?>

<h2>Films</h2>
<form action="" method="get">
    <input type="hidden" name="seriesOrder" value="<?= htmlspecialchars($seriesOrder) ?>">
    <input type="hidden" name="seriesSort" value="<?= htmlspecialchars($seriesSort) ?>">
    <button type="submit" name="movieOrder" value="title">Sorteer op titel</button>
    <button type="submit" name="movieOrder" value="length_in_minutes">Sorteer op lengte</button>
    <button type="submit" name="movieOrder" value="released_at">Sorteer op uitgebracht</button>
</form>
<ul>
    <?php
    $stmt = $conn->query('SELECT * FROM movies ORDER BY ' . $movieOrder . ' ' . $movieSort);
    while ($row = $stmt->fetch()) {
        echo "<li>";
        echo "Titel: " . htmlspecialchars($row['title']) . "<br>";
        echo "Lengte: " . htmlspecialchars($row['length_in_minutes']) . " minuten<br>";
        echo "Uitgebracht op: " . htmlspecialchars($row['released_at']) . "<br>";
        echo "Land van herkomst: " . htmlspecialchars($row['country_of_origin']) . "<br>";
        echo "Samenvatting: " . htmlspecialchars($row['summary']) . "<br>";
        echo "<a href='detail_film.php?id=" . htmlspecialchars($row['id']) . "'>Bekijk details</a>";
        echo "</li><br>";
    }
    ?>
</ul>

<h2>Series</h2>
<form action="" method="get">
    <input type="hidden" name="movieOrder" value="<?= htmlspecialchars($movieOrder) ?>">
    <input type="hidden" name="movieSort" value="<?= htmlspecialchars($movieSort) ?>">
    <button type="submit" name="seriesOrder" value="title">Sorteer op titel</button>
    <button type="submit" name="seriesOrder" value="rating">Sorteer op beoordeling</button>
    <button type="submit" name="seriesOrder" value="seasons">Sorteer op aantal seizoenen</button>
</form>
<ul>
    <?php
    $stmt = $conn->query('SELECT * FROM series ORDER BY ' . $seriesOrder . ' ' . $seriesSort);
    while ($row = $stmt->fetch()) {
        echo "<li>";
        echo "Titel: " . htmlspecialchars($row['title']) . "<br>";
        echo "Beoordeling: " . htmlspecialchars($row['rating']) . "<br>";
        echo "Samenvatting: " . htmlspecialchars($row['summary']) . "<br>";
        echo "Awards: " . ($row['has_won_awards'] ? 'Ja' : 'Nee') . "<br>";
        echo "Seizoenen: " . htmlspecialchars($row['seasons']) . "<br>";
        echo "Taal: " . htmlspecialchars($row['spoken_in_language']) . "<br>";
        echo "Land: " . htmlspecialchars($row['country']) . "<br>";
        echo "<a href='detail_serie.php?id=" . htmlspecialchars($row['id']) . "'>Bekijk details</a>";
        echo "</li><br>";
    }
    ?>
</ul>

<a href="logout.php">Log uit</a>
