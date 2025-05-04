<?php
function startStyle()
{
    $expire  = time() + 60 * 60; //Setting cookie expiration time to 1 hour.
    if (!isset($_COOKIE["light"])) {
        setcookie("light", 1, $expire, "/");
        header("Location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    return;
}
function changeStyle()
{
    $expire  = time() + 60 * 60 * 24;
    if ($_COOKIE["light"] == 0) {
        setcookie("light", 1, $expire, "/");
    } elseif ($_COOKIE["light"] == 1) {
        setcookie("light", 0, $expire, "/"); 
    }
    //echo $_COOKIE["light"];
    header("Location: ".$_SERVER['REQUEST_URI']);
    exit;
}
function retriveStyle()
{
    if ($_COOKIE["light"] == 0) {
        return "online_store_dark.css";
    } else {
        return "online_store.css";
    }
}
?>