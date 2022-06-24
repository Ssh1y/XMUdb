$(function () {
    //当鼠标悬浮和离开两个按钮时，切换按钮背景样式 
    $("#dig_up").hover(function () {
        $(this).addClass("digup_on");
    }, function () {
        $(this).removeClass("digup_on");
    });
    $("#dig_down").hover(function () {
        $(this).addClass("digdown_on");
    }, function () {
        $(this).removeClass("digdown_on");
    });
    //初始化数据 
    getdata("ajax.php", 1);
    //单击“顶”时 
    $("#dig_up").click(function () {
        getdata("ajax.php?action=like", 1);
    });
    //单击“踩”时 
    $("#dig_down").click(function () {
        getdata("ajax.php?action=unlike", 1);
    });
});