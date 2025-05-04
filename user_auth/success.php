<?php
session_start();
require "../libraries/changeStyle.php";
?>
<html>
    <head>
        <title>Online Store - Registration Success!!</title>
        <link rel="stylesheet" href="../ui/<?php echo retriveStyle();?>">
    </head>
    <body>
        <?php include "./guest_nav.php"; ?>
        <div class="usrLogin">
            <h2>Registration Successful</h2>
            <p>Go ahead and <a href="./login.php">Click Here</a> to sign in</p>
        </div>

    </body>
</html>