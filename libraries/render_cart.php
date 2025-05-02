<?php
function renderCart($dbc, $cartUUID)
{
    $cartCOST = 0;
    $cartUUID = $_SESSION["cart_id"];
    $sqs = "SELECT
        c.UUID,
        c.item_ID,
        c.item_Quan,
        c.line,
        I.owner_id,
        I.p_name,
        I.p_description,
        I.p_price,
        I.p_picture,
        I.p_onhand

        FROM Cart AS c
        LEFT JOIN Item AS I ON c.item_ID = I.item_id
        WHERE c.UUID='$cartUUID';
        ";
    //echo "<h3>SQS:" . $sqs . "</h3><br>";
    $result = mysqli_query($dbc, $sqs);
    while ($row = mysqli_fetch_array($result)) {
        $rowCount = mysqli_num_rows($result);
        $formPST = htmlspecialchars($_SERVER["PHP_SELF"]);
        //print_r($row=mysqli_fetch_array($result));
        if (true) {
            echo "
        <div class= 'productTable'>
        <form action='" . $formPST . "' method='POST'>
        <table>
        <tr>
    <th>Item #</th>
    <th>Picture</th>
    <th>Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Onhand</th>
    <th>Quantity Requested</th>
    <th>Select</th>
    </tr>
        ";
            while ($row = mysqli_fetch_array($result)) {
                renderLine($row["line"], $row["item_ID"], $row["p_picture"], $row["p_name"], $row["p_description"], $row["p_price"], $row["p_onhand"], $row["item_Quan"], $row["owner_id"]);
                $cartCOST += $row["p_price"];
            }
            echo "</table>
            <h2>Item Total: $ " . $cartCOST . "</h2><br>
            <input type = 'submit' name='purchase' value='Buy Now'><input type = 'submit' name='remove' value='Remove From Cart'>
            </form>
            </div>
            ";
        }
    }
}
function renderLine($cartLine, $itemID, $itemPicture, $itemName, $itemDescription, $itemPrice, $itemONHAND, $custRESQ, $ownerID)
{
    echo "
    <tr>
    <th>" . $itemID . "</th>
    <th><img src='../store/item_picture/" . $itemPicture . "' width='50px'></th>
    <th>" . $itemName . "</th>
    <th>" . $itemDescription . "</th>
    <th>$" . $itemPrice . "</th>
    <th>" . $itemONHAND . "</th>
    <th><input type='number' name='" . $itemID . "_amount' value='" . $custRESQ . "'></th>
    <th><input type='checkbox' name='" . $itemID . "_select' value='" . $itemID . "'></th>
    <input type='hidden' name='" . $itemID . "_line' value='" . $cartLine . "'>
    <input type='hidden' name='" . $itemID . "_owner' value='" . $ownerID . "'>
    </tr>";
}
