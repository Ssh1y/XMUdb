<?php

//初始化数据库
require('config/config.php');

$sql = file_get_contents('init.sql');
$arr = explode(';', $sql);
$mysqli = new mysqli($config['dbserver'], $config['dbuser'], $config['dbpwd']);

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}
foreach ($arr as $value) {
    $mysqli->query($value . ';');
}
$mysqli->close();
$mysqli = null;

header('Location: index.php');