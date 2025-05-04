<?php
require "../libraries/connectDB.php";
require "../user_auth/admin_lib/admin_chk.php";
require "../libraries/admin_lib/admin_display.php";
require "../libraries/changeStyle.php";
session_start();
if(isset($_POST["chaLight"])){
    changeStyle();
}
$usrID = $_SESSION["ID"];
?>
<html>
    <head>
        <title>Online Store - Templete</title>
        <link rel="stylesheet" href="../ui/<?php echo retriveStyle();?>">
    </head>
    <body>
        <?php include "../navigation/admin_nav.php";
        if(checkAdmin($dbc,$usrID)){
            displayItems($dbc);
        }
        ?>

    </body>
</html>