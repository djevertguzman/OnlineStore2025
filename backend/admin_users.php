<?php
require "../libraries/connectDB.php";
require "../user_auth/admin_lib/admin_chk.php";
require "../libraries/admin_lib/admin_display_users.php";
session_start();
$usrID = $_SESSION["ID"];
if(checkAdmin($dbc,$usrID)){
    echo "<h2>Admin chk good Continue</h2>";
}else{
    echo "<h1>GTFO</h1>";
}
?>
<html>
    <head>
        <title>Online Store - Admin Users</title>
        <link rel="stylesheet" href="../ui/online_store.css">
    </head>
    <body>
        <?php 
        include "../navigation/admin_nav.php";
        displayUsers($dbc);
        ?>

    </body>
</html>