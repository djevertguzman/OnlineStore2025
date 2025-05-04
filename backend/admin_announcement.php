<?php
require "../libraries/connectDB.php";
require "../user_auth/admin_lib/admin_chk.php";
session_start();
$success = "";
$usrID = $_SESSION["ID"];
if(checkAdmin($dbc)){
    //echo "Canary 1: PostArray:<br>";
    //print_r($_POST);
    if(isset($_POST["comment"])){
        //echo "Canary 2";
        $comment = $_POST["comment"];
        $SIS = "INSERT INTO announcement(message) VALUES ('$comment') ";
        //echo "<br>SIS: ".$SIS."<br>";
        $result = mysqli_query($dbc,$SIS);
        if($result = 1){
            $success = "<span class='success'><h2>Announcement Posted Successfully</h2></span>";
        }else{
            $success = "<span class='error'><h2>Announcement Post Failed</h2></span>";
        }

    }
}
?>
<html>

<head>
    <title>Online Store - Admin Home</title>
    <link rel="stylesheet" href="../ui/online_store.css">
</head>

<body>
    <?php include "../navigation/admin_nav.php"; ?>
    <div class="usrForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="usrform">
            Post Announcement: <br><br><textarea rows="4" cols="40" name="comment" form="usrform">Enter text here...</textarea><br><br>
            <input type="submit" value="submit"><?php echo $success?>
        </form>
    </div>
</body>

</html>