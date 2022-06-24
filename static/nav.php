<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/XMUdb/index.php">厦大博客</a>
        </div>
        <form class="navbar-form navbar-left" role="search" method="GET" action="/XMUdb/Search_result.php?type=1">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="搜你所想" name="Search" required>
            </div>
            <button type="submit" class="btn btn-default">提交</button>
        </form>
        <?php
        if (!isset($_SESSION['USER'])) {
            echo "<ul class=\"nav navbar-nav navbar-right\">";
            echo "<li><a href=\"/XMUdb/sign_up.php\"><span class=\"glyphicon glyphicon-user\"></span> 注册</a></li>";
            echo "<li><a href=\"/XMUdb/sign_in.php\"><span class=\"glyphicon glyphicon-log-in\"></span> 登录</a></li>";
            echo "</ul>";
        } elseif (!isset($_SESSION['IS_ADMIN'])) {
            $result = $user->show_profile();
            $result = mysqli_fetch_object($result);
            $avatar = $result->avatar;
            echo "<ul class=\"nav navbar-nav navbar-right\">";
            echo "<li><img src=\"$avatar\" style=\"width:45px;border-radius: 50%;\"></li>";
            echo "<li class=\"dropdown\">";
            echo "<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">";
            echo $_SESSION['USERNAME'];
            echo "<span class=\"caret\"></span>";
            echo "</a>";
            echo "<ul class=\"dropdown-menu\">";
            echo "<li><a href=\"/XMUdb/Home_page.php\"><i class=\"glyphicon glyphicon-user\"></i> 个人主页</a></li>";
            echo "<li><a href=\"/XMUdb/Edit_info.php\"><i class=\"glyphicon glyphicon-edit\"></i> 编辑资料</a></li>";
            echo "<li><a href=\"/XMUdb/Write_blog.php\"><i class=\"glyphicon glyphicon-book\"></i> 写文章</a></li>";
            echo "<li class=\"divider\"></li>";
            echo "<li><a href=\"/XMUdb/logout.php\"><i class=\"glyphicon glyphicon-log-out\"></i> 退出登录</a></li>";
            echo "</ul>";
            echo "</li>";
            echo "</ul>";
        } else {
            $result = $user->show_profile();
            $result = mysqli_fetch_object($result);
            $avatar = $result->avatar;
            $avatar = '/XMUdb/'.$avatar;
            echo "<ul class=\"nav navbar-nav navbar-right\">";
            echo "<li><img src=\"$avatar\" style=\"width:45px;border-radius: 50%;\"></li>";
            echo "<li class=\"dropdown\">";
            echo "<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">";
            echo "管理员";
            echo "<span class=\"caret\"></span>";
            echo "</a>";
            echo "<ul class=\"dropdown-menu\">";
            echo "<li><a href=\"/XMUdb/admin/blog.php\">管理博客</a></li>";
            echo "<li><a href=\"/XMUdb/admin/notice.php\">编辑公告</a></li>";
            echo "<li><a href=\"/XMUdb/admin/vote.php\">设置投票</a></li>";
            echo "<li class=\"divider\"></li>";
            echo "<li><a href=\"/XMUdb/logout.php\"><i class=\"glyphicon glyphicon-log-out\"></i> 退出登录</a></li>";
            echo "</ul>";
            echo "</li>";
            echo "</ul>";
        }
        ?>
    </div>
</nav>