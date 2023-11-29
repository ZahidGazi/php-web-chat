<?php
include("../config/env.php");
include("../config/database.php");
// check if user is logen in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// validate room id and pass
function validateRoom($roomID, $room_password)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT room_id, password, chat_title  FROM chat_rooms WHERE room_id = ? AND password = ?");
    $stmt->execute([$roomID, $room_password]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['Vchat'] = $result['chat_title'];
        return true;
    } else {
        return false;
    }
}
// getting room id and pass through post req. and after validation redirect to the room
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomID = $_POST['roomID'];
    $room_password = $_POST['room_password'];

    if (validateRoom($roomID, $room_password)) {
        $_SESSION['Vroom'] = $roomID;
        $_SESSION['Vroom_pass'] = $room_password;
        header("Location: ../chat.php?roomId=" . $roomID);
        exit();
    } else {
        echo "Invalid room ID or password. Please try again.";
    }
}

$pdo = null;
?>
