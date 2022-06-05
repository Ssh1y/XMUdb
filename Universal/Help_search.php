<?php
session_start();

function fuzzy_search($obj,$table,$target)
{
    $dbserver = 'localhost';
    $dbuser = 'root';
    $dbpwd = '123456';
    $dbname = "blog";

    $conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM $table WHERE $target LIKE '%$obj%' ORDER BY Ptime DESC";
    $obj_result = mysqli_query($conn, $sql);
    if (!$obj_result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }

    return $obj_result;
    mysqli_close($conn);
}
