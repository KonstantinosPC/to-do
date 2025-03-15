<?php

$sname = "";
$unae = "";
$password = "";
$db_name = "";



$conn = mysqli_connect($sname, $unae, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}
