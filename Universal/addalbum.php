<?php
// 接收文件
session_start();

function addalbum($userid, $avatar)
{
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $avatar);
    // echo $_FILES["inputalbum"]["size"];
    $extension = end($temp);     // 获取文件后缀名
    if ((($_FILES["inputalbum"]["type"] == "image/gif")
            || ($_FILES["inputalbum"]["type"] == "image/jpeg")
            || ($_FILES["inputalbum"]["type"] == "image/jpg")
            || ($_FILES["inputalbum"]["type"] == "image/pjpeg")
            || ($_FILES["inputalbum"]["type"] == "image/x-png")
            || ($_FILES["inputalbum"]["type"] == "image/png"))
        && ($_FILES["inputalbum"]["size"] < 2048000)   // 小于 2mb
        && in_array($extension, $allowedExts)
    ) {
        if ($_FILES["inputalbum"]["error"] > 0) {
            // echo "错误：: " . $_FILES["inputalbum"]["error"] . "<br>";
            return "";
        } else {
            if (!file_exists("../upload/$userid/")) {
                mkdir("../upload/$userid/");
            }
            if (!file_exists("../upload/$userid/album/")) {
                mkdir("../upload/$userid/album/");
            }
            move_uploaded_file($_FILES["inputalbum"]["tmp_name"], "../upload/$userid/album/" . md5(time()) . ".$extension");
            return "upload/$userid/album/" . md5(time()) . ".$extension";
        }
    } else {
        // echo "非法的文件格式";
        return "";
    }
}


$dbserver = 'localhost';
$dbuser = 'root';
$dbpwd = '123456';
$dbname = "blog";

$conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$userid = $_SESSION['USER'];
$avatar = $_FILES["inputalbum"]["name"];
$albumaddr = addalbum($userid, $avatar);
if ($albumaddr != "") {
    $alt = $_POST['alt'];
    $time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO useralbum(userid,album,alt,Ptime) VALUES($userid,'$albumaddr','$alt','$time')";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
}
mysqli_close($conn);
echo "<script>window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";