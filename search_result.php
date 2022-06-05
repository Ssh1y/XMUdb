<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>搜索结果</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/abstract.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php require_once("./Universal/pre.php"); ?>
    <?php require_once("./Universal/id2another.php"); ?>
    <?php require_once("./Universal/Help_search.php") ?>
</head>

<body>
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
                        <li><a href="#"><i class="glyphicon glyphicon-book"></i> 写文章</a></li>
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
        <div class="col-sm-4">
            <?php $obj = $_GET['Search'];?>
            <ul class="nav nav-pills nav-stacked">
                <li id="title"><a href="search_result.php?Search=<?php echo $obj; ?>&target=title"><span class="glyphicon glyphicon-book"></span> 搜文章</a></li>
                <li id="annou"><a href="search_result.php?Search=<?php echo $obj; ?>&target=annou"><span class="glyphicon glyphicon-bullhorn"></span> 搜公告</a></li>
                <li id="album"><a href="search_result.php?Search=<?php echo $obj; ?>&target=alt"><span class="glyphicon glyphicon-picture"></span> 搜相册</a></li>
            </ul>
        </div>
        <div class="col-sm-8">
            <h2>"<?php echo $obj;?>"&nbspの搜索结果</h2>
            <hr >
            <?php $obj = $_GET['Search'];
            if ($_GET['target'] == "") {
                $target = "title";
            } else {
                $target = $_GET['target'];
            };
            if($target == "title"){         //查文章
                $table = "noteuser";
                if ($obj != "") {
                    $result = fuzzy_search($obj, $table, $target);
                    if (mysqli_num_rows($result) == 0) {
                        echo "哇哦，没有搜到你想要的...";
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                                <a class=\"lead text-primary\" target=\"_blank\" href=\"article.php?noteid=" . $row['noteid'] . "\">
                                    " . $row['title'] . "
                                </a>
                                <p class=\"abstract\">" .
                                    mb_substr($row['content'], 0, 250, 'utf-8') . "...
                                    <br />
                                </p>
                                作者：".id2another($row['userid'],'username')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp发布日期：".$row['Ptime']."
                                <hr>";
                        }
                    }
                }
            }
            if($target == "annou"){         //查公告
                $table = "annous";
                if($obj != ""){
                    $result = fuzzy_search($obj, $table, $target);
                    if (mysqli_num_rows($result) == 0) {
                        echo "哇哦，没有搜到你想要的...";
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                                <h3 class=\"lead text-info\">
                                    " . $row['annou_title'] . "
                                </h3>
                                <p>" .
                                    $row['annou'] . "
                                </p>
                                <hr>";
                        }
                    }
                }
            }
            if($target == "alt"){
                $table = "useralbum";
                if($obj != ""){
                    $result = fuzzy_search($obj, $table, $target);
                    if (mysqli_num_rows($result) == 0) {
                        echo "哇哦，没有搜到你想要的...";
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            echo "<a href=\"" . $row['album'] . "\"><img src=\"" . $row['album'] . "\" class=\"img-thumbnail\" width=\"30%\"></a>";
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
    <script type="text/javascript">
        $("#<?php if ($_GET['target'] == "") { echo "note"; } else {echo $_GET['target'];}; ?>").attr("class", "active"); //js不支持换行，但是php支持，所以用格式化之后会报错，不要格式化谢谢。
    </script>
</body>

</html>