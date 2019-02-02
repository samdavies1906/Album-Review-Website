<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($pplayers)
{
    $tplayerprofile = "";
    foreach($pplayers as $tp)
    {
        $tplayerprofile .= renderPlayerOverview($tp);
    }
    $tcontent = <<<PAGE
      {$tplayerprofile}
PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$tplayers = [];
$tid = $_REQUEST["id"] ?? -1;
$tname = $_REQUEST["name"] ?? "";


//Handle our Requests and Search for Players
if (is_numeric($tid) && $tid > 0) 
{
    $tplayer = jsonLoadOnePlayer($tid);
    $tplayers[] = $tplayer;
} 
else if (!empty($tname)) 
{
    //Filter the name
    $tname = processRequest($tname);
    $tplayerlist = jsonLoadAllPlayer();
    foreach ($tplayerlist as $tp)
    {
        if (strtolower($tp->artist) === strtolower($tname)) 
        {
            $tplayers[] = $tp;
        }
    }
}

//Page Decision Logic - Have we found a player?
if (count($tplayers)===0) 
{
    header("Location: app_error.php");
} 
else
{
    //We've found our player
    $tpagecontent = createPage($tplayers);
    
    $tpagetitle = "Album Details";
    $tpagelead = "";
    $tpagefooter = "";
    
    // ----BUILD OUR HTML PAGE----------------------------
    // Create an instance of our Page class
    $tpage = new MasterPage($tpagetitle);
    // Set the Three Dynamic Areas (1 and 3 have defaults)
    if (! empty($tpagelead))
        $tpage->setDynamic1($tpagelead);
    $tpage->setDynamic2($tpagecontent);
    if (! empty($tpagefooter))
        $tpage->setDynamic3($tpagefooter);
        // Return the Dynamic Page to the user.
    $tpage->renderPage();
}
?>