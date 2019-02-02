<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----SORTING FUNCTIONS-------------------------------
function squadsortbyno($a,$b)
{
    if($a->Artist > $b->Artist)
        return 1;
    else if($a->Artist < $b->Artist)
        return -1;
    else 
        return 0;
}

function squadsortbyname($a,$b)
{
    return strcmp($a->Album,$b->Album);
}

//----PAGE GENERATION LOGIC---------------------------
function createPagination($pno,$pcurr)
{
    if($pno <= 1)
        return "";    
    $titems = "";
    $tld= $pcurr == 1 ? " class=\"disabled\"" : "";
    $trd = $pcurr == $pno ? " class=\"disabled\"" : "";
    
    $tprev = $pcurr - 1;
    $tnext = $pcurr + 1;
    
    $tprevitem = "<li$tld><a href=\"albums.php?page={$tprev}\">&laquo;</a></li>";
    for($i = 1; $i <=$pno; $i++)
    {   
        $ta = $pcurr == $i? " class=\"active\"" : "";
        $titems .= "<li$ta><a id=\"sq-{$i}\" href=\"albums.php?page={$i}\">{$i}</a></li>"; 
    }
    $tnextitem = "<li$trd><a href=\"albums.php?page={$tnext}\">&raquo;</a></li>";
    
    $tmarkup = <<<NAV
    <div id="sq-nav">
    <ul id="sq-prev" class="pagination pagination-sm">
        {$tprevitem}
    </ul>
    <ul id="sq-page" class="pagination pagination-sm">
        {$titems}
    </ul>
    <ul id="sq-next" class="pagination pagination-sm">
        {$tnextitem}
    </ul>
    </div>
NAV;
    return $tmarkup;
}

function createSquadElement($pcurrpage,$psortmode,$psortorder)
{     
    //Get Business Logic Data we need - in this case, build a squad
    $tsquad = new BLLSquad();
    $tsquad->captainindex = 8;
    $tsquad->starplayerindex = 9;
    $tsquad->squadname = "1st Team Squad";
    $tsquad->squadlist = jsonLoadAllPlayer();
    
    //We need to sort the squad using our custom class-based sort function
    $tsortfunc = "";
    if($psortmode == "Artist")
    {
    	$tsortfunc = "sortbyartist";
    }
    	else if($psortmode == "Album")
    	{
    		$tsortfunc = "sortbyalbum";
    	}
    	//only sort the array if we have a valid function name
    	if(!empty($tsortfunc))
    	{
    		usort($tsquad->squadlist,$tsortfunc);
    	}
    //The pagination working out how many elements we need and
    $tnoitems  = sizeof($tsquad->squadlist);
    $tperpage  = 5;
    $tnopages  = ceil($tnoitems/$tperpage);
    
    //Create a Pagniated Array based on the number of items and what page we want.
    $tfiltersquad = paginateArray($tsquad->squadlist,$pcurrpage,$tperpage);
    $tsquad->squadlist = $tfiltersquad;
    
    //Render the HTML for our Table and our Pagination Controls
    $tsquadtable = renderPlayerTable($tsquad);
    $tpagination = createPagination($tnopages,$pcurrpage);
  
//Generate our Squad Table
$tcontent = <<<PAGE
	{$tsquadtable}
	{$tpagination}
	<div id="ajax-fields" hidden>
	   <span id="ajax-page">$pcurrpage</span>
	   <span id="ajax-sm">$psortmode</span>
	   <span id="ajax-so">$psortorder</span>
	</div>	
PAGE;

return $tcontent;
}

$tcurrpage = $_REQUEST["page"] ?? 1;
$tcurrpage = is_numeric($tcurrpage) ? $tcurrpage: 1;
$tsortmode = $_REQUEST["sortmode"] ?? "squadno";
$tsortorder = $_REQUEST["sortorder"] ?? "asc";

if(isset($_REQUEST["ajax"]))
{
$tajaxresponse = createSquadElement($tcurrpage,$tsortmode,$tsortorder);
echo $tajaxresponse;
}

?>