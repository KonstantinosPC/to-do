<?php
    session_start();
    if (isset($_SESSION["username"]) && isset($_SESSION["perms"])) {
        if($_SESSION["perms"] >= 2){
?>

<html>
    <head>
        <title>To-Do Support Version</title>
        <link rel="stylesheet" href="./styl.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <body>
        <form class="login" action="./scripts/acc/createacc.php"  method="POST">
            <h1>Create Account</h1>
            <?php
            if(isset($_GET['error'])){
                echo '<h5 style="color:red;margin:0;">'. $_GET['error'] .'</h5>';
            }
            ?>
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confpassword" placeholder="Confirm Password" required>
            <select name="perms">
                <option value="">- - Choose Perm Type - -</option>
                <option value="2">Admin</option>
                <option value="1">Default</option>
            </select>
            <button type="submit">Submit</button>
            <a href="./index.php">Go Back to Main</a>
        </form>
    </body>
</html>

<?php

        }
    }
?>