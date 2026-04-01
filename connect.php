<?php

$db_host = 'MySQL-8.0';
$db_user = 'root';      
$db_password = '';    
$db_name = 'practic';

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$link) {
    die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
}

mysqli_set_charset($link, "utf8mb4");
?>