<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>文章</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/NoteBody.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php require_once("./Universal/Help_article.php"); ?>
    <?php require_once("./Universal/pre.php"); ?>
    <?php require_once("./Universal/id2another.php"); ?>
</head>

<body onload="check_session()">
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
                <li><img src="<?php echo id2another($_SESSION['USER'],'avatar')?>" style="width:45px;border-radius: 50%;"></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo id2another($_SESSION['USER'],'username'); ?>
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
        <section>
            <h2><?php echo $title; ?></h2>
            <div class="notebody">
                <?php
                $sentence = (explode("。", $content));
                for ($index = 0; $index < sizeof($sentence) - 1; $index++) {
                    echo "<p>" . $sentence[$index] . "。</p>";
                }
                echo "<p>" . $sentence[$index] . "</p>";
                ?>
            </div>
        </section>
        <hr>
        <section>
            <div class="media">
                <div class="media-left" style="display: none;" id="avatar">
                    <img src="<?php echo id2another($_SESSION['USER'],'avatar');?>" class="media-object" style="width:45px;border-radius: 50%;">
                    <br />
                </div>
                <form class="media-body" name="commenting" method="post" action="article.php?noteid=<?php echo $noteid; ?>">
                    <textarea required class="form-control" name="commentary" placeholder="留下你的评论" style="resize: none;width: 100%;height: 100px;font-size: larger;" maxlength="100"></textarea>
                    <br />
                    <button type="submit" class="btn btn-primary" disabled id="submitbtn">提交</button>
                </form>
            </div>
            <h3>精选评论</h3>
            <?php
                    if (mysqli_num_rows($comresult) > 0) {
                        while ($row = $comresult->fetch_assoc()) {
                            echo "
                                <div class=\"media\">
                                    <div class=\"media-left\">
                                        <img src=\"".id2another($row['commenter'],'avatar')."\" class=\"media-object\" style=\"width:45px;border-radius: 50%;\">
                                    </div>
                                    <div class=\"media-body\">
                                        <h4 class=\"media-heading\">" . id2another($row["commenter"],'username') . " <small><i>Posted on " . $row["comtime"] . "</i></small></h4>
                                        <p>" . $row["commentary"] . "</p>
                                    </div>
                                </div>
                                <hr>
                                ";
                        }
                    }
                    ?>
        </section>
    </div>
</body>

</html>