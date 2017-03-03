<?php
include_once "LogsFunctions.php";
$gName="Logs Team";
$uName="Mohamed Gnedy";
$message="Log Message";
$infoType="Success";
warnlog($gName,$uName,$message);
errlog($gName,$uName,$message);
infolog($gName,$uName,$message,$infoType);

?>
