<?php
$specialChar = htmlspecialchars($_SERVER["PHP_SELF"]);
echo "
<div class='headerbar'>
<h2>Student Online Store</h2>
<div class='navbar'>
<table>
<tr>
<th><a href='./index.php' alt='Main Home'>Home</a></th>
<th><a href='./index.php' alt='Product Page'>Products</th>
<th><form action='".$specialChar."' method='POST'><input type='submit' name='chaLight' value='chaLight' class='light-button'></form></th>
<th><a href='./user_auth/login.php' alt='Login Page'>Login</a></th>
</tr>
</table>
</div>
</div>
";
?>