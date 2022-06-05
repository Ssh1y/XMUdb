<?php
session_start();

$salt = '$6$rounds=5000$xmudatabase$';
$dbserver = 'localhost';
$dbuser = 'root';
$dbpwd = '123456';
$dbname = "blog";


$username = $_POST['username'];
$passwd = crypt($_POST['password'],$salt);

$conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM userinfo WHERE username = '$username' AND passwd = '$passwd'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $userid = $row['userid'];
    $_SESSION['USER'] = $userid;
    echo "<script>alert('欢迎用户：$username');window.location.href='index.php'</script>";
}
else{
    echo "<script>alert('用户名或密码错误');window.location.href='sign_in.html'</script>";
}
mysqli_close($conn);