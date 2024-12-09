<?php
    session_start();
    include "../db_conn.php";


    if(isset($_SESSION["username"]) && isset($_SESSION["perms"])){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT * FROM todolist WHERE id='$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result)){
                
                $authorOld = $row["user"];
                if($authorOld === ($_SESSION["name"] . " " . $_SESSION["lastname"])){
                    $sql2 = "DELETE FROM todolist WHERE id='$id'";

                    if(mysqli_query($conn, $sql2)){
                        header("Location: ../../index.php");
                        exit();
                    }else{
                        header("Location: ../../index.php?error=Network Error");
                        exit();
                    }
                }else{
                    header("Location: ../../index.php?error=Sorry but this post doesn't belong to you");
                    exit();
                }
            }


        }else{
            header("Location: ../../index.php");
        }
    }else{
        header("Location: ../../index.php");
    }

?>