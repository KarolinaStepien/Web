<?php
$con = mysqli_connect("localhost", "root", "") or die ("Could not connect to MySQL!");
mysqli_select_db($con, "chatbox") or die ("Database not found!");
if ($_REQUEST['type'] == 'send') {
    $uname = $_REQUEST['uname'];
    $msg = $_REQUEST['msg'];

    $con->query("INSERT INTO logs (`username` , `msg`) VALUES ('$uname','$msg')");

    $result = $con->query("select count(*) as 'c' from logs");
    $result2 = mysqli_fetch_array($result);
    if ($result2['c'] > 5) {
        $con->query("delete from logs order by id asc limit 1");
    }
}

$result1 = $con->query("SELECT * FROM logs ORDER by id DESC");

while ($extract = mysqli_fetch_array($result1)) {
    echo "<span class='uname'>" . $extract['username'] . " : " . "</span:<span class='msg'>" . $extract['msg'] . "</span><br>";
}
mysqli_close($con);
?>

