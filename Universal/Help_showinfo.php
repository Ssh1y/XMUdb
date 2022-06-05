<?php
session_start();

if (!isset($_SESSION['USER']))
    die("<script>window.location.href='index.php'</script>");

    
$dbserver = 'localhost';
$dbuser = 'root';
$dbpwd = '123456';
$dbname = "blog";

$conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['USER'])) {
    $userid = $_SESSION['USER'];
    $sql = "SELECT * FROM userinfo WHERE userid = '$userid'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_assoc($result)) {
            $username = $row['username'];
            $gender = $row['gender'];
            $intro = $row['intro'];
            $email = $row['email'];
            $phone_number = $row['phone_number'];
            $avatar = $row['avatar'];
        }
    }
}
mysqli_close($conn);