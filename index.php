<?php
require "libraries/connectDB.php";
include "libraries/products.php";
?>
<html>
    <head>
        <title>Online Store - Homepage</title>
        <link rel="stylesheet" href="ui/online_store.css">
    </head>
    <body>
        <?php
        include "navigation/guest_nav.php";
        displayProduct($dbc);
        ?>

    </body>
</html>