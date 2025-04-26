<?php
require "../libraries/connectDB.php";
require "../user_auth/admin_lib/admin_chk.php";
require "../libraries/admin_lib/admin_display.php";
session_start();
$usrID = $_SESSION["ID"];
?>
<html>
    <head>
        <title>Online Store - Templete</title>
        <link rel="stylesheet" href="../ui/online_store.css">
    </head>
    <body>
        <?php include "../navigation/admin_nav.php";
        if(checkAdmin($dbc,$usrID)){
            displayItems($dbc);
        }
        ?>

    </body>
</html>