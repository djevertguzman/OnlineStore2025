<?php
require "../../../OnlineStore/libraries/connectDB.php";
require "../../../OnlineStore/libraries/input_sanitization.php";
require "../../../OnlineStore/libraries/changeStyle.php";
session_start();
$question = $answer = "";
if (isset($_SESSION["attRemain"])) {
    $attStatus = $_SESSION["attRemain"];
} else {
    $attStatus = 3;
}
$_SESSION["challangePass"] = 0;
//print_r($_SESSION);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "<br>IN POST<br>";
    //print_r($_POST);
    $usrID = $_SESSION["forgotID"];
    $usranswer = strtolower(str_replace(' ', '', test_input($_POST["usrans"])));
    $dbans = $_SESSION["dbans"];
    //echo "<br>USRANS: " . $usranswer . "DBANS: " . $dbans . "<br>";
    if (levenshtein($usranswer, $dbans) <= 2) {
        $_SESSION["challangePass"] = 1;
        session_unset($_SESSION["attRemain"]);
        header("Location:password_change.php");
    } else {
        $attStatus = $_SESSION["attRemain"];
        $_SESSION["attRemain"] -= 1;
        $question = generateChallange($dbc,$usrID);
        if ($_SESSION["attRemain"] == 0) {
            $attStatus = "Goodbye";
            session_unset($_SESSION["attRemain"]);
            header("Location:../../index.php");
        }
    }
} elseif (isset($_SESSION["forgotID"])) {
    //echo "<br>IN SESSION<br>";
    $_SESSION["attRemain"] = 3;
    $usrID = $_SESSION["forgotID"];
    $question = generateChallange($dbc,$usrID);
} else {
    //echo "<br>IN ELSE<br>";
    echo "<h1>Go Away</h1>";
}
?>
<html>

<head>
    <title>Online Store - Security Challange</title>
    <link rel="stylesheet" href="../../ui/<?php echo retriveStyle();?>">
</head>

<body>
    <?php include "guest_nav.php"; ?>
    <div class="usrForm">
        <p>Attempts Remain: <?php echo $attStatus ?></p>
        <h2>Security Question:</h2>
        <p><?php echo $question; ?></p><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="text" name="usrans">
            <input type="submit">
        </form>
    </div>
</body>

</html>
<?php
function generateChallange($dbc,$usrID)
{
    $SQS = "SELECT secqusOne,secansOne,secqueTwo,secansTwo,secqueThree,secansThree FROM User WHERE ID='$usrID'";
    $result = mysqli_query($dbc, $SQS);
    $row = mysqli_fetch_array($result);
    $random = random_int(1, 3);
    if ($random == 1) {
        $question = $row["secqusOne"];
        $_SESSION["dbans"] = $row["secansOne"];
    }
    if ($random == 2) {
        $question = $row["secqueTwo"];
        $_SESSION["dbans"] = $row["secansTwo"];
    }
    if ($random == 3) {
        $question = $row["secqueThree"];
        $_SESSION["dbans"] = $row["secansThree"];
    }
    return $question;
}
?>