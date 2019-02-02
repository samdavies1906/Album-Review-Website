<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    //Page-Specific Static Content
	$twelcome = file_get_contents("data/static/index_welcome.part.html");
    
    //Content Classes via XML and JSON
    $tarticles = xmlLoadAll("data/xml/articles-index.xml","PLHomeArticle","Article");
    $tnilist = jsonLoadAllNewsItems();

    //Create the News Items for Article 2.
    $tnews = "";
    $tcount = 0;
    foreach($tnilist as $tni)
    {
    	if($tcount > 4)
    		break;
    		
        $tnews.=renderNewsItemAsList($tni);
        $tcount++;
    }   
    
    $tarticles[1]->content = $tnews;
        
    //Build the Articles
    $tarticlehtml = "";
    foreach($tarticles as $ta)
    {
    	if(!empty($ta->article_href))
    	{
    		$tarthtml = file_get_html("data/html/{$ta->article_href}");
    		$ta->summary = $tarthtml->find("div.art-summary",0)->outertext;
    		$ta->content = $tarthtml->find("div.art-content",0)->outertext;
    	}
        $tarticlehtml .= renderUIHomeArticle($ta);
    }
$tcontent = <<<PAGE
       <div class="row">
            {$twelcome}
		</div>
        <div class="row details">
            {$tarticlehtml}
		</div>
		 
PAGE;
return $tcontent;
}

//----BUSINESS LOGIC---------------------------------
//Start up a PHP Session for this user.
session_start();

//Build up our Dynamic Content Items. 
$tpagetitle = "Home Page";
$tpagelead  = "";
$tpagecontent = createPage();
$tpagefooter = "";

//----BUILD OUR HTML PAGE----------------------------
//Create an instance of our Page class
$tpage = new MasterPage($tpagetitle);
//Set the Three Dynamic Areas (1 and 3 have defaults)
if(!empty($tpagelead))
    $tpage->setDynamic1($tpagelead);
$tpage->setDynamic2($tpagecontent);
if(!empty($tpagefooter))
    $tpage->setDynamic3($tpagefooter);
//Return the Dynamic Page to the user.    
$tpage->renderPage();
?>