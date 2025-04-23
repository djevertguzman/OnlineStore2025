<?php
function displayProduct($dbc, $cliorsell = 0, $sqs = "SELECT * FROM Item WHERE p_visible='1' AND p_onhand > 0")
{
    $result = mysqli_query($dbc, $sqs);
    $rowCount = mysqli_num_rows($result);
    $formPST = htmlspecialchars($_SERVER["PHP_SELF"]);
    //print_r($row=mysqli_fetch_array($result));
    if ($cliorsell == 0) {
        echo "
        <div class= 'productTable'>
        <form action='" . $formPST . "' method='POST'>
        <table>";
        while ($row = mysqli_fetch_array($result)) {
            rowItem($row["item_id"], $row["p_picture"], $row["p_name"], $row["p_description"], $row["p_price"], $row["p_onhand"]);
        }
        echo "</table><input type = 'submit' name='submit' value='Add to Shopping Cart'></form>
    </div>
    ";
    } else {
        if($rowCount != 0){
        echo "
        <div class= 'productTable'>
        <table>";
        while ($row = mysqli_fetch_array($result)) {
            rowSellingItem($row["item_id"], $row["p_picture"], $row["p_name"], $row["p_description"], $row["p_price"], $row["p_onhand"]);
        }
        echo "</table>
    </div>
    ";
        }else{
            echo "<div class= 'productTable'>";
            echo "<h2> You have no items listed, add some so that they appear here.</h2>";
            echo "</div>";
        }
    }
}
function rowItem($p_id, $pic, $name, $description, $price, $onhand)
{
    echo "
    <tr>
    <th>" . $p_id . "</th>
    <th><img src='" . $pic . "' width='50px'></th>
    <th>" . $name . "</th>
    <th>" . $description . "</th>
    <th>$" . $price . "</th>
    <th>" . $onhand . "</th>
    <th><input type='checkbox' name='" . $p_id . "_select' value='" . $p_id . "'></td></th>
    <th><input type='number' name='" . $p_id . "_amount' value='1'></th>
    </tr>";
}
function rowSellingItem($p_id, $pic, $name, $description, $price, $onhand)
{
    echo "
    <tr>
    <th>" . $p_id . "</th>
    <th><img src='" . $pic . "' width='50px'></th>
    <th>" . $name . "</th>
    <th>" . $description . "</th>
    <th>$" . $price . "</th>
    <th>" . $onhand . "</th>
    <th><a href='../frontend/delete.php?did=".$p_id."'></a>Delete</th>
    </tr>";
}
function shoppingCart($dbc, $pstARRAY, $usrID = null)
{
    $cartID = createCart($dbc);
    if ($usrID != null) {
        foreach ($pstARRAY as $key => $value) {
            if (preg_match('/^(\d+)_select$/', $key, $matches)) {
                $productID = $matches[1];
                $quantity = isset($_POST["{$productID}_amount"]) ? intval($_POST["{$productID}_amount"]) : 0;
                //echo "Product ID: $productID | Quantity: $quantity<br>";
                $SUS = "INSERT Cart(UUID,C_ID,item_ID,item_Quan) VALUES ('$cartID','$usrID','$productID','$quantity')";
                //echo "The SUS Statement being sent to the DB: ".$SUS;
                mysqli_query($dbc, $SUS);
            }
        }
    } else {
        foreach ($pstARRAY as $key => $value) {
            if (preg_match('/^(\d+)_select$/', $key, $matches)) {
                $productID = $matches[1];
                $quantity = isset($_POST["{$productID}_amount"]) ? intval($_POST["{$productID}_amount"]) : 0;
                //echo "Product ID: $productID | Quantity: $quantity<br>";
                $SUS = "INSERT Cart(UUID,item_ID,item_Quan) VALUES ($cartID,$productID,$quantity)";
                mysqli_query($dbc, $SUS);
            }
        }
    }
}
function generateUUIDv4()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        random_int(0, 0xffff),
        random_int(0, 0xffff),
        random_int(0, 0xffff),
        random_int(0, 0x0fff) | 0x4000,
        random_int(0, 0x3fff) | 0x8000,
        random_int(0, 0xffff),
        random_int(0, 0xffff),
        random_int(0, 0xffff)
    );
}
function createCart($dbc)
{
    if (!isset($_SESSION['cart_id']) && !isset($_COOKIE['cart_id'])) {
        $UUID = generateUUIDv4();
        $_SESSION['cart_id'] = $UUID;
        setcookie('cart_id', $UUID, time() + (86400 * 30), "/");
        if (isset($_SESSION["ID"])) {
            $uid = $_SESSION["ID"];
            $SUS = "UPDATE cartUUID = '$UUID' WHERE ID='$uid'";
            echo "Updating the UserDB with the cart made while in guest mode. SUS" . $SUS;
            mysqli_query($dbc, $SUS);
        }
        return $UUID;
    } elseif (isset($_COOKIE['cart_id'])) {
        $_SESSION['cart_id'] = $_COOKIE["cart_id"];
        return $_COOKIE['cart_id'];
    } else {
        return $_SESSION['cart_id'];
    }
}
