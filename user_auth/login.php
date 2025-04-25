<?php
session_start();
require "../libraries/connectDB.php";
require "../libraries/input_sanitization.php";
$expire  = time() + 60 * 60; //Settting cookie expiration time to 1 hour.
require_once "../libraries/user_auth.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    userAuthPASS($dbc, $expire);
} elseif (isset($_COOKIE['userID'])) {
    userAuthCOOKIE($dbc);
}
?>
<html>

<head>
    <title>Online Store - Login</title>
    <link rel="stylesheet" href="../ui/online_store.css">
</head>

<body>
        <?php include "guest_nav.php";?>
        <div class="usrLogin">
    <p>If your a new user <a href="registration.php">click here</a> to sign up.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        Email: <input type="text" name="email" maxlength="50"><br><br>
        Password: <input type="password" name="pw" maxlength="25"><br><br><a href="forgot_pass.php">Forgot Password</a><br><br>
        <input type="submit" name="login" value="LOGIN">
    </form>
    </div>
    

</body>

</html>