<?php
require "../libraries/connectDB.php";
require "../libraries/changeStyle.php";
session_start();
if(isset($_POST["chaLight"])){
    changeStyle();
}
$usrID = $_SESSION["ID"];
$orderStatus = "";
//print_r($_SESSION);
if(isset($_POST["remove"])){
    //echo "<br>In Remove Branch:<br>";
    //print_r($_POST);
    foreach ($_POST as $key => $value) {
        if (preg_match('/^(\d+)_line$/', $key, $matches)) {
            $item_id = $matches[1];
            $line_key = "{$item_id}_line";
            $amount_key = "{$item_id}_amount";
            $line_number = isset($_POST[$line_key]) ? intval($_POST[$line_key]) : 0;
            $quantity = isset($_POST[$amount_key]) ? intval($_POST[$amount_key]) : 0;
                //Remove item based on line number
                //echo "Removing item ID $item_id (line $line_number)<br>";
                $SDS = "DELETE FROM Cart WHERE line='$line_number'";
                mysqli_query($dbc,$SDS);
                // e.g., DELETE FROM cart WHERE line = $line_number
                $orderStatus = "<br><span class='error'><h3>Items removed from cart successfully.</h3></span><br>";
        }
    }
}
if(isset($_POST["purchase"])){
    //echo "<br>In Purchase Branch:<br>";
    //print_r($_POST);
    foreach ($_POST as $key => $value) {
        if (preg_match('/^(\d+)_select$/', $key, $matches)) {
            $item_id = $matches[1];
            $line_key = "{$item_id}_line";
            $amount_key = "{$item_id}_amount";
            $owner_key = "{$item_id}_owner";
            $line_number = isset($_POST[$line_key]) ? intval($_POST[$line_key]) : 0;
            $owner_id = isset($_POST[$owner_key]) ? intval($_POST[$owner_key]) : 0;
            $quantity = isset($_POST[$amount_key]) ? intval($_POST[$amount_key]) : 0;
                //Remove item based on line number from Cart
                //echo "Removing item ID $item_id (line $line_number)<br>";
                $SDS = "DELETE FROM Cart WHERE line='$line_number'";
                //echo "<br>SDS:".$SDS." <br>";
                $resultOne = mysqli_query($dbc,$SDS);
                //Add item to transactions since purchused.
                //echo "Inserting item ID $item_id (line $line_number)<br>";
                $SIS = "INSERT INTO Transactions(item_id,amount,seller_id,buyer_id) VALUES ('$item_id','$quantity','$owner_id','$usrID')";
                //echo "<br>SIS:".$SIS." <br>";
                $resultTwo = mysqli_query($dbc,$SIS);
                $SUS = "UPDATE Item SET p_onhand = p_onhand - $quantity WHERE item_id = $item_id";
                //echo "<br>SUS:".$SUS." <br>";
                $resultThree = mysqli_query($dbc,$SUS);
                if($resultOne == 1 && $resultTwo == 1 && $resultThree == 1){
                    $orderStatus = "<br><span class='success'><h3>Payment successful!, expect email with order confirmation.</h3></span><br>";
                }else{
                    $orderStatus = "<br><span class='error'><h3>Something has gone wrong, please contact support for assistence.</h3></span><br>";
                }
        }
    }
}
?>
<html>

<head>
    <title>Online Store - Shopping Cart</title>
    <link rel="stylesheet" href="../ui/<?php echo retriveStyle();?>">
</head>

<body>
    <?php include "../navigation/user_nav.php";
    echo "<div class='productTable'>";
    if (isset($_SESSION["cart_id"])) {
        require "../libraries/render_cart.php";
        $cartUUID = $_SESSION["cart_id"];
        renderCart($dbc,$cartUUID);
        
    } else {
        echo "<br><br><h1>There is nothing in your cart, <a href='./user_product.php' alt='Link back to product page'>Click Here </a> to change that.</h1>";
    }
    echo $orderStatus;
    echo "</div>";
    ?>


</body>

</html>