<?php
include("../config/env.php");
include("../config/database.php");
// check if user is logged in 
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// function to create unique room id
function generateUniqueRoomId()
{
    $timestamp = time();
    $randomString = bin2hex(random_bytes(5));
    $roomId = $randomString . $timestamp;
    $roomId = substr($roomId, 0, 8);

    return $roomId;
}
// creating new group
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chatTitle = $_POST['chatTitle'];
    $room_password = $_POST['room_password'];

    $roomId = generateUniqueRoomId();
    $stmt = $pdo->prepare("INSERT INTO chat_rooms (chat_title, room_id, password, owner) VALUES (?, ?, ?, ?)");

    if ($stmt->execute([$chatTitle, $roomId, $room_password, $username])) {
        $msg = '<h2 style="color: #54ff00;">Welcome to the Room!</h2>
        <p>🌟 <strong>Chat Rules:</strong></p>
        <ul style="list-style-type: none; padding: 0; color: #00ff8c;">
            <li>🚫 No cursing or offensive language.</li>
            <li>🔒 Keep personal information private.</li>
            <li>🤝 Be respectful to others.</li>
            <li>💬 Stay on topic and enjoy the conversation!</li>
        </ul>
        <p style="margin-top: 15px; font-style: italic;">Feel free to ask if you have any questions. Happy chatting! 😊</p> <a href="https://www.telegram.me/stoicdevs" class="button">Support Chat</a>';
        $stmt = $pdo->prepare("INSERT INTO chat_messages (room_id, username, msg_content, timestamp) VALUES (?, 'System', ?, NOW())");
        $stmt->execute([$roomId, $msg]);
        $_SESSION["Vroom"] = $roomId;
        $_SESSION["Vchat"] = $chatTitle;

        $_SESSION["Vroom_pass"] = $room_password;
        header("Location: ../chat.php?roomId=" . $roomId);
        exit();
    } else {
        echo "error, please try again";
        error_log("PDO Error: " . implode(" ", $stmt->errorInfo()));
    }
}

$pdo = null;
