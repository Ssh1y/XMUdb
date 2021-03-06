<?php
require('Universal/class.php');

if (!isset($_SESSION['USER'])) {
    header("Location: sign_in.php");
}

$profile = $user->show_profile();
$profile = mysqli_fetch_object($profile);
$avatar = $profile->avatar;
$gender = $profile->gender;
$email = $profile->email;
$phone_number = $profile->phone_number;
$intro = $profile->intro;

$array = array();
if ($_POST['gender'])
    $array['gender'] = $_POST['gender'];
if ($_POST['email'])
    $array['email'] = $_POST['email'];
if ($_POST['phone_number'])
    $array['phone_number'] = $_POST['phone_number'];
if ($_POST['intro'])
    $array['intro'] = $_POST['intro'];
if ($_FILES['file'])
    $array['file'] = $_FILES['file'];
//判断array是否为空
if (!empty($array)) {
    $user->update_profile($array);
    echo "<script>alert('修改成功！');history.go(-1);</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>修改个人信息</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">厦大博客</a>
            </div>
    </nav>
    <div class="container">
        <form class="form-horizontal" role="form" style="margin-top:60px;background-color:aliceblue;" method="post" enctype="multipart/form-data">
            <h2>修改个人信息</h2>
            <div class="form-group">
                <label class="col-sm-3 control-label">头像</label>
                <div class="col-sm-6">
                    <img src="<?php echo $avatar; ?>" style="width:45px;border-radius: 50%;">
                    <hr />
                    <input type="file" id="inputfile" name="file">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">用户ID</label>
                <div class="col-sm-6">
                    <input class="form-control" name="userid" type="text" readonly value=<?php echo $_SESSION['USER']; ?>>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">昵称</label>
                <div class="col-sm-6">
                    <input class="form-control" name="username" type="text" value=<?php echo $_SESSION['USERNAME']; ?> required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">性别</label>
                <div class="col-sm-6">
                    <input class="form-control" name="gender" type="text" value=<?php echo $gender; ?>>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">邮箱</label>
                <div class="col-sm-6">
                    <input class="form-control" name="email" type="email" value=<?php echo $email; ?>>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">联系方式</label>
                <div class="col-sm-6">
                    <input class="form-control" name="phone_number" type="tel" value=<?php echo $phone_number; ?>>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">个人介绍</label>
                <div class="col-sm-6">
                    <input class="form-control" name="intro" type="text" placeholder="这个人太懒了，什么都没留下" value=<?php echo $intro; ?>>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-primary">修改</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>