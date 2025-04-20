<?php
require "../libraries/connectDB.php";
session_start();

?>
<html>

<head>
    <title>Online Store - User Home</title>
    <link rel="stylesheet" href="../ui/online_store.css">
</head>

<body>
    <?php include "../navigation/user_nav.php"; ?>
    <div class="textArea">
        <h2>Start Here: </h2>
        <p>Here you can view items listed by other users, or list your own items. Afterwards make sure to update your profile,
            and keep track of your items. In the order information page. Have a good day,
            and hopfully you'll find something life changing.</p>
    </div>
</body>

</html>