<?php
include "../user_auth/admin_lib/admin_chk.php";
$specialChar = htmlspecialchars($_SERVER["PHP_SELF"]);
echo "
<div class='headerbar'>
<h2>Student Online Store</h2>
<div class='navbar'>
<table>
<tr>
<th><a href='../frontend/user_home.php' alt='User Home'>Home</a></th>
<th><a href='../frontend/user_product.php' alt='Product Page'>Products</th>
<th><a href='../frontend/user_transactions.php' alt='Order Information'>Order Information</a></th>
<th><a href='../frontend/user_profile.php' alt='Profile'>User Profile</a></th>
<th><a href='../frontend/user_list.php' alt='Sell Item'>Sell Item</a></th>
<th><a href='../frontend/user_cart.php' alt='Cart'>Cart</a></th>";
if(checkAdmin($dbc,$_SESSION["ID"]) == true){
    echo "<th><a href='../backend/admin_home.php' alt='Return to admin mode'>Admin Mode</a></th>";
}
echo "
<th><form action='".$specialChar."' method='POST'><input type='submit' name='chaLight' value='Light Mode' class='light-button'></form></th>
<th><a href='../user_auth/logoff.php' alt='Logoff'>Logoff</a></th>
</tr>
</table>
</div>
</div>
";
?>