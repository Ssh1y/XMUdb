<?php
require('admin.php');
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type == 0) { //新增公告
        $title = $_POST['title'];
        $content = $_POST['content'];
        $result = $admin->set_announcement($title, $content);
        if ($result) {
            echo '<script>window.history.back(-1);</script>';
        } else {
            echo '<script>alert("添加失败");window.history.back(-1);</script>';
        }
    }
    if ($type == 1) { //删除公告
        $noticeid = $_GET['noticeid'];
        $result = $admin->delete_announcement($noticeid);
        if ($result) {
            echo '<script>alert("删除成功");window.history.back(-1);</script>';
        } else {
            echo '<script>alert("删除失败");window.history.back(-1);</script>';
        }
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
    <title>查看公告</title>
</head>

<body>
    <?php require_once(__DIR__ . '/../static/nav.php'); ?>
    <div class="container">
        <?php
        // 获取所有公告
        $notices = $admin->get_all_announcement();

        // 若没有公告，则提示
        if (empty($notices)) {
            echo "<h2>暂时没有公告，请<button type=\"button\" class=\"btn btn-link btn-lg\" data-toggle=\"modal\" data-target=\"#addnotice\">新增</button></h2>";
        } else {
            echo "<h2><button type=\"button\" class=\"btn btn-link btn-lg\" data-toggle=\"modal\" data-target=\"#addnotice\">新增公告</button></h2>";
            foreach ($notices as $notice) {
                $noticeid = $notice['announcementid'];
                $title = $notice['title'];
                $content = $notice['content'];
                $created_at = $notice['created_at'];
                echo "<div class=\"panel panel-warning\">";
                echo "<div class=\"panel-heading\">";
                echo "<h3 class=\"panel-title\">$title</h3>";
                echo "</div>";
                echo "<div class=\"panel-body\">";
                echo "<p>$content</p>";
                echo "</div>";
                echo "<div class=\"panel-footer\">";
                echo "<small>ADMIN&nbsp&nbsp发布时间：$created_at</small>&nbsp&nbsp";
                echo "<a href=\"notice.php?type=1&noticeid=$noticeid\" class=\"btn btn-danger btn-xs\">删除</a>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
        <div class="modal fade" id="addnotice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            添加公告
                        </h4>
                    </div>
                    <form action="notice.php?type=0" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">标题</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="标题" required>
                            </div>
                            <div class="form-group">
                                <label for="content">内容</label>
                                <textarea class="form-control" rows="3" name="content" id="content" placeholder="内容" required style="resize: none;"></textarea>
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
                </div>
            </div>
        </div>
    </div>
</body>
</html>