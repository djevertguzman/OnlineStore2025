<?php
require "../../../OnlineStore/libraries/connectDB.php";
require "../../../OnlineStore/user_auth/admin_lib/admin_chk.php";
session_start();
$success = "";
if(isset($_POST["fate"])){
    if($_POST["fate"] == "Yes"){
        $judgement = $_SESSION["usrID"];
        $SDS = "DELETE FROM User WHERE ID='$judgement'";
        $SDSTwo = "DELETE FROM Item WHERE owner_ID='$judgement'";
        $resultOne = mysqli_query($dbc,$SDS);
        $resultTwo = mysqli_query($dbc,$SDSTwo);
        if($resultOne == 1 && $resultTwo == 1){
            $success = "<span class='success'><h2>User ".$judgement." Successfully Deleted <a href='../../backend/admin_users.php'>Click Here</a> to go back.</h2></span>'";
        }else{
            $success = "<span class='error'><h2>User ".$judgement." Successfully Deleted</h2></span>'";
        }
    }else{
        header("Location: ../../../backend/admin_users.php");
    }

}
?>
<html>
    <head>
        <title>Online Store - Admin Delete User</title>
        <link rel="stylesheet" href="../../ui/online_store.css">
    </head>
    <body>
        <?php
        if(checkAdmin($dbc)){
            if(isset($_GET["usr"])){
                $usrID = $_GET["usr"];
                $SQS = "SELECT * FROM User WHERE ID='$usrID'";
                $result = mysqli_query($dbc,$SQS);
                echo "
                <h2>Caution Deleting User:</h2>
                <div class= 'productTable'>
                <table>
                <tr>
                <th>User ID</th>
                <th>Registration Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                </tr>
                ";
                while($row = mysqli_fetch_assoc($result)){
                    //print_r($row);
                    $name = $row["firstname"]." ".$row["lastname"];
                    echo "
                    <tr>
                    <th>" . $row["ID"] . "</th>
                    <th>" . $row["regDate"] . "</th>
                    <th>" . $name . "</th>
                    <th>" . $row["email"] . "</th>
                    <th>" . $row["phone"] . "</th>
                    </tr>
                    ";
                    $_SESSION["usrID"] = $usrID;
                }
                echo "</table></div>";
                $forver = htmlspecialchars($_SERVER["PHP_SELF"]);
                echo "<form action='".$forver."' method='POST'>
                <input type='submit' name = 'fate' value = 'Yes'>
                <input type='submit' name = 'fate' value = 'No'>
                </form>";
            }
                echo $success;
        }
        ?>
    </body>
</html>