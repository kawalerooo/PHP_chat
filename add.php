<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>
<BODY>
<?php
$user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8");
$pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8");
$pass_repeat = htmlentities ($_POST['pass_repeat'], ENT_QUOTES, "UTF-8");
$link = mysqli_connect( "sql207.epizy.com" , "epiz_32991396", "Y8UqQRCI2s", "epiz_32991396_z3");
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }
mysqli_query($link, "SET NAMES 'utf8'");
$result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'");
$rekord = mysqli_fetch_array($result);
if(!$rekord)
{

    if($pass == $pass_repeat) {

        mysqli_query($link, "INSERT INTO users (username, password) VALUES ('$user','$pass')");
        mysqli_close($link);
        echo "Rejestracja udana, $user Jego hasło to $pass";


    } else {
        echo "Hasła nie są takie same";
    }
    } else {
    echo "Taki użytkownik już istnieje";

}

?>
</BODY>
</HTML>