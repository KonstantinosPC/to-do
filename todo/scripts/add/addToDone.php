<?php
    session_start();
    include "../db_conn.php";


    if(isset($_SESSION["username"]) && isset($_SESSION["perms"])){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT * FROM todolist WHERE id='$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result)){
                $row = mysqli_fetch_assoc($result);
                $idOld = $row["id"];
                $choreOld = $row["chore"];
                $authorOld = $row["user"];
                $dayOld = $row["day"];
                $today = date("Y-m-d");
                $doneBySomeone = $_SESSION['name'] . " " . $_SESSION['lastname'];

                $sql2 = "INSERT INTO donelist (id, chore, doneby, day, oldAuthor, oldDay) VALUES ('$idOld', '$choreOld', '$doneBySomeone', '$today','$authorOld', '$dayOld')";

                if(mysqli_query($conn, $sql2)){

                    $sql3 = "DELETE FROM todolist WHERE id='$idOld'";
                    if(mysqli_query($conn, $sql3)){
                        header("Location: ../../index.php");
                        exit();
                    }
                }else{
                    header("Location: ../../index.php?error=Network Error");
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