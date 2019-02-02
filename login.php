<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");
// ----PAGE GENERATION LOGIC---------------------------
function createFormPage()
{
	$tdest = htmlspecialchars($_SERVER["PHP_SELF"]);
	$tmethod = "post";
    $tcontent = <<<PAGE
    <form class="form-horizontal" method="$tmethod" action="$tdest">
	<fieldset>
		
<!-- Form Name -->
<legend>Login</legend>
    		
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="emailaddress">email</label>  
  <div class="col-md-4">
  <input id="emailaddress" name="emailaddress" type="email" placeholder="example@example.com" class="form-control input-md">
    
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password</label>
  <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="" class="form-control input-md">
    
  </div>
</div>

    		<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="form-sub"></label>
  <div class="col-md-4">
    <button id="form-sub" name="form-sub" type =""submit class="btn btn-danger">Login</button>	
    		 
  </div>		
</fieldset>
</form>
</div> 		
</form>
PAGE;
    
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$tpagecontent = "";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$tusers = jsonLoadAllUser();
	foreach($tusers as $u)
	{
		if($u->Emailaddress == processRequest($_REQUEST["emailaddress"] ?? "") && $u->Password == processRequest($_REQUEST["password"] ?? ""))
		{
			$temailaddress = $_REQUEST["emailaddress"] ?? "";
			$tlogintoken = $_SESSION["myemailaddress"] ?? "";
			if(empty($tlogintoken) && !empty($temailaddress))
			{
				$_SESSION["myemailaddress"] = processRequest($temailaddress);
			}
			
			header("Location:index.php");
		}
		
}
	
}
	
    
    //This page will be created by default.
    $tpagecontent = createFormPage();

$tpagetitle = "User Entry Page";
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

?>