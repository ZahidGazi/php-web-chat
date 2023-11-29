<?php
include("config/env.php");
include("config/database.php");

if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}

$owner = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT room_id, chat_title, password FROM chat_rooms WHERE owner = ?");

if ($stmt->execute([$owner])) {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Use fetchAll for compatibility
} else {
    error_log("PDO Error: " . implode(" ", $stmt->errorInfo()));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Rooms</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            max-width: 100%;
            padding: 20px;
            margin: 20px;
        }

        .room {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .room-details {
            flex: 2;
        }

        .join-button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php foreach ($result as $row) : ?>
            <div class="room">
                <div class="room-details">
                    <p>Room ID: <?php echo $row['room_id']; ?></p>
                    <p>Title: <?php echo $row['chat_title']; ?></p>
                    <p>Password: <?php echo $row['password']; ?></p>
                </div>
                <button class="join-button" onclick=joinRoom(<?php echo "'" . $row['room_id'] . "'" . "," . "'" . $row['password'] . "'"; ?>)>Join</button>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
    // Function to validate the room 
    function validateRoom($roomID, $room_password)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT room_id, password, chat_title FROM chat_rooms WHERE room_id = ? AND password = ?");
        $stmt->execute([$roomID, $room_password]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['Vchat'] = $row['chat_title'];
            return true;
        } else {
            return false;
        }
    }

    // saving session
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $roomID = $_POST['roomID'];
        $room_password = $_POST['room_password'];

        if (validateRoom($roomID, $room_password)) {
            $_SESSION['Vroom'] = $roomID;
            $_SESSION['Vroom_pass'] = $room_password;
            echo "success"; // Meow! Success is sweet!
        } else {
            echo "Invalid room ID or password. Please try again.";
        }
    }

    $pdo = null; // Closing the PDO connection
    ?>

    <script>
        // function to handle joining a room 🐾
        function joinRoom(roomId, password) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`roomID=${roomId}&room_password=${password}`);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        window.location.href = `chat.php?roomID=${roomId}`;
                    }
                }
            };
        }
    </script>
</body>

</html>