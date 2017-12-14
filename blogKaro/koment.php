<?php
if (isset($_POST["nazwa"]) && isset($_POST["wpis"]) && isset($_POST["comment"]) && isset($_POST["signature"])) {
    $bname = $_POST["nazwa"];
    $entryName = $_POST["wpis"];
    $content = $_POST["comment"];
    $signature = $_POST["signature"];
    $commentType = $_POST["choice"];
    $dir = @opendir($bname . "/" . $entryName . ".k");
    if ($dir == false) {
        mkdir($bname . "/" . $entryName . ".k");
    }
    $commentList = scandir($bname . "/" . $entryName . ".k");
    $listSize = sizeof($commentList) - 2;
    $newComment = fopen($bname . "/" . $entryName . ".k/" . ($listSize) . ".txt", "w");
    fwrite($newComment, $commentType . "\r\n");
    fwrite($newComment, date("d M Y") . "\r\n");
    fwrite($newComment, date("H:i") . "\r\n");
    fwrite($newComment, $signature . "\r\n");
    fwrite($newComment, $content);
    fclose($newComment);
    header("Location: blog.php?nazwa=" . $bname);
}
?>
