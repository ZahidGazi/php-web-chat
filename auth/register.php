<?php
include("../config/env.php");
include("../config/database.php");

// Sneaky check: If user's already logged in, redirect them away. 🕵️‍♂️
if (isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Form submitted? Let's hope it's not a cat walking on the keyboard! 🐾
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtolower($_POST['username']);
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // validate username format: Only cool cats with letters, numbers, and underscores allowed. 😎🐱
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        echo  '<div class="alert alert-warning alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Invalid username format. Only letters, numbers, and underscores are allowed. Meowtastic! 🐾
              </div>';
    } else {
        // prepared statement to prevent SQL injection. SQL is more prepared than a cat at dinnertime! 🍽️
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->rowCount() > 0) {
            echo  '<div class="alert alert-info alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Username or email is already in use. Be as creative as a cat with a cardboard box! 📦😺
              </div>';
        } else {
            // prepared statement again. ☀️😴
            $insertQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($insertQuery);

            if ($stmt->execute([$username, $email, $password])) {
                echo  '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Success! Your account has been created successfully! Victory cat nap time! 😺💤
              </div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        An error occurred during registration. Probably just a hiccatup in the system. 😿🤷
                      </div>';
            }
        }
    }

    // closing the connection. its like a cat ignoring its human. 🙀
    $pdo = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="meoww">
    <meta name="theme-color" content="#9fbedb">
    <title>Login</title>
    <link rel="stylesheet" href="../css/auth.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
    <div class="wrapper">
        <form action="register.php" method="post">
            <h1>Register </h1>
            <div class="input-box">
                <label for="fname">Username:</label>
                <input type="text" name="username" id="fname" placeholder="Enter Username" required>

            </div>
            <div class="input-box">
                <label for="femail">Email:</label>
                <input type="email" name="email" id="femail" placeholder="Enter Email" required><br><br>

            </div>
            <div class="input-box">
                <label for="fpass">Password:</label>
                <input type="password" name="password" id="fpass" placeholder="Enter Password" required>

            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <br>
        <center>
            <h5><a style="color: yellow;" href="login.php">Login</a></h5>
        </center>
    </div>

</body>

</html>