<?php
require "../libraries/connectDB.php";
include "../libraries/announcements.php";
session_start();
?>
<html>
    <head>
        <title>Online Store - Admin Home</title>
        <link rel="stylesheet" href="../ui/online_store.css">
    </head>
    <body>
        <?php include "../navigation/admin_nav.php"; ?>
        <div class="textArea">
        <h1>The Beginning of the Admin Pages</h1>
        <?php renderAnnouncements($dbc);?>
        <p>Here you can view items listed by other users, or list your own items. Afterwards make sure to update your profile,
            and keep track of your items. In the order information page. Have a good day,
            and hopfully you'll find something life changing.</p>
    </div>
    </body>
</html>