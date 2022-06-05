<?php
session_start();

$dbserver = 'localhost';
$dbuser = 'root';
$dbpwd = '123456';
$dbname = "blog";

$conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 从文章id找到文章的详细信息
$noteid = (explode("=", $_SERVER["QUERY_STRING"]))[1];
$sql = "SELECT * from NoteUser WHERE noteid = $noteid";
$result = mysqli_query($conn, $sql);
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
if (mysqli_num_rows($result) > 0) {
    if ($row = mysqli_fetch_assoc($result)) {
        $noteid = $row['noteid'];
        $userid = $row['userid'];
        $time = $row['time'];
        $wc = $row['wc'];
        $title = $row['title'];
        $content = $row['content'];
    }
}

// 插入评论
if (isset($_POST['commentary'])) {
    $commentary = $_POST['commentary'];
    $commenter = $_SESSION['USER'];
    $comtime = date("Y-m-d H:i:s");
    // echo $commentary.$commenter;
    $sql = "INSERT INTO notecom(noteid,commentary,commenter,comtime) VALUES($noteid,'$commentary',$commenter,'$comtime')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    echo "<script>alert('评论成功！');window.location.href='article.php?noteid=$noteid'</script>";
}

// 找到文章所有的评论，并显示在下方
$sql = "SELECT * FROM notecom WHERE noteid = $noteid ORDER BY comtime DESC";
$comresult = mysqli_query($conn, $sql);
if (!$comresult) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
// if (mysqli_num_rows($comresult) > 0) {
//     while ($row = $comresult->fetch_assoc()) {
//         echo $row;
//         echo "id: " . $row["commentid"] . " - Name: " . $row["userid"] . " " . "<br>";
//     }
// }
mysqli_close($conn);
