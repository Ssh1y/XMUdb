<?php

// 接收文件
function receive_avatar($userid, $avatar)
{
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $avatar);
    echo $_FILES["file"]["size"];
    $extension = end($temp);     // 获取文件后缀名
    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 204800)   // 小于 200 kb
        && in_array($extension, $allowedExts)
    ) {
        if ($_FILES["file"]["error"] > 0) {
            // echo "错误：: " . $_FILES["file"]["error"] . "<br>";
            return "";
        } else {
            $avataraddr = "../upload/$userid/" . $userid . "." . $extension;
            if (!file_exists("../upload/$userid/")) { // 若用户是初始头像
                mkdir("../upload/$userid/");
                move_uploaded_file($_FILES["file"]["tmp_name"], $avataraddr);
            } elseif(file_exists($avataraddr)) {       //用户修改头像
                unlink($avataraddr);
                move_uploaded_file($_FILES["file"]["tmp_name"], $avataraddr);
            }
            else{
                move_uploaded_file($_FILES["file"]["tmp_name"], $avataraddr);
            }
            return "upload/$userid/" . $userid . "." . $extension;
        }
    } else {
        // echo "非法的文件格式";
        return "";
    }
}

// 更新信息
$dbserver = 'localhost';
$dbuser = 'root';
$dbpwd = '123456';
$dbname = "blog";

$conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// mysqli_query($conn , "set names utf8");

$userid = $_POST['userid'];
$username = $_POST['username'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$intro = $_POST['intro'];
$avatar = $_FILES['file']['name'];
if ($avatar != "") {
    $avataraddr = receive_avatar($userid, $avatar);
    if ($avataraddr == "") {
        $sql = "UPDATE userinfo SET username = '$username',gender = '$gender',email = '$email',phone_number = '$phone_number',intro = '$intro' WHERE userid = '$userid'";
    } else {
        $sql = "UPDATE userinfo SET username = '$username',gender = '$gender',email = '$email',phone_number = '$phone_number',intro = '$intro' ,avatar = '$avataraddr' WHERE userid = '$userid'";
    }
} else {
    $sql = "UPDATE userinfo SET username = '$username',gender = '$gender',email = '$email',phone_number = '$phone_number',intro = '$intro' WHERE userid = '$userid'";
}
$result = mysqli_query($conn, $sql);
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

echo "<script>alert('修改成功！如果有修改头像请等待一会头像刷新');window.location.href='../showinfo.php'</script>";
mysqli_close($conn);
