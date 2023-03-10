<?php declare(strict_types=1);
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: logowanie.php');
    exit();
}
?>
<html>
<head><title>Kawalerski</title></head>
<body>
<p><b><font size="5" color="black">ZADANIE 3 - KOMUNIKATOR</font></b></p>
<td></td>
<form method="POST" action="add3.php" enctype="multipart/form-data"><br>

    Post:<input type="text" name="post" maxlength="90" size="90"><br>
    <label for="recipient:">Lista odbiorców : </label>
    <select id="recipient" name="recipient">
        <?php
        $link = mysqli_connect("sql207.epizy.com", "epiz_32991396", "Y8UqQRCI2s", "epiz_32991396_z3");
        $result = mysqli_query($link, "SELECT username FROM users");
        $rekord = mysqli_fetch_all($result);
        foreach ($rekord as $value) {
            echo "<option value ='$value[0]'>$value[0]</option>";
        }
        ?>
    </select>
    <br>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Send"/>
    <br>
</form>
<html>
<?php
$username = $_SESSION['user'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$result = mysqli_query($link, "SELECT * FROM goscieportalu WHERE username='$username'");
$rekord = mysqli_fetch_all($result);
$system = array('Windows 2000' => 'NT 5.0', 'Windows XP' => 'NT 5.1', 'Windows Vista' => 'NT 6.0', 'Windows 7' => 'NT 6.1',
    'Windows 8' => 'NT 6.2', 'Windows 8.1' => 'NT 6.3', 'Windows 10' => 'NT 10', 'Linux' => 'Linux', 'iPhone' => 'iphone', 'Android' => 'android');
foreach ($system as $nazwa => $id)
    if (strpos($agent, $id)) $system = $nazwa;

function ip_details($ip)
{
    $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
    return json_decode($json);
}

echo "<table border='1'>
    <tr>
        <th>Date of login</th>
        <th>Region</th>
        <th>Country</th>
        <th>City</th>
        <th>Ioc</th>
        <th>IP</th>
        <th>Browser</th>
        <th>Google Maps</th>
    </tr>";


foreach ($rekord as $dataCookies) {

    $details = ip_details($dataCookies[1]);

    echo "<tr>";
    echo "<td>" . $dataCookies[2] . "</td>";
    echo "<td>" . $details->region . "</td>";
    echo "<td>" . $details->country . "</td>";
    echo "<td>" . $details->city . "</td>";
    echo "<td>" . $details->loc . "</td>";
    echo "<td>" . $details->ip . "</td>";
    echo "<td>" . $dataCookies[3] . "</td>";
    echo "<td><a href='https://www.google.pl/maps/place/$details->loc'>LINK</a></td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "<br>";
?>
</BODY>
</HTML>

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
$user = $_SESSION['user'];
$result = mysqli_query($connection, "SELECT * FROM messages WHERE user = '$user' OR recipient = '$user' ORDER BY idk DESC") or die ("DB error: $dbname");
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
        $message = "<video controls width='250' autoplay='true' muted='true'> <source src='$message'></video>";
    }

    print "<TR><TD>$id</TD><TD>$date</TD><TD>$user</TD><TD>$message</TD></TR>\n";

}
print "</TABLE>";
mysqli_close($connection);
?>
