<?php
if (isset($_POST["nickName"]) && isset($_POST["password"]) && isset($_POST["entry"]) && isset($_POST["date"]) && isset($_POST["time"])) {
    $plik = fopen("blog_uzytkownik.txt", "r");
    while (!feof($plik)) {
        $fileLine = fgets($plik);
        //usunięcie spacji pobieranej przez fgets()
        $fileLine = rtrim($fileLine, "\r\n");
        //pobranie nazwy użytkownika z pliku
        $uname = explode("-->", $fileLine)[1];
        //sprawdzenie zgodności nazwy użytkownika
        if ($uname == $_POST["nickName"]) {
            //sprawdzenie nazwy bloga danego użytkownika
            $bname = explode("-->", $fileLine)[0];
            //utworzenie pliku info
            $info = fopen($bname . "/info.txt", "r");
            fgets($info);
            //haslo jest w drugiej linijce
            $okLubNieHaslo = fgets($info);
            $okLubNieHaslo = rtrim($okLubNieHaslo, "\r\n");
            //echo $okLubNieHaslo == md5($_POST["password"]) ? 'true' : 'false';
            if ($okLubNieHaslo == md5($_POST["password"])) {
                $RRRRMMDD = explode("-", $_POST["date"]);
                //$RRRRMMDD = date("Ymd", strtotime($_POST["date"]));
                $GGmm = explode(":", $_POST["time"]);
                //$GGmm = date("Hi", strtotime($_POST["time"]));
                $SS = date('s');
                $fileDateHour = $RRRRMMDD[0] . $RRRRMMDD[1] . $RRRRMMDD[2] . $GGmm[0] . $GGmm[1] . $SS;
                //dla i<10 --> 0i, dla i>=10 --> i
                $i = 0;
                while (file_exists($fileDateHour . $i . "txt")) {
                    $i++;
                }
                if ($i < 10) {
                    $i = "0" . $i;
                }
                $RRRRMMDDGGmmSSUU = fopen($bname . "/" . $fileDateHour . $i . ".txt", "w");
                fwrite($RRRRMMDDGGmmSSUU, $_POST["date"] . "\r\n" . $_POST["time"] . "\r\n" . $_POST["entry"]);
                fclose($RRRRMMDDGGmmSSUU);
                //załączniki
                //echo $_FILES['file3']['name'];
                for ($j = 0; $j < sizeof($_FILES); $j++) {
                    if (sizeof($_FILES["file" . ($j + 1)]["name"]) > 0) {
                        $uploaddir = $bname;
                        $fileName = $_FILES["file" . ($j + 1)]["name"];
                        $extension = explode(".", $fileName)[sizeof(explode(".", $fileName)) - 1];
                        $uploadfile = $uploaddir . "/" . $fileDateHour . $i . $j . "." . $extension;
                        //echo $uploadfile;
                        move_uploaded_file($_FILES["file" . ($j + 1)]["tmp_name"], $uploadfile);
                    }
                }

            } else {
                echo "Zle haslo";
            }
            break;
        }

    }
    fclose($plik);
}
?>