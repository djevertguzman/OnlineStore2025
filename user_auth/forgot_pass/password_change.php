<?php
require "../OnlineStore/libraries/connectDB.php";
require "../OnlineStore/libraries/input_sanitization.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../OnlineStore/libraries/user_auth.php";
    $password = test_input($_POST["passwd"]);
    $passwordVer = test_input($_POST["passwdVer"]);
    $currid = $_SESSION["forgotID"];
    $changeOper = changePasswd($dbc,$password, $passwordVer, $currid);
    if($changeOper){
        clearSession();
        header("Location:change_success.php");
    }else{
        echo "Something has gone wrong. Error Code: 2223";
    }
} elseif ($_SESSION["challangePass"] == 1) {
    $currid = $_SESSION["forgotID"];
    $SQS = "SELECT firstname, lastname FROM User WHERE ID='$currid'";
    $result = mysqli_query($dbc, $SQS);
    $row = mysqli_fetch_row($result);
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $usrName = $firstname + ", " + $lastname;
} else {
    echo "<h1>How did you even get here?</h1>";
}
?>
<html>

<head>
    <title>Online Store - Change Password</title>
    <link rel="stylesheet" href="../ui/online_store.css">
    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>
    <?php include "../OnlineStore/navagation/guest_nav.php";?>
    <h3>Welcome back <?php echo $usrName; ?></h3>
    <p>Change your password below.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        Password: <input type="text" name="passwd"><span class="error"> * <?php echo $passwordErr; ?></span>
        Password Verfification: <input type="text" name="passwdVer"><span class="error"> * <?php echo $passwordErr; ?></span>
        <input type="submit">
    </form>
</body>

</html>