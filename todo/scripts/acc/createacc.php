<?php

    session_start();
    include "../db_conn.php";
    if(isset($_SESSION["username"]) && isset($_SESSION["perms"])){
        if($_SESSION["perms"] >= 2){
            if(isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confpassword"]) && !empty($_POST["perms"])){

                function validate($data){
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                $name = validate($_POST["name"]);
                $lastname = validate($_POST["lastname"]);
                $username = validate($_POST["username"]);
                $password = validate($_POST["password"]);
                $confirmPassword = validate($_POST["confpassword"]);
                $perms = validate($_POST["perms"]);

                if($password != $confirmPassword){
                    header("Location: ../../createacc.php?error=Confirm Password and Password are not the same");
                    exit();
                }
                

                $password = hash('sha256',$password);
                $sql = "INSERT INTO users (username, password, name, lastname, perms) VALUES ('$username', '$password', '$name', '$lastname', '$perms')";
                
                if(mysqli_query($conn, $sql)){
                    header("Location: ../../createacc.php?done=Account created Successfully");
                    exit();
                }else{
                    header("Location: ../../createacc.php?error=Network Error");
                    exit();
                }
            }
        }
    }
?>