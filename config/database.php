<?php
// connecting to MySQL database 🐾
$dbservername = "localhost";
$dbusername = "mnuvq";
$dbpassword = "12345";
$dbname = "web-chat";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// fingers crossed for a smooth connection! 🤞
try {
    $pdo = new PDO("mysql:host=$dbservername;dbname=$dbname;charset=utf8mb4", $dbusername, $dbpassword, $options);
} catch (PDOException $e) {
    // connection failed. 🙀
    // logging the error for debugging purposes. 😿
    error_log("Connection failed: " . $e->getMessage());
    echo "Oops! Something went wrong. Please try again later.";
    exit();
}
?>
