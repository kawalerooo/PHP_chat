<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</HEAD>
<BODY>
<?php
$ipaddress = $_SERVER["REMOTE_ADDR"];
$user = htmlentities($_POST['user'], ENT_QUOTES, "UTF-8");
$pass = htmlentities($_POST['pass'], ENT_QUOTES, "UTF-8");
$link = mysqli_connect( "sql207.epizy.com" , "epiz_32991396", "Y8UqQRCI2s", "epiz_32991396_z3");
if (!$link) {
    echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
} // obsługa błędu połączenia z BD
mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
$result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
$rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
if (!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
{
    mysqli_close($link); // zamknięcie połączenia z BD
    header('Location: logowanie.php');
    exit();
} else { // jeśli $rekord istnieje
    if ($rekord['password'] == $pass) // czy hasło zgadza się z BD
    {
        echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}";
        session_start();
        $_SESSION['loggedin'] = true;

        $_SESSION['user'] = $user;

        $result2 = mysqli_query($link, "SELECT * FROM goscieportalu WHERE ipaddress='$ipaddress'");
        $rekord2 = mysqli_fetch_array($result2);
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $przegladarka = array('Internet Explorer' => 'MSIE', 'Mozilla Firefox' => 'Firefox', 'Opera' => 'Opera', 'Chrome' => 'Chrome', 'Edge' => 'Edge');
        $system = array('Windows 2000' => 'NT 5.0', 'Windows XP' => 'NT 5.1', 'Windows Vista' => 'NT 6.0', 'Windows 7' => 'NT 6.1',
            'Windows 8' => 'NT 6.2', 'Windows 8.1' => 'NT 6.3', 'Windows 10' => 'NT 10', 'Linux' => 'Linux', 'iPhone' => 'iphone', 'Android' => 'android');
        foreach ($system as $nazwa => $id)
            if (strpos($agent, $id)) $system = $nazwa;
        foreach ($przegladarka as $nazwa => $id)
            if (strpos($agent, $id)) $przegladarka = $nazwa;

        $screenResolution = $_COOKIE['screenresolution'];
        $windowResolution = $_COOKIE['windowresolution'];
        $colors = $_COOKIE['colors'];
        $cookies = $_COOKIE['cookies'];
        $java = $_COOKIE['java'];
        $lang = $_COOKIE['lang'];


        mysqli_query($link, "INSERT INTO goscieportalu (ipaddress, userbrowser, resoulution, browser_resolution, screen_colors, cookies_status, java_applets_permissions, webbrowser_language, username) VALUES ('$ipaddress', '$przegladarka', '$screenResolution', '$windowResolution', '$colors', '$cookies', '$java', '$lang', '$user')");
        mysqli_close($link);
        header('Location: index4.php');

    } else {

        mysqli_close($link);
        header('Location: logowanie.php');
        exit();
    }
}
?>
</BODY>
</HTML>