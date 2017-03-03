<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['groupname']) && isset($_SESSION['projectNum'])){
include_once "LogsFunctions.php";
$message="New Logs";
$infoType="Good";
warnlog($message);
errlog($message);
infolog($message,$infoType);
}
?>
