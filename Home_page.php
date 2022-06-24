<?php
require('Universal/class.php');
if (!isset($_SESSION['USER'])) {
    header("Location: sign_in.php");
}

$notes = $blog->show_notes($_SESSION['USER']);
// var_dump($notes);
$note_num = sizeof($notes);

$photos = $blog->show_album($_SESSION['USER']);
// var_dump($photos);

//删除文章
if (isset($_GET['type'])) {
    $byebye = $_GET['noteid'];
    if ($user->delete_note($byebye)) {
        echo "<script>alert('删除成功！');history.go(-1);</script>";
    }
}
//接收上传图片
if (isset($_FILES['photo'])) {
    // var_dump($_FILES['photo']);
    $description = $_POST['alt'];
    $photo = $_FILES['photo'];
    if ($user->add_photo($photo, $description)) {
        echo "<script>alert('上传成功！');history.go(-1);</script>";
    }
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
    <?php require_once('static/nav.php'); ?>
    <div class="container">
        <div class="col-sm-7">
            <div class="media">
                <div class="media-left">
                    <a href="<?php echo $avatar; ?>"><img src="<?php echo $avatar; ?>" style="width:60px;border-radius: 50%;"></a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $_SESSION['USERNAME'] ?></h4>
                    <p>发表文章数：<?php echo $note_num; ?>
                    </p>
                </div>
            </div>
            <hr>
            <?php
            foreach ($notes as $note) {
                echo "
                        <a class=\"lead text-primary\" target=\"_blank\" href=\"note.php?noteid=" . $note['noteid'] . "&note_owner=" . $note['userid'] . "\">
                            " . $note['title'] . "
                            <a href=\"Home_page.php?type=1&noteid=" . $note['noteid'] . "\" style=\"float:right;\">删除</a>
                            <a href=\"Write_blog.php?type=1&noteid=" . $note['noteid'] . "\" style=\"float:right;margin-right:10px\">修改</a>
                        </a>
                        <p class=\"abstract\">" .
                    mb_substr($note['content'], 0, 250, 'utf-8') . "...
                        <br />
                        </p>
                        作者：" . $_SESSION['USERNAME'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp发布日期：" . $note['created_at'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp字数：" . $note['wordcount'] . "
                        <hr>";
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
                    foreach ($photos as $photo) {
                        echo "<a href=\"" . $photo['position'] . "\"><img src=\"" . $photo['position'] . "\" class=\"img-thumbnail\" width=\"30%\"></a>";
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
                        <form role="form" enctype="multipart/form-data" method="POST" action="Home_page.php">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="file" name="photo">
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