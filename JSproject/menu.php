<?php
echo "MENU:<br>";
$blogsFile = fopen("blog_uzytkownik.txt", "r");
while (!feof($blogsFile)) {
    $fileLine = fgets($blogsFile);
    $fileLine = rtrim($fileLine, "\r\n");
    $bname = explode("-->", $fileLine)[0];
    echo '<a href = "blog.php?nazwa=' . $bname . '">' . $bname . '</a><br>';
}
?>
<a href="newBlogForm.html">Zaloz nowy blog</a><br>
<a href="newEntry.html">Dodaj wpis na blog</a><br>
