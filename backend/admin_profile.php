<?php
require "../libraries/connectDB.php";
require "../user_auth/admin_lib/admin_chk.php";
require "../libraries/changeStyle.php";
session_start();
if(isset($_POST["chaLight"])){
    changeStyle();
}
$usrID = $_SESSION["ID"];
if(checkAdmin($dbc,$usrID)){
    //echo "<h2>Admin chk good Continue</h2>";
}else{
    //echo "<h1>GTFO</h1>";
}
?>
<html>
    <head>
        <title>Online Store - Admin Profile</title>
        <link rel="stylesheet" href="../ui/<?php echo retriveStyle();?>">
    </head>
    <body>
        <?php include "../navigation/admin_nav.php";?>

    </body>
</html>