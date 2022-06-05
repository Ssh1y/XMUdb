<?php

function RecomNote()
{
    $dbserver = 'localhost';
    $dbuser = 'root';
    $dbpwd = '123456';
    $dbname = "blog";

    $conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM NoteUser ORDER BY RAND()  LIMIT 3";
    // echo $sql;
    $Recresult = mysqli_query($conn, $sql);
    if (!$Recresult) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    mysqli_close($conn);
    return $Recresult;
}