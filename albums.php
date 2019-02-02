<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----PAGE GENERATION LOGIC---------------------------

function createPage($pimgdir,$pcurrpage,$psortmode,$psortorder)
{  
    //Get the Presentation Layer content
    $tci = xmlLoadAll("data/xml/carousel-squad.xml","PLCarouselImage","Image");
   
    include("ajax-albums.php");
    $tsquadtable = createSquadElement($pcurrpage,$psortmode,$psortorder);
    
    //Use the Presentation Layer to build the UI Elements
    $tcarousel   = renderUICarousel($tci,"{$pimgdir}/carousel");
   
        
$tcontent = <<<PAGE
        {$tcarousel}
		<ul class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li class="active">Albums</li>
		</ul>
		<div class="row">
		</div>
		<div class="row">
			<div class="panel panel-primary">
			<div class="panel-body">
				<h2>List Of Albums</h2>
				<div id="squad-table">
			    {$tsquadtable}
		        </div>
		    </div>
			</div>
		</div>
		<div class="row">
            
		</div>
PAGE;

return $tcontent;
}

//----BUSINESS LOGIC---------------------------------
//Start up a PHP Session for this user.
session_start();
$tcurrpage = $_REQUEST["page"] ?? 1;
$tcurrpage = is_numeric($tcurrpage) ? $tcurrpage: 1;
$tsortmode = $_REQUEST["sortmode"] ?? "squadno";
$tsortorder = $_REQUEST["sortorder"] ?? "asc";

$tpagetitle = "Album Information";
$tpage = new MasterPage($tpagetitle);
$timgdir = $tpage->getPage()->getDirImages();

//Build up our Dynamic Content Items. 
$tpagelead  = "";
$tpagecontent = createPage($timgdir,$tcurrpage,$tsortmode,$tsortorder);
$tpagefooter = "";

//----BUILD OUR HTML PAGE----------------------------
//Set the Three Dynamic Areas (1 and 3 have defaults)
if(!empty($tpagelead))
    $tpage->setDynamic1($tpagelead);
$tpage->setDynamic2($tpagecontent);
if(!empty($tpagefooter))
    $tpage->setDynamic3($tpagefooter);
//Return the Dynamic Page to the user. 
    $tpage->addScriptFile("ajax-albums.js");
    $tpage->renderPage();
?>