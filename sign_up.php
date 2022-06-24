<?php
require('Universal/class.php');
$username = $_POST['username'];
$password = $_POST['password'];

if ($username && $password) {
    if ($user->sign_up($username, $password)) {
        echo '<script>alert("注册成功,点击跳转到登陆页面~")</script>';
        header('Location: sign_in.php');
    } else {
        echo '<script>alert("注册失败，请重试")</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>注册</title>

    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/sign_in.css">
    <script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://apps.bdimg.com/libs/bootstrap/3.3.0/js/bootstrap.min.js"></script>

</head>

<body>
    <div class="container">
        <div class="form row">
            <form class="form-horizontal col-sm-offset" role="form" action="sign_up.php" method="post">
                <h3 class="form-title">注册</h3>
                <div class="col-sm-9">
                    <div class="form-group">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input class="form-control required" type="text" name="username" id="username" placeholder="请输入用户名" required>
                    </div>
                    <div class="form-group">
                        <i class="fa fa-key" aria-hidden="true"></i>
                        <input class="form-control required" type="password" name="password" id="password" placeholder="请输入密码" required>
                    </div>
                    <div class="form-group">
                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                        <input class="form-control required" type="password" name="resetpw" id="resetpw" placeholder="请确认密码" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="注册" class="btn btn-primary pull-right">
                        <input type="button" onclick="javascript:window.location.href='index.php'" class="btn btn-info pull-left" id="back_btn" value="返回" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>