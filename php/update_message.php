<?php
include("../config/env.php");
include("../config/database.php");

// Safety check – Cats must be logged in! 🐱🚧
if (!isset($_SESSION['username']) || !isset($_SESSION['Vroom'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Server, fetch me messages! 🐾
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $roomId = $_SESSION['Vroom'];

    // New messages or all messages? Cats are curious! 🤔📤📥
    if (isset($_POST["lastmsg"])) {
        $lastmsg = $_POST["lastmsg"];
        $lastuser = $_POST["lastuser"];

        // Prepare for a message feast – Bon appétit! 🍽️🐾
        $stmt = $pdo->prepare("SELECT * FROM chat_messages WHERE room_id = ? AND msg_id > ? ORDER BY msg_id ASC");
        $stmt->execute([$roomId, $lastmsg]);
        $id = $lastuser;
    } else {
        // Getting all messages – Cats love history! 📜🐱
        $stmt = $pdo->prepare("SELECT * FROM chat_messages WHERE room_id = ? ORDER BY msg_id ASC");
        $stmt->execute([$roomId]);
        $id = '';
    }

    // Fetch the messages – Cats enjoy a good story! 📚🐾
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// initializing the output variable
$htmlOutput = '';
// ducking Loop to Unleash the messages! 🦆🎉
foreach ($messages as $message) {
    $msgId = $message['msg_id'];
    $Content = htmlspecialchars_decode($message['msg_content'], ENT_QUOTES | ENT_HTML5);
    $msgContent = htmlspecialchars($Content, ENT_QUOTES, 'UTF-8');
    $timestamp = $message['timestamp'];
    $user = $message['username'];
    // Is it from me or another feline friend? Cats ponder! 🤔🐾
    if ($user === $username) {
        // My turn to shine 💖
        if ($id !== $user) {
            $htmlOutput .= '<div class="my-name">You</div><div class="message-holder"><div class="my-text" id="' . $msgId . '-' . $user . '">' .
            $msgContent . '<p class="timme">' . $timestamp . '</p></div></div>';
        } else {
            $htmlOutput .= '<div class="message-holder"><div class="my-text" id="' . $msgId . '-' . $user . '">' .
            $msgContent . '<p class="timme">' . $timestamp . '</p></div></div>';
        }
    } else {
        // Ohhh god its our systemmmmm.... elvis bhai ke age koi bol sakta hai kyaaaaa.... 😎
        if ($user === 'System' || $user === 'admin') {
            $htmlOutput .= '<div class="their-name">' . $user . '</div><div class="message-holder"><div class="their-text" id="' . $msgId . '-' . $user . '">' .
            $Content . '<p class="timme">' . $timestamp . '</p></div></div>';
        }elseif ($id !== $user) {
            // New actor on stage 🕺💃
            $htmlOutput .= '<div class="their-name">' . $user . '</div><div class="message-holder"><div class="their-text" id="' . $msgId . '-' . $user . '">' .
                $msgContent . '<p class="timme">' . $timestamp . '</p></div></div>';
        } else {
            $htmlOutput .= '<div class="message-holder"><div class="their-text" id="' . $msgId . '-' . $user . '">' .
                $msgContent . '<p class="timme">' . $timestamp . '</p></div></div>';
        }
    }
    $id = $user; // The stage is set for the next actor😎
}
// The final meow – Deliver the messages! 🐾📤
echo $htmlOutput;
$pdo = null;
