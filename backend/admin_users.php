<?php
require "../libraries/connectDB.php";
require "../user_auth/admin_lib/admin_chk.php";
require "../libraries/admin_lib/admin_display_users.php";
require "../libraries/changeStyle.php";
session_start();
$usrID = $_SESSION["ID"];
if(isset($_POST["chaLight"])){
    changeStyle();
}
?>
<html>
    <head>
        <title>Online Store - Admin Users</title>
        <link rel="stylesheet" href="../ui/<?php echo retriveStyle();?>">
    </head>
    <body>
        <?php 
        include "../navigation/admin_nav.php";
        if(checkAdmin($dbc,$usrID)){
            displayUsers($dbc);
        }else{
            //echo "<h1>GTFO</h1>";
        }
        ?>

    </body>
</html>