<?php

session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
</head>
<body>
    <h2>Welkom</h2>
    <p>Je bent ingelogd.</p>
    <a href="logout.php">Uitloggen</a>
</body>
</html>
