<?php

session_start();

include "../db_conn.php";

if(isset($_POST['username']) && isset($_POST['password'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['username']);
    $passd = validate($_POST['password']);


    if(empty($uname)){
        header("Location: ../../login.php?error=Username is required");
        exit();
    }else if(empty($passd)){
        header("Location: ../../login.php?error=Password is required");
    }else{
        $sql = "SELECT * FROM users WHERE username='$uname'";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)){
            $row = mysqli_fetch_assoc($result);

            if($row['username'] === $uname && password_verify($passd,$row['password'])){
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['perms'] = $row['perms'];             

                header("Location: ../../index.php");

                exit();
            }
        }else{
            header("Location: ../../login.php?error=Incorrect Username or Password");
            exit();
        }
    }
}