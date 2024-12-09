<?php
   

    session_start();
    if (isset($_SESSION["username"]) && isset($_SESSION["perms"])) {
         include "./scripts/db_conn.php";
?>
<html>
    <head>
        <title>To-Do Support Version</title>
        <link rel="stylesheet" href="./styl.css">
        <link rel="icon" type="image/x-icon" href="./assets/img/8476658.png">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <main>
            <div class="top">
                <h5>Logged in: <?php echo $_SESSION["name"] . " " . $_SESSION["lastname"]; ?></h5>
                <a href="./scripts/acc/logout.php"><button class="logout">Log out</button></a>
            </div>
            <br>
            <h1>Support To-Do List</h1>
            <form class="add-list" action="./scripts/add/addList.php" method="POST">
                <input type="text" name="chore" placeholder="Write your to-do's here" required>
                <button type="submit">Add Chore</button>
            </form>
            <table class="to-be">
                <tr>
                    <th width="5%">Check</th>
                    <th width="3%">ID</th>
                    <th width="55%">Chore</th>
                    <th width="25%">Author</th>
                    <th width="12%">Day</th>
                    <th width="3%">Del.</th>
                </tr> 

                <?php include "./scripts/load/loadToDo.php"; ?>
            </table>
            <hr>
            <table class="done">
                <tr>
                    <th width="8%">Recover</th>
                    <th width="3%">ID</th>
                    <th width="50%">Chore</th>
                    <th width="30%">Done by</th>
                    <th width="12%">Done at</th>
                </tr>

                <?php include "./scripts/load/loadDone.php"; ?>

            </table>
            <footer>
                Konstantinos Iliopoulos &copy; Copyright 2024-25
                <?php
                if($_SESSION["perms"] >= 2){
                    echo '<a href="./createacc.php">Create Account</a>';
                }

                ?>
            </footer>
        </main>
    </body>
</html>
<?php
    }else{
        header("Location: login.php");
    }

?>