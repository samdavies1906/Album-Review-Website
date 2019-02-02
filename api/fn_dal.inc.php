<?php
//Include the Other Layers Class Definitions
require_once("oo_bll.inc.php");
require_once("oo_pl.inc.php");

//---------XML HELPER FUNCTIONS--------------------------------------------------------
function xmlLoadAll($pxmlfile,$pclassname,$pelement)
{
    $txmldata = simplexml_load_file($pxmlfile,$pclassname);
    $tarray = [];
    foreach($txmldata->{$pelement} as $telement)
    {
        $tarray[] = $telement;
    }
    return $tarray;
}

function xmlLoadOne($pxmlfile,$pclassname)
{
    $txmldata = simplexml_load_file($pxmlfile,$pclassname);
    return $txmldata;
}

//---------JSON HELPER FUNCTIONS-------------------------------------------------------

function jsonOne($pfile,$pid)
{
    $tsplfile = new SplFileObject($pfile);
    $tsplfile->seek($pid-1);
    $tdata = json_decode($tsplfile->current());
    return $tdata;
}

function jsonAll($pfile)
{
    $tentries = file($pfile);
    $tarray = [];
    foreach($tentries as $tentry)
    {
        $tarray[] = json_decode($tentry);
    }
    return $tarray;
}

function jsonNextID($pfile)
{
    $tsplfile = new SplFileObject($pfile);
    $tsplfile->seek(PHP_INT_MAX);
    return $tsplfile->key() + 1;
}

//---------ID GENERATION FUNCTIONS-------------------------------------------------------

function jsonNextUserID()
{
    return jsonNextID("data/json/users.json");
}

//---------JSON-DRIVEN OBJECT CREATION FUNCTIONS-----------------------------------------

function jsonLoadOneUser($pid) : BLLUser
{
	$tuser = new BLLUser();
	$tuser->fromArray(jsonOne("data/json/users.json",$pid));
	return $tuser;
}

function jsonLoadAllUser() : array
{
	$tarray = jsonAll("data/json/users.json");
	return array_map(function($a){ $tc = new BLLUser(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadOneClub($pid) : BLLClub
{
    $tclub = new BLLClub();
    $tclub->fromArray(jsonOne("data/json/clubs.json",$pid));
    return $tclub;
}

function jsonLoadOnePlayer($pid) : BLLAlbum
{
    $tplayer = new BLLAlbum();
    $tplayer->fromArray(jsonOne("data/json/albums.json",$pid));
    return $tplayer;
}

function jsonLoadOneManager($pid): BLLManager
{
    $tmanager = new BLLManager();
    $tmanager->fromArray(jsonOne("data/json/managers.json",$pid));
    if(!empty($tmanager->bio_href))
    {
        $tmanager->bio = file_get_contents("data/html/{$tmanager->bio_href}");
    }
    if(!empty($tmanager->honours_href))
    {
        $thonourstr = file_get_contents("data/html/{$tmanager->honours_href}");
        $tmanager->honours = explode(",",$thonourstr);
    }
    return $tmanager;
}

function jsonLoadOneStadium($pid) : BLLStadium
{
    $tstadium = new BLLStadium();
    $tstadium->fromArray(jsonOne("data/json/stadiums.json",$pid));
    if(!empty($tstadium->desc_href))
    {
        $tstadium->desc = file_get_contents("data/html/{$tstadium->desc_href}");
    }
    return $tstadium;
}

function jsonLoadOneNewsItem($pid) : BLLNewsItem
{
    $tni = new BLLNewsItem();
    $tni->fromArray(jsonOne("data/json/newsitems.json",$pid));
    $tnidata = file_get_html("data/html/{$tni->item_href}");
    $tni->tagline = $tnidata->find("div.n-tag",0)->outertext;
    $tni->summary = $tnidata->find("div.n-summ",0)->outertext;
    $tni->content = $tnidata->find("div.n-main",0)->outertext;
    return $tni;
}

function jsonLoadOneCoaching($pid) : BLLCoaching
{
    $tcoach = new BLLCoaching();
    $tcoach->fromArray(jsonOne("data/json/coaches.json",$pid));
    return $tcoach;
}

function jsonLoadOneFixture($pid): BLLFixture
{
    $tfixture = new BLLFixture();
    $tfixture->fromArray(jsonOne("data/json/fixtures.json",$pid));
    return $tfixture;
}

function jsonLoadOneExecutive($pid): BLLExecutive
{
    $texec = new BLLExecutive();
    $texec->fromArray(jsonOne("data/json/executives.json",$pid));
    return $texec;
}

function jsonLoadAllClub() : array
{
    $tarray = jsonAll("data/json/clubs.json");
    return array_map(function($a){ $tc = new BLLClub(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllPlayer() : array
{
    $tarray = jsonAll("data/json/albums.json");
    return array_map(function($a){ $tc = new BLLAlbum(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllManager(): array
{
    $tarray = jsonAll("data/json/managers.json");
    return array_map(function($a){ $tc = new BLLManager(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllStadium() : array
{
    $tarray = jsonAll("data/json/stadiums.json");
    return array_map(function($a){ $tc = new BLLStadium(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllNewsItems() : array
{
	$tarray = jsonAll("data/json/newsitems.json");
    return array_map(function($a){ $tc = new BLLNewsItem();
                                  $tc->fromArray($a); 
                                  $tni = file_get_html("data/html/{$tc->item_href}");
                                  $tc->tagline = $tni->find("div.n-tag",0)->outertext;
                                  $tc->summary = $tni->find("div.n-summ",0)->outertext;
                                  return $tc; 
                                },$tarray);
    
   
    //return $tc;
}

function jsonLoadAllCoaching() : array
{
    $tarray = jsonAll("data/json/coaches.json");
    return array_map(function($a){ $tc = new BLLCoaching(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllFixture(): array
{
    $tarray = jsonAll("data/json/fixtures.json");
    return array_map(function($a){ $tc = new BLLFixture(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllExecutive(): array
{
    $tarray = jsonAll("data/json/executives.json");
    return array_map(function($a){ $tc = new BLLExecutive(); $tc->fromArray($a); return $tc; },$tarray);
}

?>