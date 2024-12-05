<?php

session_start();
include "database.php";
include "LoginService.php";

// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['username'];
    $password = $_POST['password'];
    
    $loginService = new LoginService($conn);
    if ($loginService->validateLogin($email, $password)) {
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("Location: Home.php");
        exit();
    } else {
        echo 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Login Section -->
    <section id="login">
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </section>

</body>
</html>
