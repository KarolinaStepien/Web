<?php
if (isset($_POST["blogName"]) && isset($_POST["nickName"]) && isset($_POST["password"]) && isset($_POST["description"])) {
    $bn = $_POST["blogName"];
    $nn = $_POST["nickName"];
    $p = $_POST["password"];
    $d = $_POST["description"];

    $mkdir = mkdir($bn, 0777);
    if (!$mkdir) {
        echo "Tworzenie katalogu nie powiodlo sie :(";
    } else {
        $plik = fopen($bn . "/info.txt", "w");
        fwrite($plik, $nn . "\r\n" . md5($p) . "\r\n" . $d);
        fclose($plik);
        $plik2 = fopen("blog_uzytkownik.txt", "a");
        fwrite($plik2, $bn . "-->" . $nn . "\r\n");
        fclose($plik2);
    }
}
header("Location: blog.php");
?>