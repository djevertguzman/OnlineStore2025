<?php
require "../libraries/connectDB.php";
require "../libraries/input_sanitization.php";
require "../libraries/products.php";
require "../libraries/changeStyle.php";
session_start();
$usrID = $_SESSION["ID"];
if(isset($_POST["chaLight"])){
    changeStyle();
}
//echo isset($_POST["submit"]).": isset output, going into if statement.<br>";
if(isset($_POST["submit"])){
    //echo "This is inside the function.<br>Output of print_r <br>";
    //print_r($_POST);
    //echo "<br>";
    shoppingCart($dbc,$_POST,$usrID);
}
?>
<html>
    <head>
        <title>Online Store - Products</title>
        <link rel="stylesheet" href="../ui/<?php echo retriveStyle();?>">
    </head>
    <body>
        <?php
        include "../navigation/user_nav.php";
        displayProduct($dbc);
        ?>
    </body>
</html>