<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>厦大博客</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/abstract.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php require('Universal/class.php'); ?>
</head>

<body>
    <?php require_once('static/nav.php'); ?>
    <div class="container">
        <div class="col-sm-9">

            <ul class="breadcrumb">
                <li class="active">推荐文章</li>
            </ul>
            <?php
            $recommended_notes = $blog->recommend_note();
            // die(var_dump($recommended_notes));
            foreach ($recommended_notes as $note) {
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
                    $notices = $blog->show_announcement();
                    foreach ($notices as $notice) {
                        echo "<small>ADMIN&nbsp&nbsp发布时间：" . $notice['created_at'] . "</small>";
                        echo "<p>" . $notice['content'] . "</p>";
                        echo "<hr>";
                    }
                    ?>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        投票
                    </h2>
                </div>
                <div class="panel-body">
                    <!-- 实现html投票界面-->
                    <?php
                    $votes = $blog->show_vote();
                    // 这边有点小问题，懒得修了
                    foreach ($votes as $vote) {
                        $options = $vote['options'];
                        echo "<div class=\"panel panel-default\">";
                        echo "<div class=\"panel-heading\">";
                        echo "<h4 class=\"panel-title\">";
                        echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse" . $vote['voteid'] . "\">";
                        echo $vote['title'];
                        echo "</a>";
                        echo "</h4>";
                        echo "</div>";
                        echo "<div id=\"collapse" . $vote['voteid'] . "\" class=\"panel-collapse collapse in\">";
                        echo "<div class=\"panel-body\">";
                        foreach ($options as $option) {
                            echo "<div id=\"dig_up\" class=\"well well-sm\">";
                            echo "<div class=\"row\">";
                            echo "<div class=\"col-sm-8\">";
                            echo "<h4>" . $option['o_option'] . "</h4>";
                            echo "</div>";
                            echo "<div class=\"col-sm-4\">";
                            echo "<h4>" . $option['o_count'] . "</h4>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
            <?php
            if (isset($_SESSION['USER'])) {
                echo "<div class=\"panel panel-info\">";
                echo "<div class=\"panel-heading\">";
                echo "<h2 class=\"panel-title\">";
                echo "个人相册";
                echo "</h2>";
                echo "</div>";
                echo "<div class=\"panel-body\">";

                $photos = $blog->show_album($_SESSION['USER']);
                foreach ($photos as $photo) {
                    echo "<a href=\"" . $photo['position'] . "\"><img src=\"" . $photo['position'] . "\" class=\"img-thumbnail\" width=\"100%\"></a>";
                }

                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>

</html>