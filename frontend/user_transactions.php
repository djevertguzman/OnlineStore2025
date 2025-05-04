<?php
require "../libraries/connectDB.php";
require "../libraries/transactions.php";
require "../libraries/changeStyle.php";
session_start();
$usrID = $_SESSION["ID"];
if(isset($_POST["chaLight"])){
    changeStyle();
}
?>
<html>
    <head>
        <title>Online Store - Transactions</title>
        <link rel="stylesheet" href="../ui/<?php echo retriveStyle();?>">
    </head>
    <body>
        <?php include "../navigation/user_nav.php";
        echo "<h2>Items Bought</h2>";
        $sqs = "SELECT * FROM Transactions WHERE buyer_id='$usrID'";
        displayTransactions($dbc,$sqs);
        echo "Items Sold";
        $sqs = "SELECT * FROM Transactions WHERE seller_id='$usrID'";
        displayTransactions($dbc,$sqs);
        ?>

    </body>
</html>