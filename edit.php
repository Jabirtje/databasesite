<?php

session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $password, $id);

    if ($stmt->execute()) {
        echo "Gebruiker bijgewerkt.";
    } else {
        echo "Fout bij het bijwerken van gebruiker.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
</head>

<body>
    <h2>Edit User</h2>
    <form method="post" action="edit.php">
        <label for="id">User ID:</label>
        <input type="text" id="id" name="id" required><br>
        <label for="username">Username:</label>
        <input<input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Update">
    </form>
</body>

</html>