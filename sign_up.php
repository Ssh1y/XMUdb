<?php

$salt = '$6$rounds=5000$xmudatabase$';
$dbserver = 'localhost';
$dbuser = 'root';
$dbpwd = '123456';
$dbname = "blog";


$username = $_POST['username'];
$passwd = crypt($_POST['password'], $salt);
$resetpw = crypt($_POST['resetpw'], $salt);
$email = $_POST['email'];

if ($passwd != $resetpw) {
    die("<script>alert('两次密码不一致！');window.location.href='sign_up.html'</script>");
}
$conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO userinfo(username,passwd,email) VALUES('$username','$passwd','$email')";

$result = mysqli_query($conn, $sql);
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

echo "<script>alert('注册成功！即将返回登录界面...');window.location.href='sign_in.html'</script>";
mysqli_close($conn);