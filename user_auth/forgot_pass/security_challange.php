<?php
require "../../../OnlineStore/libraries/connectDB.php";
require "../../../OnlineStore/libraries/input_sanitization.php";
$question = $answer = "";
$_SESSION["challangePass"] = 0;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usranswer = strtolower(str_replace(' ', '',test_input($_POST["usrans"])));
    $dbans = $_SESSION["dbans"];
    if(levenshtein($usranswer, $dbans) <= 2){
        $_SESSION["challangePass"] = 1;
        header("Location:password_change.php");
    }else{
        $attStatus = $_SESSION["attRemain"];
        $_SESSION["attRemain"] -= 1;
        if($_SESSION["attRemain"] == 0){
        $attStatus = "Goodbye";
        header("Location:../index.php");
        }
    }

}elseif (isset($_SESSION["forgotID"])) {
    $_SESSION["attRemain"] = 3;
    $usrID = $_SESSION["forgotID"];
    $SQS = "SELECT secqusOne,secansOne,secqueTwo,secansTwo,secqueThree,secansThree FROM User WHERE ID='$usrID'";
    $result = mysqli_query($dbc, $SQS);
    $row = mysqli_fetch_array($result);
    generateChallange($row);
} else {
    echo "<h1>Go Away</h1>";
}
?>
<html>

<head>
    <title>Online Store - Security Challange</title>
    <link rel="stylesheet" href="../ui/online_store.css">
</head>
<body>
    <h2>Security Question:</h2><br>
    <p>Attempts Remain: <?php $attStatus?></p>
    <p><?php echo $question;?></p>
    <form>
        <input type="text" value="usrans">
        <input type="submit">
    </form>
</body>
</html>
<?php
function generateChallange($row)
{
    $random = random_int(1, 3);
    if ($random == 1) {
        $question = $row["secqusOne"];
        $_SESSION["dbans"] = $row["secansOne"];
    }
    if ($random == 2) {
        $question = $row["secqusTwo"];
        $_SESSION["dbans"] = $row["secansTwo"];
    }
    if ($random == 3) {
        $question = $row["secqusThree"];
        $_SESSION["dbans"] = $row["secansThree"];
    }
}
?>