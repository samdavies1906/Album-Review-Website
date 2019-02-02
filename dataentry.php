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
<legend>Register</legend>
    		
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
    <button id="form-sub" name="form-sub" type =""submit class="btn btn-danger">Register</button>
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
    //Map the Form Data to our User Class
    $tuser = new BLLuser();
    $tuser->Emailaddress = processRequest($_REQUEST["emailaddress"] ?? "");
    $tuser->Password = processRequest($_REQUEST["password"] ?? "");
        
    $tvalid = true;
    //if(is_numeric("fname"))
   // {
    	//$tvalid = false;
    //}
    
    if($tvalid)
    {
//Generate the users ID
$tuser->id = jsonNextUserID();
//convert the the player to json
$tsavedata = json_encode($tuser).PHP_EOL;

//Get the existing contents and append the data
$tfilecontent = file_get_contents("data/json/users.json");
$tfilecontent.=$tsavedata;

//save the file
file_put_contents("data/json/users.json", $tfilecontent);
 
$tdest = $_SERVER["PHP_SELF"];
$tpagecontent = <<<success
    <div class="well">
    		<h1>New account has been made</h1>
    				<a class="btn btn-success" href="$tdest">Add Another Account</a>
    		</div>
success;
    } 
    
    else 
    {
        $tpagecontent = <<<ERROR
                         <div class="well">
                            <h1>Form was Invalid</h1>
                            <a class="btn btn-warning" href="$tdest">Try Again</a>
                         </div>
ERROR;
    }
        
    

}
else
{
    //This page will be created by default.
    $tpagecontent = createFormPage();
}
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