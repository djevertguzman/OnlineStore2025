<?php
require "libraries/connectDB.php";
include "libraries/products.php";
include "libraries/changeStyle.php";
startStyle();
if(isset($_POST["chaLight"])){
    changeStyle();
}
?>
<html>
    <head>
        <title>Online Store - Homepage</title>
        <link rel="stylesheet" href="ui/<?php echo retriveStyle();?>">
    </head>
    <body>
        <?php
        include "navigation/guest_nav.php";
        displayProduct($dbc);
        ?>

    </body>
</html>