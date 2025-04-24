<?php
function displayItems($dbc, $cliorsell = 0, $sqs = "SELECT * FROM Item")
{
    $result = mysqli_query($dbc, $sqs);
    $rowCount = mysqli_num_rows($result);
    $formPST = htmlspecialchars($_SERVER["PHP_SELF"]);
    //print_r($row=mysqli_fetch_array($result));
    if ($rowCount != 0) {
        echo "
        <div class= 'productTable'>
        <table>
        <tr>
    <th>Item#</th>
    <th>Owner ID</th>
    <th>Picture</th>
    <th>Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Onhand</th>
    <th>Edit</th>
    <th>Delete</th>
    </tr>";
        while ($row = mysqli_fetch_array($result)) {
            rowSellingItem($row["item_id"], $row["owner_ID"], $row["p_picture"], $row["p_name"], $row["p_description"], $row["p_price"], $row["p_onhand"]);
        }
        echo "</table>
    </div>
    ";
    } else {
        echo "<div class= 'productTable'>";
        echo "<h2> You have no items listed, add some so that they appear here.</h2>";
        echo "</div>";
    }
}
function rowSellingItem($p_id, $ownerID, $pic, $name, $description, $price, $onhand)
{
    echo "
    <tr>
    <th>" . $p_id . "</th>
    <th>" . $ownerID . "</th>
    <th><img src='" . $pic . "' width='50px'></th>
    <th>" . $name . "</th>
    <th>" . $description . "</th>
    <th>$" . $price . "</th>
    <th>" . $onhand . "</th>
    <th><a href='../frontend/edit.php?did=" . $p_id . "'>Delete</a></th>
    <th><a href='../frontend/delete.php?did=" . $p_id . "'>Delete</a></th>
    </tr>";
}
