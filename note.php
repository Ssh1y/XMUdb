<?php require('Universal/class.php');

$noteid = $_GET['noteid'];
$note_owner = $_GET['note_owner'];
$commentary = $_POST['commentary'];
if ($commentary) {
    $result = $user->add_comment($noteid, $commentary, $note_owner);
    if ($result) {
        // echo "<script>alert('评论成功！');</script>";
        header('Location: note.php?noteid=' . $noteid . '&note_owner=' . $note_owner);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>文章</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/NoteBody.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <?php require_once('static/nav.php'); ?>
    <?php
    $note = $blog->show_note_detail($noteid, $note_owner);
    // die(var_dump($note));
    ?>
    <div class="container">
        <section>
            <h2><?php echo $note['title']; ?></h2>
            <div class="notebody">
                <?php
                $sentences = (explode("。", $note['content']));
                for ($index = 0; $index < sizeof($sentences) - 1; $index++) {
                    echo "<p>" . $sentences[$index] . "。</p>";
                }
                echo "<p>" . $sentences[$index] . "</p>";
                ?>
            </div>
        </section>
        <hr>
        <section>
            <?php
            if (!isset($_SESSION['USER'])) {
                echo "<h3>请登录后再评论！</h3>";
            } else {
                $result = $user->show_profile();
                $result = mysqli_fetch_object($result);
                $avatar = $result->avatar;
                echo "<div class=\"media\">";
                echo "<div class=\"media-left\">";
                echo "<img src=\"$avatar\" class=\"media-object\" style=\"width:45px;border-radius: 50%;\">";
                echo "<br />";
                echo "</div>";
                echo "<form class=\"media-body\" name=\"commenting\" method=\"post\" action=\"note.php?noteid=$noteid&note_owner=$note_owner\">";
                echo "<textarea required class=\"form-control\" name=\"commentary\" placeholder=\"留下你的评论\" style=\"resize: none;width: 100%;height: 100px;font-size: larger;\" maxlength=\"100\"></textarea>";
                echo "<br />";
                echo "<button type=\"submit\" class=\"btn btn-default\" name=\"comment\">评论</button>";
                echo "</form>";
                echo "</div>";
            }
            ?>
            <h2>精选评论</h2>
            <?php
            $comments = $blog->show_comments($_GET['noteid'], $_GET['note_owner']);
            if ($comments == null) {
                echo "<h4>暂时还没有人评论，快来抢沙发~</h4>";
            }
            foreach ($comments as $comment) {
                echo "<div class=\"media\">";
                echo "<div class=\"media-left\">";
                echo "<img src=\"" . $comment['avatar'] . "\" class=\"media-object\" style=\"width:45px;border-radius: 50%;\">";
                echo "<br />";
                echo "</div>";
                echo "<div class=\"media-body\">";
                echo "<h4 class=\"media-heading\">" . $comment['username'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<small><i>Posted on " . $comment['created_at'] . "</i></small></h4>";
                echo "<p>" . htmlspecialchars($comment['content']) . "</p>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </section>
    </div>
</body>

</html>