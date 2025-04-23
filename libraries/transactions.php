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
        </tr>";

    while ($row = mysqli_fetch_array($result)) {
        rowItem($row["transact_id"], $row["item_id"], $row["amount"], $row["sold_date"], $row["seller_id"], $row["buyer_id"]);
    }
    echo "</table>
    </div>
    ";
}
function rowItem($transactID, $itemID, $amount, $soldDate, $sellerID, $buyerID)
{
    echo "
    <tr>
    <th>" . $transactID . "</th>
    <th>" . $itemID . "</th>
    <th>" . $amount . "</th>
    <th>" . $soldDate . "</th>
    <th>" . $sellerID . "</th>
    <th>" . $buyerID . "</th>
    </tr>";
}
