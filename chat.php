<?php
include("config/env.php");
include("config/database.php");

if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}


$roomID = $_SESSION['Vroom'];
$room_password = $_SESSION['Vroom_pass'];
$chatTitle = $_SESSION['Vchat'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="meoww">
    <meta name="theme-color" content="#9fbedb">
    <title><?php echo $chatTitle ?></title>
    <!-- External CSS and JS libraries -->
    <link href="https://fonts.googleapis.com/css2?family=Tourney:ital,wght@1,325&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/chat-page.css">
</head>

<body>
    <!-- chat title -->
    <div id="header">
        <?php echo $chatTitle ?>
    </div>
    <!--message body container -->
    <div class="message-body">
        <img src="https://maine.aoa.org/events-register/images/Loading.gif" class="loader" />
    </div>
    <!--input msg, media and send button -->
    <div class="footer">
        <div class="conversation-compose">
            <div id="select" class="emoji">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                    <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                </svg>
            </div>
            <div id="emoji-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-kiss" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12.493 13.368a7 7 0 1 1 2.489-4.858c.344.033.68.147.975.328a8 8 0 1 0-2.654 5.152 8.58 8.58 0 0 1-.81-.622Zm-3.731-3.22a13 13 0 0 0-1.107.318.5.5 0 1 1-.31-.95c.38-.125.802-.254 1.192-.343.37-.086.78-.153 1.103-.108.16.022.394.085.561.286.188.226.187.497.131.705a1.892 1.892 0 0 1-.31.593c-.077.107-.168.22-.275.343.107.124.199.24.276.347.142.197.256.397.31.595.055.208.056.479-.132.706-.168.2-.404.262-.563.284-.323.043-.733-.027-1.102-.113a14.87 14.87 0 0 1-1.191-.345.5.5 0 1 1 .31-.95c.371.12.761.24 1.109.321.176.041.325.069.446.084a5.609 5.609 0 0 0-.502-.584.5.5 0 0 1 .002-.695 5.52 5.52 0 0 0 .5-.577 4.465 4.465 0 0 0-.448.082Zm.766-.087-.003-.001-.003-.001c.004 0 .006.002.006.002Zm.002 1.867-.006.001a.038.038 0 0 1 .006-.002ZM6 8c.552 0 1-.672 1-1.5S6.552 5 6 5s-1 .672-1 1.5S5.448 8 6 8Zm2.757-.563a.5.5 0 0 0 .68-.194.934.934 0 0 1 .813-.493c.339 0 .645.19.813.493a.5.5 0 0 0 .874-.486A1.934 1.934 0 0 0 10.25 5.75c-.73 0-1.356.412-1.687 1.007a.5.5 0 0 0 .194.68ZM14 9.828c1.11-1.14 3.884.856 0 3.422-3.884-2.566-1.11-4.562 0-3.421Z" />
                </svg>
            </div>
            <input type="text" placeholder="Enter message" class="message-input" />
            <div id="submitm" class="emoji">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">

                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z" />

                </svg>

            </div>
        </div>
    </div>
    <!--media modal for next update  -->
    <div class="modal fade" id="modalforres" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close closemdata" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="resources"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closemdata" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--emoji , same for next update -->
    <div id="emoji-pop-up" class="hidden">
        <div id="emoji-close-btn" title="Close">
            <i class='bx bx-x'></i>
        </div>
        <div class="container">
            <div class="toggle-buttons">
                <button id="emoji-button" class="active" data-section="emoji">Emoji</button>
                <button id="animated-button" data-section="animated">Animated</button>
                <button id="gifs-button" data-section="gifs">GIFs</button>
            </div>
            <div class="sections">
                <div class="section active" id="emoji-section" onclick="ppppmeow();">
                    <!-- Emoji content goes here -->
                    <b>Click one the above buttons to see related stickers..</b>

                </div>
                <div class="section" id="animated-section" onclick="ppppmeow();">
                    <!-- Animated content goes here -->
                    <b>Loading...</b>

                </div>
                <div class="section" id="gifs-section" onclick="ppppmeow();">

                    <!-- GIFs content goes here -->
                    <b>Loading...</b>

                </div>
            </div>
        </div>

    </div>
    <script>
        window.addEventListener('load', function() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "php/update_message.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response
                        document.querySelector(".message-body").innerHTML = data;
                        document.querySelector(".message-body").scrollBy(0, 10000);
                    }
                }
            };
            xhr.send("roomId=<?php echo $roomID ?>");
        })

        // random wallpaper
        months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        month = months[new Date().getMonth()]; // badme kaam ayega try kiya time thik karne ka but ahggh orgasmsssss.. peace 🍑

        var images = ['https://blogger.googleusercontent.com/img/a/AVvXsEiBuQTG6SyJ84NS4H-b22NVYZ5dNzfbRuzvGKlip7JIQgC_Q7P7C2H-Q0JA_CPC3n7tI-h-H0pA_VqvJo2jnrBo9yk0eaQgqbnf7Y2b4fGqOGocS2PmB2nu2sg_sljQ_CICjNFYX8OUgTJIA-ZOF5RWiCnz5YT9NTHKa3kDMFIO7xlhBaRaDafX3XWh', 'https://blogger.googleusercontent.com/img/a/AVvXsEhW3096L_ofmihJDd3BZa-oPOexg_9alaR20NRRpiJOM_UVu0kc_V9wfkbWDNOfWeIhIyetux-EKS3JYXdwftX6W_P8Q5P-GRLT0TVPBe80XS5c6zJrAePDZ-DuMZvohyvXh0jqcD4q786fcObhp21GyuUGIZHWgH7-axCpqRcXELUvvkVinqrSv0XA', 'https://blogger.googleusercontent.com/img/a/AVvXsEgiemK4O_SfjTmf6b5iJIAFAhvVn4TzBYqZGOjFbZwsJt2HR5dB8Z1uNq36Vk5Hz_ZfBi37n9ASQFo1os09PkRbIki2HH7vXeijmLvoB4Zwa8SpWPUcmExMO6-HtePS7976hu85ugO__bEs_fxeH72-5l10NYNx7mqVKHDYPlmmbUKQ3zKJjzr8EdW1', 'https://blogger.googleusercontent.com/img/a/AVvXsEgWETDPwPhCVkVGgHWOv_WZb00VAPpmPujODGfhQ20noF7OKThAtxej6UmZhJpkw0VEGBemRtWFkOoW0j1Q-a7Jiyi2QcEfBaPfW6Qjpq3ajNgUKXVGJOTs_2AdoLOQCTy5BgRs03auk5A5A4zehwPSU-le2xYrYfwVTCZ-YkswfplAktzk9HpeI4C6', 'https://blogger.googleusercontent.com/img/a/AVvXsEguOrPTGgYYwmZ8EQLRPWi4UknAXMgPuZw6LNbHT2FhnYqmCFhQa28fe8tXWCqCkqmvMXrjUUG21A5Ar57ESBB-NXWkqI54e5ILT7pv7RUJHOaqazq2_Oe0k7KYwNDyon3Lo40TDDeHYlFUzVJv3cd5QR8sSLYAMsjiEzD63loHOWEPjuW5OBwS4nTn', 'https://blogger.googleusercontent.com/img/a/AVvXsEiYt6uHXaHIRzslWFtetkIW7FC7csYcc44VynumBwNLlxx9pHH3YsaHztM0H195CKZa9oVJMp0wLNi_41qNQQFzaNnD28EsF_5cI2cSztS97cI3yKdI6RSvLVytfjABXsaP5K0ZY3C-N9omRcOx2KC5Z5F5NpEBLQ3DvTj1DZsMh4G1dZ9tIQIPwqKG', 'https://blogger.googleusercontent.com/img/a/AVvXsEjDuUDO2t2CT80HY7yEZbsUbyFbjw98FG3QTBOSSUic7BT9l8lZiLDYRah9sUnQcjBcucNdiw1JJC0SbcFDMHulFmOc1BMI2KSg-pFQiezdXzlGKXRjlbZBGAETa5taqETAmJ9Zfp-5iJ-gYclsPcgbQP5qm8FxBzoznywdCTR9ksusydcaIrizDlHV'];
        var image = images[Math.floor(Math.random() * images.length)];
        document.getElementsByTagName('body')[0].style.backgroundImage = "linear-gradient(rgba(0, 0, 0, 0.13), rgba(0, 0, 0, 0.13)),url('" + image + "')";
        document.getElementsByTagName('body')[0].style.backgroundRepeat = "repeat";
        document.getElementsByTagName('body')[0].style.backgroundSize = "auto";
        setInterval(() => {
            document.querySelector(".message-body").style.height =
                window.innerHeight - 110 + "px";
        }, 100);
        // Event listener for sending messages
        document.querySelector(".message-input").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                var message = document.querySelector(".message-input").value.trim();
                if (message !== "") {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "php/insert_message.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            document.querySelector(".message-input").value = "";
                        }
                    };
                    xhr.send("user=<?php echo $username ?>&roomId=<?php echo $roomID ?>&msg=" + encodeURIComponent(message));
                }
                // document.querySelector(".message-input").value = "";
            }
        });
        // same backcodi but in defferent way boleto keyyyyyypresss.....ahggghhhh peace 🍑
        document.querySelector("#submitm").addEventListener("click", function(e) {
            var message = document.querySelector(".message-input").value.trim();
            if (message !== "") {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "php/insert_message.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.querySelector(".message-input").value = "";
                    }
                };
                xhr.send("user=<?php echo $username ?>&roomId=<?php echo $roomID ?>&msg=" + encodeURIComponent(message));
            }
            // document.querySelector(".message-input").value = "";
        });
        // isbaar no fultime scroll only if only new message come 🍑 matha kharab ho gaya sochte sochte
        setInterval(() => {
            var lastMessageElement = document.querySelector(".message-holder:last-child .my-text, .message-holder:last-child .their-text");
            if (lastMessageElement) {
                var msgNname = lastMessageElement.id;
                var [lastMessageId, lastUsername] = msgNname.split('-');
                console.log(lastMessageId, lastUsername);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "php/update_message.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = () => {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            let data = xhr.response
                            if (data != '') {
                                document.querySelector(".message-body").innerHTML += data;
                                document.querySelector(".message-body").scrollBy(0, 500);
                            }
                        }
                    }
                };
                xhr.send(`roomId=<?php echo $roomID ?>&lastmsg=${lastMessageId}&lastuser=${lastUsername}`);
            }
        }, 500);
    </script>

</body>

</html>