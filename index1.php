<form method="POST" action="add2.php" enctype="multipart/form-data"><br>

    Nick:<input type="text" name="user" maxlength="10" size="10"><br>
    Post:<input type="text" name="post" maxlength="90" size="90"><br>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Send"/>
</form>

<?php
$dbhost = "sql207.epizy.com";
$dbuser = "epiz_32991396";
$dbpassword = "Y8UqQRCI2s";
$dbname = "epiz_32991396_z3";
$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
if (!$connection) {
    echo " MySQL Connection error." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$result = mysqli_query($connection, "Select * from messages ORDER BY idk DESC") or die ("DB error: $dbname");
print "<TABLE CELLPADDING=5 BORDER=1>";
print "<TR><TD>id</TD><TD>Date/Time</TD><TD>User</TD><TD>Message</TD></TR>\n";
while ($row = mysqli_fetch_array($result)) {
    $id = $row[0];
    $date = $row[1];
    $message = $row[2];
    $user = $row[3];

    if (strpos($message, '.jpg')) {
        $message = "<img src ='$message'>";
    } else if (strpos($message, '.png')) {
        $message = "<img src ='$message'>";
    } else if (strpos($message, '.gif')) {
        $message = "<img src ='$message'>";
    } else if (strpos($message, '.mp3')) {
        $message = "<audio controls src ='$message'> </audio>";
    } else if (strpos($message, '.mp4')) {
        $message = "<video controls width='250' autoplay='true' muted='true'> <source src=''$message'></video>";
    }

    print "<TR><TD>$id</TD><TD>$date</TD><TD>$user</TD><TD>$message</TD></TR>\n";


}
print "</TABLE>";
mysqli_close($connection);
?>