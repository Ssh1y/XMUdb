<?php
session_start();
$dbserver = 'localhost';
$dbuser = 'root';
$dbpwd = '123456';
$dbname = "blog";

$conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$noteid = (explode("=", $_SERVER["QUERY_STRING"]))[1];
$sql = "DELETE FROM noteuser WHERE noteid = $noteid";
echo $sql;
$result = mysqli_query($conn, $sql);
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
mysqli_close($conn);
echo "<script>alert('删除成功！');window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";