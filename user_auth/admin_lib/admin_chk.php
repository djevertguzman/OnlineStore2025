<?php
function checkAdmin($dbc,$usrID = null){
    if ($usrID === null && isset($_SESSION["ID"])) {
        $usrID = $_SESSION["ID"];
    }
    $usrCHK = "SELECT usr_type FROM User WHERE ID='$usrID' LIMIT 1";
    $result = mysqli_query($dbc,$usrCHK);
    $row = mysqli_fetch_assoc($result);
    $usrType = $row["usr_type"];
    if($usrType == 0){
        return true;
    }
        return false;
}
?>