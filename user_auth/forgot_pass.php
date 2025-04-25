<?php
require "../libraries/connectDB.php";
require "../libraries/input_sanitization.php";
session_start();
$email = $emailErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $SQS = "SELECT ID FROM User WHERE email='$email'";
    $result = mysqli_query($dbc,$SQS);
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        //echo "<br>";
        //print_r($row);
        $_SESSION["forgotID"] = $row["ID"];
        //echo "<br>SESSION Array:<br>";
        //print_r($_SESSION);
        header("Location:forgot_pass/security_challange.php");
    }elseif(mysqli_affected_rows($dbc) == 0){
        $emailErr = "Email not found, make a new account or check your spelling, and try again.";
    }else{
        $emailErr = "Send an email to the support email, listed in contact us. Error Code: 2222";
    }
}
?>
<html>
    <head>
        <title>Online Store - Templete</title>
        <link rel="stylesheet" href="../ui/online_store.css">
    </head>
    <body>
        <?php include "guest_nav.php";?>
        <div class="usrForm">
        <h2>If you have forgotten your password. Enter your email below, and follow the instructions.</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        Email: <input type="text" name="email" value="<?php echo $email; ?>"> <span class="error"> * <?php echo $emailErr; ?></span><br><br>
        <input type="submit">
        </form>
    </div>

    </body>
</html>