<?php
function displayTransactions($dbc, $sqs)
{
    //Modify this to follow the constructor, and display transactions.
    $result = mysqli_query($dbc, $sqs);
    $rowCount = mysqli_num_rows($result);
    echo "
        <div class= 'productTable'>
        <table>
        <tr>
        <th>Transaction ID</th>
        <th>Item ID</th>
        <th>Quanitity Ordered</th>
        <th>Sold (UTC)</th>
        <th>Seller</th>
        <th>Buyer</th>
        <th>Item Name</th>
        <th>Price</th>
        <th>Description</th>
        </tr>";

    while ($row = mysqli_fetch_array($result)) {
        rowItem($row["transact_id"], $row["item_id"], $row["amount"], $row["sold_date"], $row["seller_id"], $row["buyer_id"], $row["p_name"], $row["p_price"], $row["p_description"]);
    }
    echo "</table>
    </div>
    ";
}
function rowItem($transactID, $itemID, $amount, $soldDate, $sellerID, $buyerID, $itmName, $itmPrice, $itmDes)
{
    echo "
    <tr>
    <th>" . $transactID . "</th>
    <th>" . $itemID . "</th>
    <th>" . $amount . "</th>
    <th>" . $soldDate . "</th>
    <th>" . $sellerID . "</th>
    <th>" . $buyerID . "</th>
    <th>" . $itmName . "</th>
    <th>" . $itmPrice . "</th>
    <th>" . $itmDes . "</th>
    </tr>";
}
