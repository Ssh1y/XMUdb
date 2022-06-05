<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>厦大博客</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/abstract.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php require_once("./Universal/pre.php"); ?>
    <?php require_once("./Universal/id2another.php"); ?>
    <?php require_once("./Universal/RecomNote.php"); ?>
    <?php require_once("./Universal/listinfo.php"); ?>
    <?php require_once("./Universal/Pre_annous.php"); ?>
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
                        <li><a href="write.php"><i class="glyphicon glyphicon-book"></i> 写文章</a></li>
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
        <div class="col-sm-9">

            <ul class="breadcrumb">
                <li class="active">推荐文章</li>
            </ul>
            <?php
            $Recresult = RecomNote();
            if (mysqli_num_rows($Recresult) > 0) {
                while ($row = $Recresult->fetch_assoc()) {
                    echo "
                        <a class=\"lead text-primary\" target=\"_blank\" href=\"article.php?noteid=" . $row['noteid'] . "\">
                            " . $row['title'] . "
                        </a>
                        <p class=\"abstract\">" .
                        mb_substr($row['content'], 0, 250, 'utf-8') . "...
                        <br />
                        </p>
                        作者：" . id2another($row['userid'], 'username') . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp发布日期：" . $row['Ptime'] . "
                        <hr>";
                }
            }
            ?>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        公告
                        <span class="glyphicon glyphicon-bullhorn"></span>
                    </h2>
                </div>
                <div class="panel-body">
                    <?php
                    $result = pre_annous();
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<small>发布时间：".$row['Ptime']."</small>";
                            echo "<p>".$row['annou']."</p>";
                            echo "<hr>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="panel panel-info" id="personal_album" style="display: none;">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        个人相册
                    </h2>
                </div>
                <div class="panel-body">
                    <?php
                    $result = listinfo($_SESSION['USER'], 'useralbum');
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<a href=\"" . $row['album'] . "\"><img src=\"" . $row['album'] . "\" class=\"img-thumbnail\" width=\"100%\"></a>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </body>

</html>