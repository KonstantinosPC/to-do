<?php

$sname = "<Host/IP address of the database>";
$unae = "root";
$password = "";
$db_name = "todo";

$conn = mysqli_connect($sname, $unae, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}
