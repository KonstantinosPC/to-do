<?php
    session_start();

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
        <form class="login" action="./scripts/acc/logmein.php"  method="POST">
            <h1>Login</h1>
            <?php
            if(isset($_GET['error'])){
                echo '<h5 style="color:red;margin:0;">'. $_GET['error'] .'</h5>';
            }
            ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Submit</button>
        </form>
    </body>
</html>