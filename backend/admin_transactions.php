<?php
require "../libraries/connectDB.php";
require "../user_auth/admin_lib/admin_chk.php";
require "../libraries/admin_lib/admin_transact.php";
require "../libraries/input_sanitization.php";
session_start();
$usrID = $_SESSION["ID"];
$range = "";
$sqs = "";
if (checkAdmin($dbc, $usrID)) {
    //echo "<h2>Admin chk good Continue</h2>";
    $range = "seven";
    $sqs = "SELECT 
    T.transact_id,
    T.item_id,
    T.amount,
    T.sold_date,
    T.seller_id,
    T.buyer_id,
    I.p_name,
    I.p_description,
    I.p_price
    FROM Transactions AS T 
    RIGHT JOIN Item AS I ON I.item_ID = T.item_id
    WHERE sold_date >= NOW() - INTERVAL 7 DAY";
    //echo "<br>sqs:".$sqs."<br>";
    if (isset($_POST["range"])) {
        if ($_POST["range"] == "threezero") {
            $range = "threezero";
            $range = "seven";
            $sqs = "SELECT 
            T.transact_id,
            T.item_id,
            T.amount,
            T.sold_date,
            T.seller_id,
            T.buyer_id,
            I.p_name,
            I.p_description,
            I.p_price
            FROM Transactions AS T 
            RIGHT JOIN Item AS I ON I.item_ID = T.item_id
            WHERE sold_date >= NOW() - INTERVAL 30 DAY";
        }
    }
} else {
    echo "<h1>Go Away</h1>";
}
?>
<html>

<head>
    <title>Online Store - Admin Transactions</title>
    <link rel="stylesheet" href="../ui/online_store.css">
</head>

<body>
    <?php
    include "../navigation/admin_nav.php"; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        Show transactions for the previous: <input type="radio" name="range" <?php if (isset($range) && $range == "seven") echo "checked"; ?> value="seven"> 7 Days
        <input type="radio" name="range" <?php if (isset($range) && $range == "threezero") echo "checked"; ?> value="threezero"> 30 Days<br>
        <input type="submit" value="Change">
    </form>
    <?php
    echo "<h2>Items Bought, and Sold</h2>";
    displayTransactions($dbc, $sqs);
    ?>

</body>

</html>