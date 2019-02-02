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
<legend>User Review</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectalbum">Select Album To Review</label>
  <div class="col-md-4">
    <select id="selectalbum" name="selectalbum" class="form-control">
      <option value="KOD">KOD</option>
      <option value="Stoney">Stoney</option>
      <option value="Starboy">Starboy</option>
      <option value="Lil Boat 2">Lil Boat 2</option>
      <option value="More Life">More Life</option>
      <option value="Konnichiwa">Konnichiwa</option>
      <option value="Birds In The Trap Sing McKnight">Birds In The Trap Sing McKnight</option>
      <option value="Godfather">Godfather</option>
      <option value="Luv Is Rage 2">Luv Is Rage 2</option>
      <option value="Integrity">Integrity</option>
      <option value="DAMN.">DAMN.</option>
      <option value="The Life Of Pablo">The Life Of Pablo</option>
      <option value="HNDRXX">HNDRXX</option>
      <option value="Coloring Book">Coloring Book</option>
    </select>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="Rating">Rating</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="Rating-0">
      <input type="radio" name="Rating" id="Rating-0" value="1" checked="checked">
      1
    </label> 
    <label class="radio-inline" for="Rating-1">
      <input type="radio" name="Rating" id="Rating-1" value="2">
      2
    </label> 
    <label class="radio-inline" for="Rating-2">
      <input type="radio" name="Rating" id="Rating-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="Rating-3">
      <input type="radio" name="Rating" id="Rating-3" value="4">
      4
    </label> 
    <label class="radio-inline" for="Rating-4">
      <input type="radio" name="Rating" id="Rating-4" value="5">
      5
    </label>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="review">Review</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="review" name="review">default text</textarea>
  </div>
</div>
<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="form-sub"></label>
  <div class="col-md-4">
    <button id="form-sub" name="form-sub" type =""submit class="btn btn-danger">Submit</button>
  </div>
</fieldset>
</form>
    


PAGE;
    
   
    
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$tpagecontent = "";
$tauthor = $_SESSION["myemailaddress"];

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    
    $talbum = processRequest($_REQUEST["selectalbum"]?? "");
    $trating = processRequest($_REQUEST["Rating"] ?? "");
    $treview = processRequest($_REQUEST["review"] ?? "");
        
    $tvalid = true;
    //if(is_numeric("fname"))
   // {
    	//$tvalid = false;
    //}
    
    if($tvalid)
    {

//save the file
    	file_put_contents("data/html/reviews-{$talbum}.html","<br>Review posted by - $tauthor <br> Score - {$trating}/5</br></br><p> \"$treview\" </p>".PHP_EOL,FILE_APPEND);
 
$tdest = $_SERVER["PHP_SELF"];
$tpagecontent = <<<success
    <div class="well">
    		<h1>You Review has been submitted</h1>
    				<a class="btn btn-success" href="$tdest">Add Another Review</a>
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
$tpagetitle = "User Review Page";
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