<?php
require('Universal/class.php');
if (!isset($_SESSION['USER'])) {
    header("Location: sign_in.php");
}

$title = '';
$content = '';

if (isset($_GET['type'])) {
    $note = $blog->show_note_detail($_GET['noteid'], $_SESSION['USER']);
    $title = $note['title'];
    $content = $note['content'];
}

if ($_POST['title'] && $_POST['content']) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    if ($user->add_note($title, $content))
        echo "<script>alert('文章发布成功！');history.go(-1);</script>";
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>厦大博客</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/abstract.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
            <?php
            if (!isset($_SESSION['USER'])) {
                echo "<ul class=\"nav navbar-nav navbar-right\">";
                echo "<li><a href=\"sign_up.php\"><span class=\"glyphicon glyphicon-user\"></span> 注册</a></li>";
                echo "<li><a href=\"sign_in.php\"><span class=\"glyphicon glyphicon-log-in\"></span> 登录</a></li>";
                echo "</ul>";
            } elseif ($_SESSION['USER'] != 'admin') {
                $result = $user->show_profile();
                $result = mysqli_fetch_object($result);
                $avatar = $result->avatar;
                echo "<ul class=\"nav navbar-nav navbar-right\">";
                echo "<li><img src=\"$avatar\" style=\"width:45px;border-radius: 50%;\"></li>";
                echo "<li class=\"dropdown\">";
                echo "<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">";
                $_SESSION['USERNAME'];
                echo "<span class=\"caret\"></span>";
                echo "</a>";
                echo "<ul class=\"dropdown-menu\">";
                echo "<li><a href=\"Home_page.php\"><i class=\"glyphicon glyphicon-user\"></i> 个人主页</a></li>";
                echo "<li><a href=\"Edit_info.php\"><i class=\"glyphicon glyphicon-edit\"></i> 编辑资料</a></li>";
                echo "<li><a href=\"Write_blog.php\"><i class=\"glyphicon glyphicon-book\"></i> 写文章</a></li>";
                echo "<li class=\"divider\"></li>";
                echo "<li><a href=\"logout.php\"><i class=\"glyphicon glyphicon-log-out\"></i> 退出登录</a></li>";
                echo "</ul>";
                echo "</li>";
                echo "</ul>";
            } else {
                echo "<ul class=\"nav navbar-nav navbar-righ\">";
                echo "<li class=\"dropdown\">";
                echo "<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">";
                echo "管理员";
                echo "<span class=\"caret\"></span>";
                echo "</a>";
                echo "<ul class=\"dropdown-menu\">";
                echo "<li><a href=\"#\">管理博客</a></li>";
                echo "<li><a href=\"#\">编辑公告</a></li>";
                echo "<li><a href=\"#\">设置投票</a></li>";
                echo "<li class=\"divider\"></li>";
                echo "<li><a href=\"./Universal/logout.php\">退出登录</a></li>";
                echo "</ul>";
                echo "</li>";
                echo "</ul>";
            }
            ?>
        </div>
    </nav>
    <div class="container">
        <form role="form" action="Write_blog.php" method="POST">
            <input name="title" style="border:none;outline:medium;padding: 20px 10px;width:100%;font-size: 30px;font-weight: 700;" placeholder="请输入标题" value="<?php echo $title; ?>" required>
            <button type="submit" class="btn btn-default" style="float:right;">
                发布文章
            </button>
            <hr>
            <textarea name="content" class="well" style="border:none;outline:medium;padding:20px 10px;width:100%;height:500px;resize: none;" placeholder="请输入正文" maxlength="3000" required><?php echo $content;?></textarea>
        </form>
    </div>
    </body>

</html>