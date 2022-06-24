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
    <?php require_once('static/nav.php'); ?>
    <div class="container">
        <form role="form" action="Write_blog.php" method="POST" name="writeblog">
            <input name="title" style="border:none;outline:medium;padding: 20px 10px;width:100%;font-size: 30px;font-weight: 700;" placeholder="请输入标题" value="<?php echo $title; ?>" required>
            <button type="submit" class="btn btn-default" style="float:right;">
                发布文章
            </button>
            <hr>
            <textarea name="content" class="well" style="border:none;outline:medium;padding:20px 10px;width:100%;height:500px;resize: none;" placeholder="请输入正文" maxlength="3000" required><?php echo $content; ?></textarea>
        </form>
    </div>
    </body>
    <!-- <script>
        $("#writeblog").submit(function() {
            var text = $("textarea").text();
            var des = text.replace(/\r\n/g, '<br/>').replace(/\n/g, '<br/>').replace(/\s/g, ' ');
            //替换textarea的文本内容
            $("textarea").html(des);
            console($("textarea").html());
        });
    </script> -->

</html>