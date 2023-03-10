<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</HEAD>
<BODY>
<?php
$ipaddress = $_SERVER["REMOTE_ADDR"];
$link = mysqli_connect( "sql207.epizy.com" , "epiz_32991396", "Y8UqQRCI2s", "epiz_32991396_z3");
if (!$link) {
    echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
}
mysqli_query($link, "SET NAMES 'utf8'");

session_start();
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
<th>Screen resolution</th>
<th>Browser resolution</th>
<th>Screen colors</th>
<th>Cookies stauts</th>
<th>Java applets status</th>
<th>Browser language</th>
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
   // echo "<td>" . $system . "</td>";
    echo "<td>" . $dataCookies[4] . "</td>";
    echo "<td>" . $dataCookies[5] . "</td>";
    echo "<td>" . $dataCookies[6] . "</td>";
    echo "<td>" . $dataCookies[7] . "</td>";
    echo "<td>" . $dataCookies[8] . "</td>";
    echo "<td>" . $dataCookies[9] . "</td>";
    echo "<td><a href='https://www.google.pl/maps/place/$details->loc'>LINK</a><td> ";
    echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "<br>";
echo "<font size='5'><a href='index4.php'>Powrót do panelu użytkownika</a></font>>"

?>
</BODY>
</HTML>

