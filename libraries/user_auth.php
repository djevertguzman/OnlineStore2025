<?php
function userAuthPASS($dbc, $expire)
{
    $email = test_input($_POST["email"]);
    $pw = test_input($_POST["pw"]);
    $sqs = "SELECT * FROM User WHERE email='$email'";
    $result = mysqli_query($dbc, $sqs);
    $numrows = mysqli_num_rows($result);
    if ($numrows == 1) {
        $row = mysqli_fetch_array($result);
        $dbpw = $row["passwd"]; //Verify the row name in DB.
        $dbfirstname = $row["firstname"];
        $user_type = $row["usr_type"];
        $_SESSION["ID"] = $row["ID"];
        $_SESSION["email"] = $email;
        $_SESSION["firstname"] = $dbfirstname;
        $verify = password_verify($pw, $dbpw);
        if ($verify || $pw == $dbpw) { // This is to handle quick db password changes. Disbale this at somepoint.
            //$_SESSION["pw"] = $pw;
            //Setting cookie for presistence.
            setcookie("userID", $row["ID"], $expire, "/");
            setcookie("email", $email, $expire,"/");
            setcookie("passwd", $pw, $expire, "/");
            mysqli_close($dbc);
            if ($user_type == 0) {
                header("Location:../backend/admin_list_items.php");
            } else {
                header("Location:../frontend/user_home.php");
            }
        } else {
            echo "Sorry, your password is not correct!";
        }
    } else if ($numrows == 0) {
        echo "Provided email not found, check spelling or make new account.";
    } else {
        echo "Something Happened! Please try again later.";
    }
}
function userAuthCOOKIE($dbc)
{
    $id = test_input($_COOKIE["userID"]);
    $pw = test_input($_COOKIE["passwd"]);
    $sqs = "SELECT * FROM User WHERE ID='$id'";
    $result = mysqli_query($dbc, $sqs);
    $numrows = mysqli_num_rows($result);
    if ($numrows == 1) {
        $row = mysqli_fetch_array($result);
        $dbpw = $row["passwd"]; //Verify the row name in db.
        $dbfirstname = $row["firstname"];
        $user_type = $row["usr_type"];
        $_SESSION["ID"] = $row["ID"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["firstname"] = $dbfirstname;
        $verify = password_verify($pw, $dbpw);
        if ($verify) {
            $_SESSION["pw"] = $pw;
            //We are not giving the user a new cookie, everytime they login by cookie.
            mysqli_close($dbc);
            if ($user_type == 0) {
                header("Location:../backend/admin_home.php");
            } else {
                header("Location:../frontend/user_home.php");
            }
        } else {
            echo "Hmm..... Something is wrong. Noted";
        }
    } else {
        echo "Something is wrong with your cookie, please sign in manually.";
    }
}
function changePasswd($db,$passOne, $passTwo, $id){
    $flag = true;
    if ($passOne == "") {
        $passwordErr = "Password is required!";
        $flag = false;
    } else {
        if ($passOne != $passTwo) {
            $passwordErr = "Password does not match!";
            $flag = false;
        }
    }
    $hashedPass = password_hash($passOne, PASSWORD_DEFAULT);
    if($flag == true){
        $SUS = "UPDATE User SET passwd='$hashedPass' WHERE ID='$id'";
        $result = mysqli_query($db,$SUS);
    }
    return $flag;
}
function delCOOKIE(){
    $expire  = time() - 60 * 10;
    setcookie("userID", "", $expire, "/");
            setcookie("email", "", $expire,"/");
            setcookie("passwd", "", $expire, "/");
}
function clearSession(){
    session_start();
    //for dev
    delCOOKIE();
    session_unset();
    session_destroy();
    $_SESSION=array();
}
?>