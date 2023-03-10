<?php declare(strict_types=1);
session_start();
$time = date('H:i:s', time());
$user = $_SESSION['user'];
$post = $_POST['post'];
$file = $_POST['file'];
$recipient = $_POST['recipient'];
if (isset($_POST['post'])) {
    $dbhost="sql207.epizy.com";
    $dbuser="epiz_32991396";
    $dbpassword="Y8UqQRCI2s";
    $dbname="epiz_32991396_z3";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$connection) {
        echo " MySQL Connection error." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $target_dir = "user_login";
    $target_file = $target_dir . "/" . basename($_FILES["fileToUpload"]["name"]);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " uploaded.";
    } else {
        echo "Error uploading file.";
    }

    $file_name = basename($_FILES["fileToUpload"]["name"]);
    if (strlen($file_name) > 0) {
        $post = $target_file;
    }
    $result = mysqli_query($connection, "INSERT INTO messages (message, user, recipient) VALUES ('$post', '$user','$recipient');") or die ("DB error: $dbname");
    mysqli_close($connection);
}
header('Location: index4.php');
?>