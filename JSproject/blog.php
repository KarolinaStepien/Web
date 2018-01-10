<html>
<head>
    <link id="pagestyle" href="stylDomyślny.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="cssChanger.js"></script>
    <script type="text/javascript">
        function switchChatOn(event) {
            var checkBox = event.target;
            var chatArea = document.getElementById("chatArea");
            var uname = document.getElementById("uname");
            var message = document.getElementById("message");
            var btn = document.getElementById("send");

            if (checkBox.checked === true) {
                chatArea.hidden = false;
                uname.hidden = false;
                message.hidden = false;
                btn.hidden = false;

                setTimeout(refreshChat, 20)

            }
            else {
                chatArea.hidden = true;
                uname.hidden = true;
                message.hidden = true;
                btn.hidden = true
            }
        }

        function refreshChat() {
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var chatlogs = document.getElementById("chatArea");
                    chatlogs.innerHTML = xmlhttp.responseText;
                    var cs = document.getElementById("chatSwitch");
                    if (cs.checked === true) setTimeout(refreshChat, 2000);
                }
            };
            xmlhttp.open("GET", "insert.php?type=cosinnego");
            xmlhttp.send();
        }

        function sendMessage() {
            var uname = document.getElementById("uname");
            var msg = document.getElementById("message");
            if (uname.value !== "" && msg.value !== "") {
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        var chatlogs = document.getElementById("chatArea");
                        chatlogs.innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open('GET', 'insert.php?uname=' + uname.value + '&msg=' + msg.value + '&type=send', true);
                uname.value = "";
                msg.value = "";
                xmlhttp.send();
            }
        }

    </script>
</head>
<body onload="onload2()">
    <?php
    //wyswietlenie menu
    include 'menu.php';
    echo "<hr>";
    if (isset($_GET["nazwa"])) {
        $bname = $_GET{"nazwa"};
        $dir = opendir($bname);
        if ($dir != false) {
            //lista plikow w folderze bloga
            $filesList = scandir($bname);
            for ($i = 2; $i < sizeof($filesList); $i++) {
                $fileBaseName = explode(".", $filesList[$i])[0];
                $fileExtension = explode(".", $filesList[$i])[1];
                //jesli dlugosc to 16 znakow i jest plikiem (nie folderem)
                if (strlen($fileBaseName) == 16 && is_file($bname . "/" . $filesList[$i])) {

                    //wyswietlenie wpisu
                    $currentFile = fopen($bname . "/" . $filesList[$i], "r");
                    if ($currentFile != false) {
                        echo "data: " . fgets($currentFile) . "<br>";
                        echo "godzina: " . fgets($currentFile) . "<br>";
                        echo "treść wpisu: " . fgets($currentFile) . "<br>";

                        //zalaczniki
                        for ($k = 0; $k < 10; $k++) {
                            for ($j = 2; $j < sizeof($filesList); $j++) {
                                $attachmentBaseName = explode(".", $filesList[$j])[0];
                                $attachmentExtension = explode(".", $filesList[$j])[1];
                                if (strcmp($attachmentBaseName, $fileBaseName . $k) == 0) {
                                    echo '<a href="' . $bname . "/" . $filesList[$j] . '">zalacznik' . ($k + 1) . '</a>';
                                    echo "<br>";
                                }
                            }
                        }
                        echo "<br>";

                        // lista komentarzy
                        echo "KOMENTARZE:<br>";
                        $commentList = @scandir($bname . "/" . $fileBaseName . ".k");
                        if ($commentList != false) {
                            $listSize = sizeof($commentList) - 2;
                            //echo "<br>".$listSize;
                            for ($l = 0; $l < $listSize; $l++) {
                                $commentFile = fopen($bname . "/" . $fileBaseName . ".k/" . $l . ".txt", "r");
                                echo fgets($commentFile) . "<br>";
                                echo fgets($commentFile);
                                echo fgets($commentFile) . "<br>";
                                echo fgets($commentFile) . ": ";
                                echo fgets($commentFile) . "<br><br>";
                            }
                        } else {
                            echo "Nie ma jeszcze zadnych komentarzy :( <br><br>";
                        }

                        // form dodawania komentarza
                        echo "Dodaj nowy komentarz:<br>";
                        echo '<form action="koment.php" method="post">
                                Rodzaj komentarza: <br><select name="choice">
                                    <option>Pozytywny</option>
                                    <option>Neutralny</option>
                                    <option>Negatywny</option>
                                </select><br><br>
                                <textarea name="comment">Tu wpisz swój komentarz</textarea><br>
                                Nazwa użytkownika: <br><input type="text" name="signature">
                                <!--niewidoczne pola z dodatkowymi danymi-->
                                <input type="text" value="' . $bname . '" name="nazwa" hidden="hidden">
                                <input type="text" value="' . $fileBaseName . '" name="wpis" hidden="hidden">
                                <input type="submit" value="WYŚLIJ">
                                <input type="reset" value="RESET">
                            </form>';
                    } else {
                        echo "Jeszcze nie ma zadnych wpisow, dodaj swoj pierwszy!";
                    }
                }
            }
        } else {
            echo "Nie ma takiego bloga";
        }
    } else {
        echo "Nie podano nazwy, wybierz jedna z opcji powyzej :)";
    }
    ?>
    <div id="chat">
        <input type="checkbox" id="chatSwitch" onchange="switchChatOn(event)"> <-- Kliknij, żeby uruchomić czat
        <div id="chatArea" hidden>
        </div>
        <br>
        Nazwa: <input type="text" id="uname" hidden><br>
        Wiadomość: <input type="text" id="message" hidden><br><input type="button" value="WYŚLIJ" id="send" hidden
                                                          onclick="sendMessage()">
    </div>
</body>
</html>
