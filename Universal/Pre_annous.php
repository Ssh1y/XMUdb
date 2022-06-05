<?php

function pre_annous()
{
    $dbserver = 'localhost';
    $dbuser = 'root';
    $dbpwd = '123456';
    $dbname = "blog";

    $conn = mysqli_connect($dbserver, $dbuser, $dbpwd, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM annous ORDER BY Ptime DESC LIMIT 1";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    mysqli_close($conn);
    return $result;
}
