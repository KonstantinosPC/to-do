<?php

$sname = "192.168.170.191";
$unae = "root";
$password = "KonstantinosPC";
$db_name = "todo";



$conn = mysqli_connect($sname, $unae, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}