<?php
// Php-Web-Chat: Where cats connect! 🐾🗨️
include("config/env.php");
include("config/database.php");

// check if user logged in
if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}

// logout session
if (isset($_POST['logoutButton'])) {
    session_unset();
    session_destroy();
    echo "success";
    exit();
}

// Fetch public rooms
$stmt = $pdo->prepare("SELECT room_id, chat_title, password FROM chat_rooms WHERE chat_type = 'public'");

if ($stmt->execute()) {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Php-Web-Chat</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@1,700&family=Inconsolata:wght@300&family=Merriweather:wght@900&family=Mukta:wght@500&family=Poppins:wght@300&family=Roboto:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="container">
        <!-- nav-section started from here -->
        <nav>

            <div class="logo">
                <h1 class="logo-name">StoicDevs</h1>
            </div>
            <i class="ri-menu-line" id="menu"></i>
            <div class="nav-content ">
                <a href="rooms.php" style="color:white;" class="room-text">My rooms</a>
                <p class="Logout-text" id="logoutButton">Logout</p>
            </div>

        </nav>

        <!-- slider section started from here -->
        <div class="slider">
            <div class="slider-header">
                <h2>Public Rooms :</h2>
            </div>
            <div class="slide-wrapper">
                <?php foreach ($result as $row) : ?>
                    <div class="slide-content">
                        <p class="slide-title"> <?= htmlspecialchars($row['chat_title']); ?> </p>
                        <div class="button">
                            <button class="join-button" onclick="joinRoom('<?= htmlspecialchars($row['room_id']); ?>', '<?= htmlspecialchars($row['password']); ?>')">Join</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <!-- login scetion strted from here -->
        <div class="login-section">
            <form action="auth/create_group.php" method="post" class="form-1">
                <p class="login-title">Create a private <br> room</p>
                <div class="input-field">
                    <label for="chatTitle">Chat Title:</label>
                    <input type="text" id="chatTitle" name="chatTitle" placeholder="Enter title" required>
                </div>
                <div class="input-field">
                    <label for="cpass">Password:</label>
                    <input type="password" id="cpass" name="room_password" placeholder="Enter password" required>
                </div>
                <div class="log-btn">
                    <input type="submit" value="Create">
                </div>

            </form>
            <form action="auth/join_group.php" method="post" class="form-2">
                <p class="login-title">Join a private <br> room</p>
                <div class="input-field">
                    <label for="roomID">Room ID:</label>
                    <input type="text" name="roomID" id="roomID" placeholder="Enter room id" required>
                </div>
                <div class="input-field">
                    <label for="jpass">Password:</label>
                    <input type="password" name="room_password" id="jpass" placeholder="Enter password" required>
                </div>
                <div class="log-btn">
                    <input type="submit" value="Join">
                </div>
            </form>

        </div>

        <!-- footer section started from here -->
        <div class="footer-section">
            <div class="footer-logo-section">
                <!-- <div class="footer-logo nav-logo">
                    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="college logo image">
                </div> -->
                <div class="footer-logo-name">
                    <h3>StoicDevs</h3>
                </div>
            </div>
            <div class="social-media-icons">
                <div class="content-icon">
                    <span><i class="ri-instagram-line"></i></span>
                    <span style="letter-spacing: 1px;">StoicDevs54</span>
                </div>
                <div class="content-icon">
                    <span> <i class="ri-twitter-fill"></i></span>
                    <span style="letter-spacing: 1px;">StoicDevs1234r</span>
                </div>
                <div class="content-icon">
                    <span> <i class="ri-linkedin-box-fill"></i></span>
                    <span style="letter-spacing: 1px;">StoicDevs@</span>
                </div>
                <div class="content-icon">
                    <span> <i class="ri-youtube-fill"></i></span>
                    <span style="letter-spacing: 1px;">StoicDevs</span>
                </div>
            </div>
            <div class="about">

            </div>
            <div class="footer-contract-us">
                <div class="emaill">
                    <i class="ri-mail-line"></i>
                    <p> StoicDevs@gmail.com</p>
                </div>
                <div class="phone">
                    <i class="ri-phone-line"></i>
                    <p>+91 3484139416493</p>
                </div>
                <div class="subscribe">
                    <button>SUBSCRIBE</button>
                    <input type="text" placeholder="enter your email">
                </div>
            </div>
        </div>

        <h3 class="footer-header">copyright 2023-24 all rights reserved by <a href="https://z.weebshq.us/">StoicDevs</a></h3>



    </div>
    <?php
// Function to validate the room
function validateRoom($roomID, $room_password)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT room_id, password, chat_title FROM chat_rooms WHERE room_id = ? AND password = ?");
    $stmt->execute([$roomID, $room_password]);

    if ($stmt->rowCount() > 0) {
        $roomData = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['Vchat'] = $roomData['chat_title'];
        return true;
    } else {
        return false;
    }
}

// Saving session if room is valid
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomID = $_POST['roomID'];
    $room_password = $_POST['room_password'];

    if (validateRoom($roomID, $room_password)) {
        $_SESSION['Vroom'] = $roomID;
        $_SESSION['Vroom_pass'] = $room_password;
        echo "success";
    } else {
        echo "Invalid room ID or password. Please try again.";
    }
}

$pdo = null; // Close the database connection
?>

<script>
    // Redirection to room
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

<script src="js/script.js"></script>
<script>
    // Function for session logout
    document.getElementById("logoutButton").addEventListener("click", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("logoutButton=1");

        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    window.location.href = "auth/login.php";
                }
            }
        };
    });
</script>

</body>

</html>
