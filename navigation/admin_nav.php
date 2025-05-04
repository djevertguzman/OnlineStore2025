<?php
$specialChar = htmlspecialchars($_SERVER["PHP_SELF"]);
echo "
<div class='headerbar'>
<h2>Student Online Store</h2>
<div class='navbar'>
<table>
<tr>
<th><a href='./admin_home.php' alt='Main Home'>Home</a></th>
<th><a href='./admin_list_items.php' alt='Listed Items page'>Listed Items</th>
<th><a href='./admin_transactions.php' alt='Listings that have completed'>Recent Transactions</a></th>
<th><a href='./admin_users.php' alt='Manage Users Page'>Manage Users</th>
<th><a href='./admin_announcement.php' alt='Create Announcement'>Manage Announcement</th>
<th><a href='../frontend/user_home.php' alt='Switch To User Mode'>User Mode</a></th>
<th><form action='".$specialChar."' method='POST'><input type='submit' name='chaLight' value='Light Mode' class='light-button'></form></th>
<th><a href='../user_auth/logoff.php' alt='Logoff'>Logoff</a></th>
</tr>
</table>
</div>
</div>
";
?>