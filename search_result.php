<?php
require('Universal/class.php');

//接收表单通过GET传递的数据
$search = $_GET['Search'];
$notes = $blog->search_note($search);
$photos = $blog->search_album($search);
$notices = $blog->search_announcement($search);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>搜索结果</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/abstract.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <?php require_once("static/nav.php"); ?>
    <div class="container">
        <div class="col-sm-4">
            <ul class="nav nav-pills nav-stacked">
                <li id="title"><a href="search_result.php?type=1&Search=<?php echo $search;?>"><span class="glyphicon glyphicon-book"></span> 搜文章</a></li>
                <li id="annou"><a href="search_result.php?type=2&Search=<?php echo $search;?>"><span class="glyphicon glyphicon-bullhorn"></span> 搜公告</a></li>
                <li id="album"><a href="search_result.php?type=3&Search=<?php echo $search;?>"><span class="glyphicon glyphicon-picture"></span> 搜相册</a></li>
            </ul>
        </div>
        <div class="col-sm-8">
            <h2>"<?php echo $search; ?>"&nbspの搜索结果</h2>
            <hr>
            <?php if ($_GET['type'] == 1) { //查找文章 
                if (count($notes) == 0) {
                    echo "<h3>没有找到相关文章</h3>";
                } else {
                    foreach ($notes as $note) {
                        echo "
                                <a class=\"lead text-primary\" target=\"_blank\" href=\"note.php?noteid=" . $note['noteid'] . "&note_owner=" . $note['userid'] . "\">
                                    " . $note['title'] . "
                                </a>
                                <p class=\"abstract\">" .
                            mb_substr($note['content'], 0, 250, 'utf-8') . "...
                                <br />
                                </p>
                                作者：" . $note['username'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp发布日期：" . $note['created_at'] . "
                                <hr>";
                    }
                }
            } else if ($_GET['type'] == 2) { //查找公告
                if (count($notices) == 0) {
                    echo "<h3>没有找到相关公告</h3>";
                } else {
                    foreach ($notices as $notice) {
                        echo "
                                <a class=\"lead text-primary\">
                                    " . $notice['title'] . "
                                </a>
                                <p class=\"abstract\">" .
                            mb_substr($notice['content'], 0, 250, 'utf-8') . "...
                                <br />
                                </p>
                                作者：" . $notice['username'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp发布日期：" . $notice['created_at'] . "
                                <hr>";
                    }
                }
            } else if ($_GET['type'] == 3) { //查找相册
                if (count($photos) == 0) {
                    echo "<h3>没有找到相关相册</h3>";
                } else {
                    foreach ($photos as $photo) {
                        echo "
                                <a class=\"lead text-primary\">
                                    " . $photo['title'] . "
                                </a>
                                <p class=\"abstract\">" .
                            mb_substr($photo['content'], 0, 250, 'utf-8') . "...
                                <br />
                                </p>
                                作者：" . $photo['username'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp发布日期：" . $photo['created_at'] . "
                                <hr>";
                    }
                }
            } ?>
        </div>
    </div>
    <script type="text/javascript">
        //按照type设置class
        var type = <?php echo $_GET['type']; ?>;
        var title = document.getElementById("title");
        var annou = document.getElementById("annou");
        var album = document.getElementById("album");
        if (type == 1) {
            title.className = "active";
        } else if (type == 2) {
            annou.className = "active";
        } else if (type == 3) {
            album.className = "active";
        }
    </script>
</body>

</html>