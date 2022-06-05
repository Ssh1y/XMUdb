<?php

function listinfo($userid,$table)
{
    $dbserver = 'localhost';
    $dbuser = 'root';
    $dbpwd = '123456';
    $dbname = "blog";

    $conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM $table WHERE userid = $userid ORDER by Ptime DESC";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    mysqli_close($conn);
    return $result;
}