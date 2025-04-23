<?php
require "../libraries/connectDB.php";
require "../libraries/input_sanitization.php";
session_start();
//Defining the varibles for the errors.
$firstnameErr = $lastnameErr = $phoneErr = $emailErr =
    $levelErr = $genderErr = $passwordErr = $currPassErr = "";
$secQueErr = $secAnsErr = "";
//Defining the varibles for normal operation.
$usrID = "";
$password1 = $password2 = $dbpw = $currPass = $securityQOne = $securityAOne =
    $securityQTwo = $securityATwo = $securityQThree = $securityAThree = "";
$firstname = "Firstname";
$lastname = "Lastname";
$phone = "111-123-1234";
$email = "example@example.com";
$flag = 0; //no flag means ready to insert
//echo "Conained in SESSION ID: ".$_SESSION['ID']."<br>";
//print_r($_SESSION);
//echo "<br>";
if (isset($_SESSION["ID"])) {
    $usrID = $_SESSION["ID"];
    $SQS = "SELECT * FROM User WHERE ID='$usrID'";
    $result = mysqli_query($dbc, $SQS);
    $row = mysqli_fetch_array($result);
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $phone = $row["phone"];
    $email = $row["email"];
    $dbpw = $row["passwd"];
    $securityQOne = $row["secqusOne"];
    $securityAOne = $row["secansOne"];
    $securityQTwo = $row["secqueTwo"];
    $securityATwo = $row["secansTwo"];
    $securityQThree = $row["secqueThree"];
    $securityAThree = $row["secansThree"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST);
    $firstname = test_input($_POST["firstname"]);
    $lastname = test_input($_POST["lastname"]);
    $phone = test_input($_POST["phone"]);
    $email = test_input($_POST["email"]);
    $securityQOne = test_input($_POST["sQone"]);
    $securityAOne = strtolower(str_replace(' ', '', test_input($_POST["sAone"])));
    $securityQTwo = test_input($_POST["sQtwo"]);
    $securityATwo = strtolower(str_replace(' ', '', test_input($_POST["sAtwo"])));
    $securityQThree = test_input($_POST["sQthree"]);
    $securityAThree = strtolower(str_replace(' ', '', test_input($_POST["sAthree"])));
    $password1 = test_input($_POST["password1"]);
    $password2 = test_input($_POST["password2"]);
    $currPass = test_input($_POST["currPass"]);
    //Error checking, I'm moving this into it's own file later.
    if ($firstname == "" || $firstname == "Firstname") {
        $firstnameErr = "First Name is required!";
        $flag = 1;
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
            $firstnameErr = "Only letters and white space is allowed";
            $flag = 1;
        }
    }
    if ($lastname == "" || $lastname == "Lastname") {
        $lastnameErr = "First Name is required!";
        $flag = 1;
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
            $lastnameErr = "Only letters and white space is allowed";
            $flag = 1;
        }
    }
    if ($phone == "" || $phone == "111-123-1234") {
        $phoneErr = "Phone is required!";
        $flag = 1;
    } else {
        if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
            $phoneErr = "Please numbers and white space is allowed";
            $flag = 1;
        }
    }
    //Set up another condition to check for the default email.
    if ($email == "" || $email == "example@example.com") {
        $emailErr = "email is required";
        $flag = 1;
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email Format";
            $flag = 1;
        }
    }
    if (!password_verify($currPass, $dbpw)) {
        $currPassErr = "Wrong Password: Not Updating";
        $flag = 1;
    }
    if ($password1 == "") {
        $flag = 2;
    } elseif ($password1 != $password2) {
        $passwordErr = "Password does not match!";
        $flag = 1;
    }
    //Checking for Security Questions.
    if ($securityQOne == "" || $securityQTwo == "" || $securityQThree == "") {
        $secQueErr = "You must provide an answer for all three security questions. Try Again.";
        $flag = 2;
    }
    if ($securityAOne == "" || $securityATwo == "" || $securityAThree == "") {
        $secQueErr = "You must provide an answer for all three security questions. Try Again.";
        $flag = 2;
    }
    // Here is where were going to insert into database
    if ($flag == 0) {
        $password1 = password_hash($password1, PASSWORD_DEFAULT);
        //$sis = "INSERT INTO User(firstname,lastname,phone,email,passwd,secqusOne,secansOne,secqueTwo,secansTwo,secqueThree,secansThree) 
        //VALUES ('$firstname','$lastname','$phone','$email','$password1','$securityQOne','$securityAOne','$securityQTwo','$securityATwo','$securityQThree','$securityAThree')";
        $SUS = "UPDATE User SET firstname = '$firstname',lastname = '$lastname',phone = '$phone',email = '$email',passwd = '$password1',secqusOne = '$securityQOne',secansOne = '$securityAOne',secqueTwo = '$securityQTwo',secansTwo = '$securityATwo',secqueThree = '$securityQThree',secansThree = '$securityAThree' WHERE id ='$usrID'";
        echo "SUS: " . $SUS;
        mysqli_query($dbc, $SUS);
        //$regcompl = mysqli_affected_rows($dbc);
        //echo $regcompl . " User information has been stored sucessfully!";
        //header("Location:success.php");
    }
    if ($flag == 2) {
        $password1 = password_hash($password1, PASSWORD_DEFAULT);
        $SUS = "UPDATE User SET firstname = '$firstname',lastname = '$lastname',phone = '$phone',email = '$email',secqusOne = '$securityQOne',secansOne = '$securityAOne',secqueTwo = '$securityQTwo',secansTwo = '$securityATwo',secqueThree = '$securityQThree',secansThree = '$securityAThree' WHERE id ='$usrID'";
        echo "SUS: " . $SUS;
        mysqli_query($dbc, $SUS);
        //header("Location:success.php");
    }
}
?>
<html>

