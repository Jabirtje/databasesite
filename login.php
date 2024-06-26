<?php

session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $hashed_password = $result['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedInUser'] = $result['id'];
            header("Location: site.php"); 
            exit();
        } else {
            echo "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } else {
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
