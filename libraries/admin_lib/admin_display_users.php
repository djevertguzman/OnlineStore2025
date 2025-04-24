<?php
function displayUsers($dbc,$sqs = "SELECT * FROM User"){
    $result = mysqli_query($dbc, $sqs);
    $rowCount = mysqli_num_rows($result);
    echo "
        <div class= 'productTable'>
        <table>
        <tr>
        <th>User ID</th>
        <th>Registration Date</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>User Type</th>
        <th>Edit</th>
        <th>Delete</th>
        </tr>";

    while ($row = mysqli_fetch_array($result)) {
        $name = $row["firstname"]." ".$row["lastname"];
        rowItem($row["ID"], $row["regDate"],$name, $row["email"], $row["phone"], $row["usr_type"]);
    }
    echo "</table>
    </div>
    ";
}
function rowItem($userID,$regDate, $name, $email, $phone, $userTYP)
{
    $type = "";
    if($userTYP == 0){
        $type = "Admin";
    }else{
        $type = "User";
    }
    echo "
    <tr>
    <th>" . $userID . "</th>
    <th>" . $regDate . "</th>
    <th>" . $name . "</th>
    <th>" . $email . "</th>
    <th>" . $phone . "</th>
    <th>" . $type . "</th>
    <th><a href='../libraries/admin_lib/edit_user.php?usr=".$userID."'>Edit</a></th>
    <th><a href='../libraries/admin_lib/delete_user.php?usr=".$userID."'>Delete</a></th>
    </tr>";
}

?>