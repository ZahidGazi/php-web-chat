<?php session_start();
//check if user is alredy logged in
if (isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
include("../config/database.php");

// format username and ceck if user exist/ login - start a session
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        echo  '<div class="alert alert-warning alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Invalid username format. Only letters, numbers, and underscores are allowed.
      </div>';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row["password"])) {
                $_SESSION['username'] = strtolower($username);
                echo  '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> Login successful! Welcome, ' . $_SESSION['username'] .
                    '</div>';
                // Redirect user to homepage
                header("Location: ../index.php");
                exit();
            } else {
                echo  '<div class="alert alert-info alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Incorrect password. Please try again.
              </div>';
            }
        } else {
            echo  '<div class="alert alert-info alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                User not found. Please register first.
              </div>';
        }
    }

    $pdo = null;
}
?>
<!DOCTYPE html>
<html lang>

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
        <form action="login.php" method="post">
            <h1>Login </h1>
            <div class="input-box">
                <label for="fname">Username:</label>
                <input type="text" name="username" id="fname" placeholder="Enter Username" required>

            </div>
            <div class="input-box">
                <label for="fpass">Password:</label>
                <input type="password" name="password" id="fpass" placeholder="Enter Password" required>

            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <br>
        <center>
            <h5><a style="color: yellow;" href="register.php">REGISTER</a></h5>
        </center>
    </div>


</body>

</html>