<head>
    <title>Online Store - Customer Profile</title>
    <link rel="stylesheet" href="../ui/online_store.css">
</head>

<body>
    <?php include "../navigation/user_nav.php"; ?>
    <div class="usrForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            First name: <input type="text" name="firstname" value="<?php echo $firstname; ?>"> <span class="error"><?php echo $firstnameErr; ?></span><br><br>
            Last name: <input type="text" name="lastname" value="<?php echo $lastname; ?>"> <span class="error"><?php echo $lastnameErr; ?></span><br><br>
            Phone: <input type="text" name="phone" value="<?php echo $phone; ?>"> <span class="error"><?php echo $phoneErr; ?></span><br><br>
            Email: <input type="text" name="email" value="<?php echo $email; ?>"> <span class="error"><?php echo $emailErr; ?></span><br><br>
            Current Password: <input type="password" name="currPass" maxlength="30"><span class="error"> * <?php echo $currPassErr; ?></span><br><br>
            New Password: <input type="password" name="password1" maxlength="30"><span class="error"> <?php echo $passwordErr; ?></span><br><br>
            Verify New Password: <input type="password" name="password2" maxlength="30"><span class="error"> <?php echo $passwordErr; ?></span><br><br>
            <!--Pair 1-->
            <hr>
            <h3>Caution treat these like a password, make sure you record your answer.</h3>
            Security Question 1: <input type="text" name="sQone" value="<?php echo $securityQOne; ?>"> <span class="error"><?php echo $secQueErr; ?></span><br><br>
            Security Answer 1: <input type="text" name="sAone" value="<?php echo $securityAOne; ?>"> <span class="error"><?php echo $secAnsErr; ?></span><br><br>
            <!--Pair 2-->
            Security Question 2: <input type="text" name="sQtwo" value="<?php echo $securityQTwo; ?>"> <span class="error"><?php echo $secQueErr; ?></span><br><br>
            Security Answer 2: <input type="text" name="sAtwo" value="<?php echo $securityATwo; ?>"> <span class="error"> <?php echo $secAnsErr; ?></span><br><br>
            <!--Pair 3-->
            Security Question 3: <input type="text" name="sQthree" value="<?php echo $securityQThree; ?>"> <span class="error"><?php echo $secQueErr; ?></span><br><br>
            Security Answer 3: <input type="text" name="sAthree" value="<?php echo $securityAThree; ?>"> <span class="error"><?php echo $secAnsErr; ?></span><br><br>
            <input type="submit">
        </form>

    </div>

</body>

</html>