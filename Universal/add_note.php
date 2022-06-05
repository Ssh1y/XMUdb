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

$title = $_POST['title'];
$content = $_POST['content'];
$wc = iconv_strlen($content, 'UTF-8');
$time = date("Y-m-d H:i:s");
$userid = $_SESSION['USER'];
if ($noteid = (explode("=", $_SERVER["QUERY_STRING"]))[1])
    $sql = "UPDATE noteuser SET Ptime = '$time',wc = $wc,content = '$content',title = '$title' WHERE noteid = '$noteid'";
else
    $sql = "INSERT INTO noteuser(userid,Ptime,wc,content,title) VALUES($userid,'$time',$wc,'$content','$title')";
// echo $sql;
$result = mysqli_query($conn, $sql);
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
mysqli_close($conn);
echo "<script>alert('文章发布/修改成功！即将返回...');window.location.href='" . $_SERVER['HTTP_REFERER'] . "'</script>";
