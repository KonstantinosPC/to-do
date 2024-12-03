<?php

    session_start();
    include "../db_conn.php";

    if($_POST['chore']){
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $chore = validate($_POST["chore"]);
        $user = $_SESSION["name"] . " " . $_SESSION["lastname"];
        $today = date("Y-m-d");

        $sql1 = "INSERT INTO todolist (chore, user, day) VALUES ('$chore', '$user', '$today')";

        if(mysqli_query($conn, $sql1)){
            header("Location: ../../index.php?done=Chore Uploaded Successfully");
            exit();
        }else{
            header("Location: ../../index.php?error=Chore couldn't be uploaded");
            exit();
        }
    }else{
        header("Location: ../../index.php");
        exit();
    }
?>