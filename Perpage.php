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
                <li><img src="<?php echo $h = id2another($_SESSION['USER'], 'avatar') ?>" style="width:45px;border-radius: 50%;"></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo id2another($_SESSION['USER'], 'username'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="glyphicon glyphicon-user"></i> 个人主页</a></li>
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
        <div class="col-sm-7">
            <div class="media">
                <div class="media-left">
                    <a href="<?php echo $h; ?>"><img src="<?php echo $h; ?>" style="width:60px;border-radius: 50%;"></a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo id2another($_SESSION['USER'], 'username') ?></h4>
                    <p>发表文章数：<?php
                                $result = listinfo($_SESSION['USER'], 'noteuser');
                                echo mysqli_num_rows($result) ?></p>
                </div>
            </div>
            <hr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <a class=\"lead text-primary\" target=\"_blank\" href=\"article.php?noteid=" . $row['noteid'] . "\">
                            " . $row['title'] . "
                            <a href=\"./Universal/deletenote.php?noteid=" . $row['noteid'] . "\" style=\"float:right;\">删除</a>
                            <a href=\"write.php?noteid=" . $row['noteid'] . "\" style=\"float:right;margin-right:10px\">修改</a>
                        </a>
                        <p class=\"abstract\">" .
                        mb_substr($row['content'], 0, 250, 'utf-8') . "...
                        </p>
                        发布日期：" . $row['Ptime'] . "
                        <hr>";
                }
            }
            ?>
        </div>
        <div class="col-sm-5">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">个人相册（删除照片部分想不到怎么漂亮的实现）</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $result = listinfo($_SESSION['USER'], 'useralbum');
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<a href=\"" . $row['album'] . "\"><img src=\"" . $row['album'] . "\" class=\"img-thumbnail\" width=\"30%\"></a>";
                        }
                    }
                    ?>
                </div>
            </div>
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                新增照片
            </button>
            <!-- 模态框（Modal） -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                选择相片
                            </h4>
                        </div>
                        <form role="form" enctype="multipart/form-data" method="POST" action="./Universal/addalbum.php">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="file" name="inputalbum">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
                                    <input type="text" class="form-control" name="alt" placeholder="输入一点对照片的描述吧~" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    提交更改
                                </button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
        </div>
    </div>
    </body>

</html>