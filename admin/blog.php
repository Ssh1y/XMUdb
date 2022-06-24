<?php
require('admin.php');

//删除博客文章
if (isset($_GET['noteid'])) {
    $noteid = $_GET['noteid'];
    $userid = $_GET['userid'];
    $result = $admin->delete_user_note($noteid, $userid);
    if ($result) {
        echo '<script>alert("删除成功");window.history.back(-1);</script>';
    } else {
        echo '<script>alert("删除失败");window.history.back(-1);</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require(__DIR__ . '/../static/header.php'); ?>
    <title>管理博客</title>
</head>

<body>
    <?php require_once(__DIR__ . '/../static/nav.php'); ?>
    <div class="container">
        <?php
        if (!isset($_GET['userid']) || !isset($_GET['type'])) {
            $users = $admin->get_all_user();
            foreach ($users as $user) {
                $userid = $user['userid'];
                $username = $user['username'];
                $avatar = '/XMUdb/' . $user['avatar'];
                // var_dump($avatar);
                echo "<div class=\"col-sm-6 col-md-3\">";
                echo "<div class=\"thumbnail\">";
                echo "<img src=\"$avatar\" alt=\"$username\">";
                echo "<div class=\"caption\">";
                echo "<h3>$username</h3>";
                echo "<p>";
                echo "<a href=\"/../XMUdb/admin/blog.php?userid=$userid&type=0\" class=\"btn btn-primary\" role=\"button\">查看所有博客</a>&nbsp&nbsp&nbsp";
                echo "<a href=\"/../XMUdb/admin/blog.php?userid=$userid&type=1\" class=\"btn btn-default\" role=\"button\">删除该用户</a>";
                echo "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            $userid = $_GET['userid'];
            $userinfo = $admin->show_userinfo($userid);
            // die(var_dump($userinfo[0]['avatar']));
            echo "<h1><center>" . $userinfo[0]['username'] . "</center></h1>";
            $type = $_GET['type'];
            if ($type == 0) { // 查看所有博客
                $blogs = $blog->show_notes($userid);
                //若没有博客，则提示
                if (empty($blogs)) {
                    echo "<h2>没有博客</h2>";
                } else {
                    foreach ($blogs as $blog) {
                        $noteid = $blog['noteid'];
                        $title = $blog['title'];
                        $content = $blog['content'];
                        $created_at = $blog['created_at'];
                        echo "<div class=\"panel panel-warning\">";
                        echo "<div class=\"panel-heading\">";
                        echo "<h3 class=\"panel-title\">$title</h3>";
                        echo "</div>";
                        echo "<div class=\"panel-body\">";
                        echo "<p>$content</p>";
                        echo "</div>";
                        echo "<div class=\"panel-footer\">";
                        echo "<p>$created_at</p>";
                        echo "<a href=\"/../XMUdb/admin/blog.php?userid=$userid&noteid=$noteid\" class=\"btn btn-default\" role=\"button\">删除该博客</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "<br />";
                    }
                }
            }
            if ($type == 1) { // 删除该用户
                $result = $admin->delete_user($userid);
                if ($result) {
                    echo '<script>alert("删除成功");window.history.back(-1);</script>';
                } else {
                    echo '<script>alert("删除失败");window.history.back(-1);</script>';
                }
            }
        }
        ?>
    </div>
</body>

</html>