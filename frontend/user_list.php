<?php
require "../libraries/connectDB.php";
require "../libraries/input_sanitization.php";
include "../libraries/products.php";
session_start();
$itemName = $itemDescrip = $itemPrice = $itemPicture = $itemOnhand = $usrPIC = $picture = "";
$itemNameErr = $itemDescripErr = $itemPriceErr = $itemPictureErr = $itemOnhandErr = $success = "";
$usrID = $_SESSION["ID"];
$flag = 0;
$SQS = "SELECT * FROM Item WHERE owner_ID = '$usrID'";
$result = mysqli_query($dbc, $SQS);
$rowNum = mysqli_fetch_column($result);
if (!$rowNum <= 5) {
    $success = "<span class='error>You have hit the maximum amount of listings available.<br> Delete some to continue.</span>'";
    $flag = 1;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = test_input($_POST["itmName"]);
    $itemDescrip = test_input($_POST["itmDescrip"]);
    $itemPrice = test_input($_POST["itmPrice"]);
    $itemPicture = test_input($_POST["itmPIC"]);
    $itemOnhand = test_input($_POST["itmONHAND"]);
    //print_r($_POST);
    //print_r($_FILES);
    //All of this is related to picture upload.
    /*if (isset($_FILES["itmPIC"])) {
        //upload image
        $tagName = "itemPIC";
        $filesAllowed = "PNG:JPEG:JPG:GIF:BMP";
        $sizeAllowed = "10000000"; // about 10Mb
        $overWriteAllowed = 1;
        $picture = uploadFile($tagName, $filesAllowed, $sizeAllowed, $overWriteAllowed);
        if ($picture != false) {
            //display the image <img src = "fileName.extension">
            $usrPIC = "<img src=" . $picture . " width='300px'>";
        } else {
            $itemPictureErr =  "Sorry, file upload of the image has failed.";
            $flag = 1;
        }
    } else {
        $itemPictureErr = "Picture of the item you are trying to sell is required.";
        $flag = 1;
    }*/
    //End of picture upload.
    if (!isset($itemName)) {
        $itemNameErr = "Name of the item is required.";
        $flag = 1;
    }
    if (!isset($itemDescrip)) {
        $itemDescripErr = "A description of the item is required.";
        $flag = 1;
    }
    if (!isset($itemPrice)) {
        $itemPriceErr = "The price of the item is required.";
        $flag = 1;
    }
    if (!isset($itemOnhand)) {
        $itemOnhandErr = "How many of the item do you have? <br> A value of zero is acceptable.";
        $flag = 1;
    }
    if ($flag == 0) {
        $SIS = "INSERT INTO Item(owner_ID,p_name,p_description,p_price,p_onhand,p_picture) VALUES ($usrID,$itemName,$itemDescrip,$itemPrice,$itemOnhand,$picture)";
        $insresult = mysqli_query($dbc, $SIS);
        if ($insresult == 1) {
            $success = "<span class='success'>Item Listed Successfully!</span>";
        } else {
            $success = "<span class='error'>Listing item failed, look at errors above or email support.</span>";
        }
    }
}
?>
<html>

<head>
    <title>Online Store - List an Item For Sell</title>
    <link rel="stylesheet" href="../ui/online_store.css">
</head>

<body>
    <?php include "../navigation/user_nav.php"; ?>
    <div class="usrForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            Name: <input type="text" name="itmName" value="<?php echo $itemName; ?>"><span class="error"> * <?php echo $itemNameErr; ?></span><br><br>
            Description: <input type="text" name="itmDescrip" value="<?php echo $itemDescrip; ?>"><span class="error"> * <?php echo $itemDescripErr; ?></span><br><br>
            Price: <input type="text" name="itmPrice" value="<?php echo $itemPrice; ?>"><span class="error"> * <?php echo $itemPriceErr; ?></span><br><br>
            Picture:<span class="error"> * <?php echo $itemPictureErr; ?></span><input type="file" name="itmPIC"><?php echo $usrPIC; ?><br><br>
            Onhand: <input type="text" name="itmONHAND" value="<?php echo $itemOnhand; ?>"><span class="error"> * <?php echo $itemOnhandErr; ?></span><br><br>
            <input type="submit" value="List For Sale"> <?php echo $success ?>
        </form>
    </div>
    <br><hr>
    <?php
    $prosqs = "SELECT * From Item WHERE owner_ID='$usrID'";
    displayProduct($dbc,1,$prosqs);
    ?>
</body>

</html>