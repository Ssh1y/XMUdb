<?php
session_start();
function check_alter_or_add()
{
    $dbserver = 'localhost';
    $dbuser = 'root';
    $dbpwd = '123456';
    $dbname = "blog";

    $conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($noteid = (explode("=", $_SERVER["QUERY_STRING"]))[1]) {
        $sql = "SELECT * FROM noteuser WHERE noteid = $noteid";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }
        if (mysqli_num_rows($result) > 0) {  // 1
            if ($row = mysqli_fetch_assoc($result)) {
                $title = $row['title'];
                $content = $row['content'];
            }
        }
    }
    return [$title,$content];
    mysqli_close($conn);
}
