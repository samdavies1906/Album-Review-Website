<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----BUSINESS LOGIC---------------------------------
//Start up a PHP Session for this user.
session_start();
$tmyname = $_REQUEST["myemailaddress"] ?? "";
$tlogintoken = $_SESSION["myemailaddress"] ?? "";
if(empty($tlogintoken) && !empty($tmyname))
{
    $_SESSION["myemailaddress"] = processRequest($tmyname);
    $_SESSION["entered"] = true;
    header("Location: index.php");
}
else
{
    header("Location: app_error.php");
}

?>