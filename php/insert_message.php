<?php
include("../config/env.php");
include("../config/database.php");

// Inserting messages in the database! 🐾
if (isset($_SESSION['username'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // keeping it clean, just like cat grooming! 🐱
        $user = htmlspecialchars($_POST["user"], ENT_QUOTES, 'UTF-8');
        $message = htmlspecialchars($_POST["msg"], ENT_QUOTES, 'UTF-8');
        $roomId = htmlspecialchars($_POST["roomId"], ENT_QUOTES, 'UTF-8');

        // no room for emptiness, unlike cat nap schedules! 😴
        if (!empty($user) && !empty($message) && !empty($roomId)) {
            // Prepared statement – because cats value security too 🔒
            $stmt = $pdo->prepare("INSERT INTO chat_messages (room_id, username, msg_content, timestamp) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$roomId, $user, $message]);
        } else {
            // cats don't tolerate nonsense! 🙀
            echo json_encode(["success" => false, "message" => "Invalid input"]); // clarity is the cat's meow! 🐾👌
        }
    }
} else {
    // if no session, redirect to the login page – because even cats need permission to enter! 🚪
    header("Location: ../auth/login.php");
    exit();
}

$pdo = null; // cats appreciate tidiness! 🧹🐾
?>