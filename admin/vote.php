<?php
require('admin.php');
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type == '0') { //新增投票
        $title = $_POST['title'];
        $select = $_POST['select'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $options = array();
        for ($i = 0; $i < $select; $i++) {
            //如果选项为空，就报错
            if (empty($_POST['option' . $i])) {
                echo '<script>alert("选项不能为空！");history.go(-1);</script>';
                exit;
            }
            $options[] = $_POST['option' . $i];
        }
        //检查标题是否为空
        if (empty($title)) {
            echo '<script>alert("标题不能为空");window.history.back(-1);</script>';
        }
        //检查开始时间是否大于结束时间
        if ($start > $end) {
            echo '<script>alert("开始时间不能大于结束时间");window.history.back(-1);</script>';
        }

        $voteid = $admin->set_vote($title, $start, $end);
        if ($voteid) {
            $admin->set_vote_option($voteid, $options);
            echo '<script>alert("投票创建成功");window.location.href="vote.php";</script>';
        } else {
            echo '<script>alert("投票创建失败");window.history.back(-1);</script>';
        }
    }
    if ($type == '1') { //删除投票
        $voteid = $_GET['voteid'];
        $admin->delete_vote($voteid);
        echo '<script>alert("投票删除成功");window.location.href="vote.php";</script>';
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
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/moment.js/2.22.0/moment-with-locales.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <title>设置投票</title>
    <script>
        $(function() {
            $('#start_time').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                locale: moment.locale('zh-cn')
            });
            $('#end_time').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                locale: moment.locale('zh-cn')
            });
        });
        // 实时获取select选中的值
        function addoptions(index) {
            var option = document.querySelector("div[id='options']")
            // 清空原有的选项
            option.innerHTML = '';
            for (var i = 0; i < index; i++) {
                var option = document.createElement("div");
                option.setAttribute("class", "form-group");
                option.setAttribute("id", "option" + i);
                var label = document.createElement("label");
                label.setAttribute("for", "option" + i);
                label.innerHTML = "选项" + (i + 1);
                var input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("class", "form-control");
                input.setAttribute("id", "option" + i);
                input.setAttribute("name", "option" + i);
                option.appendChild(label);
                option.appendChild(input);
                document.querySelector("div[id='options']").appendChild(option);
            }
        }
    </script>
</head>

<body>
    <?php require(__DIR__ . '/../static/nav.php'); ?>
    <div class="container">
        <?php
        // 获取所有投票
        $votes = $admin->get_all_vote();
        // 若没有投票，则提示
        if (empty($votes)) {
            echo "<h2>暂时没有投票，请<button type=\"button\" class=\"btn btn-link btn-lg\" data-toggle=\"modal\" data-target=\"#addvote\">新增</button></h2>";
        } else {
            echo "<h2><button type=\"button\" class=\"btn btn-link btn-lg\" data-toggle=\"modal\" data-target=\"#addvote\">新增投票</button></h2>";
            foreach ($votes as $vote) {
                $voteid = $vote['voteid'];
                $title = $vote['title'];
                $created_at = $vote['created_at'];
                $start_time = $vote['start_time'];
                $end_time = $vote['end_time'];
                $options = $admin->get_vote_options($voteid);
                echo "<div class=\"panel panel-warning\">";
                echo "<div class=\"panel-heading\">";
                echo "<h3 class=\"panel-title\">$title</h3>";
                echo "</div>";
                echo "<div class=\"panel-body\">";
                foreach ($options as $option) {
                    // die(var_dump($option));
                    $index = $option['o_index'];
                    $option = $option['o_option'];
                    $count = isset($option['vcount']) ?$option['vcount'] : '0';
                    echo "<p>$index: $option ($count)</p>";
                }
                echo "</div>";
                echo "</div>";
                echo "<a href=\"vote.php?type=1&voteid=$voteid\" class=\"btn btn-danger\">删除</a>";
                echo "<hr>";
            }
        }
        ?>
        <div class="modal fade" id="addvote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">添加投票</h4>
                    </div>
                    <form action="vote.php?type=0" method="POST" role="form">
                        <!-- type=0表示新增投票 -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">投票标题</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="请输入投票标题">
                            </div>
                            <div class="form-group">
                                <label for="name">选择投票选项</label>
                                <select class="form-control" id="SelectOptions" name="select" onchange="addoptions(this.options[this.options.selectedIndex].text)">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group" id="options">

                            </div>
                            <div class="row">
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <label>选择开始时间：</label>
                                        <!--指定 date标记-->
                                        <div class='input-group date' id='start_time'>
                                            <input type='text' class="form-control" name="start" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <label>选择结束时间：</label>
                                        <!--指定 date标记-->
                                        <div class='input-group date' id='end_time'>
                                            <input type='text' class="form-control" name="end" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="submit" class="btn btn-primary">提交更改</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </div>
</body>

</html>