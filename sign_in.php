<?php
require('Universal/class.php');

$username = $_POST['username'];
$passwd = $_POST['password'];

if($user->is_exist($username)){
    if($user->sign_in($username, $passwd)){
        echo '<script>alert("登录成功")</script>';
        header('Location: index.php');
    }else{
        echo '<script>alert("帐号或密码错误！或者用户不存在")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>登录</title>

    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/sign_in.css">
    <script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://apps.bdimg.com/libs/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="form row">
        <form class="form-horizontal col-sm-offset-2 col-md-offset-2" role="form" style="margin-top: 150px;" action="sign_in.php" method="post">
            <h3 class="form-title">登录</h3>
            <div class="col-sm-9">
                <div class="form-group">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <input class="form-control" type="text" name="username" id="username" placeholder="请输入用户名" required autofocus>
                </div>
                <div class="form-group">
                    <i class="fa fa-key" aria-hidden="true"></i>
                    <input class="form-control " type="password" name="password" id="password" placeholder="请输入密码" required>
                </div>
                <div class="form-group">
                    <br>
                    <a href="sign_up.php">没有账号？立即注册</a>
                </div>
                <div class="form-group">
                    <input type="submit" value="登录" class="btn btn-success pull-right">
                </div>

            </div>
        </form>
    </div>
</div>
</body>
</html>