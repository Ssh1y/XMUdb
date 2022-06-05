<!DOCTYPE html>
<html>
<?php
session_start();

if (!isset($_SESSION['USER']))
    die("<script>window.location.href='index.php'</script>");
?>
<head>
    <meta charset="utf-8">
    <title>厦大博客</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/abstract.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php require_once("./Universal/pre.php"); ?>
    <?php require_once("./Universal/id2another.php"); ?>
    <?php require_once("./Universal/listinfo.php"); ?>
    <?php require_once("./Universal/alternote.php");?>
</head>

<body">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">厦大博客</a>
            </div>
            <form class="navbar-form navbar-left" role="search" method="GET" action="search_result.php">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="搜你所想" name="Search" required>
                </div>
                <button type="submit" class="btn btn-default">提交</button>
            </form>
            <ul class="nav navbar-nav navbar-right" id="noSigned">
                <li><a href="sign_up.html"><span class="glyphicon glyphicon-user"></span> 注册</a></li>
                <li><a href="sign_in.html"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right" id="Signed" style="display: none;">
                <li><img src="<?php echo id2another($_SESSION['USER'], 'avatar') ?>" style="width:45px;border-radius: 50%;"></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo id2another($_SESSION['USER'], 'username'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="Perpage.php"><i class="glyphicon glyphicon-user"></i> 个人主页</a></li>
                        <li><a href="showinfo.php"><i class="glyphicon glyphicon-edit"></i> 编辑资料</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-book"></i> 写文章</a></li>
                        <li class="divider"></li>
                        <li><a href="./Universal/logout.php"><i class="glyphicon glyphicon-log-out"></i> 退出登录</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right" id="admin" style="display: none;">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        ADMIN
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">管理博客</a></li>
                        <li><a href="#">编辑公告</a></li>
                        <li><a href="#">设置投票</a></li>
                        <li class="divider"></li>
                        <li><a href="./Universal/logout.php">退出登录</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <?php $title = check_alter_or_add()[0];$content = check_alter_or_add()[1];?>
        <form role="form" action="./Universal/add_note.php<?php if($_SERVER["QUERY_STRING"]){echo "?".$_SERVER["QUERY_STRING"];}?>" method="POST">
            <input name="title" style="border:none;outline:medium;padding: 20px 10px;width:100%;font-size: 30px;font-weight: 700;" placeholder="请输入标题" value="<?php if($title){echo $title;}else{echo "";}?>" required>
            <button type="submit" class="btn btn-default" style="float:right;">
                发布文章
            </button>
            <hr>
            <textarea name="content" class="well" style="border:none;outline:medium;padding:20px 10px;width:100%;height:500px;resize: none;" placeholder="请输入正文" maxlength="3000" required><?php if($content){echo $content;}else{echo "";}?></textarea>
        </form>
    </div>
    </body>

</html>