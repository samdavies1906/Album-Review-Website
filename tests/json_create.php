<?php 

require_once("../api/api.inc.php");

function jsonCreatePlayerFormat($pfile)
{
    $tnewplayer = new BLLAlbum();
    $tnewplayer->id = 1;
    $tnewplayer->firstname = "Paco";
    $tnewplayer->lastname = "Alcacer";
    $tnewplayer->nationality = "Spanish";
    $tnewplayer->position = "FW";
    $tdata = json_encode($tnewplayer).PHP_EOL;
    file_put_contents($pfile,$tdata);
}

function jsonCreateStadiumFormat($pfile)
{
    $tstadium = new BLLStadium();
    $tstadium->id = 1;
    $tstadium->name = "Camp Nou";
    $tstadium->capacity = 99354;
    $tstadium->desc = "";
    $tstadium->desc_href = "stad-nc.part.html";
    $tstadium->addr = "Calle de Aristides Maillol 12, Barcelona";
    $tstadium->long = 41.3809;
    $tstadium->lat  = 2.1228;
    $tstadium->imgdir = "nc";
    $tdata = json_encode($tstadium).PHP_EOL;
    file_put_contents($pfile,$tdata);
}

function jsonCreateManagerFormat($pfile)
{
    $tmanager = new BLLManager();
    $tmanager->id = 1;
    $tmanager->fname = "Luis"; 
    $tmanager->lname = "Enrique";
    $tmanager->age = 46;
    $tmanager->nationality = "Spanish";
    $tmanager->bio = "";
    $tmanager->bio_href = "man-le-bio.part.html";
    $tmanager->games_managed = 168;
    $tmanager->games_won     = 128;
    $tmanager->games_drawn   = 21;
    $tmanager->games_lost    = 19;
    $tmanager->honours = "";
    $tmanager->honours_href = "man-le-hon.part.html";
    $tdata = json_encode($tmanager).PHP_EOL;
    file_put_contents($pfile,$tdata);
}

function jsonCreateExecutivesFormat($pfile)
{
    $texec = new BLLExecutive();
    $texec->id = "1";
    $texec->name = "";
    $texec->role = "";
    $tdata = json_encode($texec).PHP_EOL;
    file_put_contents($pfile,$tdata);
}

function jsonCreateKitsFormat($pfile)
{
    $tkit = new BLLKit();
    $tkit->id = 1;
    $tkit->kittype = "1st Team";
    $tkit->kityear = "2016/17";
    $tkit->manufacturer = "Nike";
    $tkit->shirtdesc = "Dark Blue/ Dark Red Stripes";
    $tkit->shortsdesc = "Dark Blue/Red Trim";
    $tkit->socksdesc = "Dark Red";
    $tkit->sponsor = "Emirates";
    $tdata = json_encode($tkit).PHP_EOL;
    file_put_contents($pfile,$tdata);
}

function jsonCreateFixturesFormat($pfile)
{
    $tf = new BLLFixture();
    $tf->id = 1;
    $tf->competition = "Champions League";
    $tf->attendance = 40000;
    $tf->date = "Wednesday 14th February 2017";
    $tf->goalsagainst = 4;
    $tf->goalsfor = 0;
    $tf->ishome = false;
    $tf->kickoff = "7:45PM";
    $tf->opp_full = "Paris Saint Germain";
    $tf->opp_abbr = "PSG";
    $tf->report = "";
    $tf->report_href = "fcb-psg1.part.html";
    $tdata = json_encode($tf).PHP_EOL;
    file_put_contents($pfile,$tdata);
}

function jsonCreateCoachesFormat($pfile)
{
    $tcoach = new BLLCoaching();
    $tcoach->id = 1;
    $tcoach->fname = "Andy";
    $tcoach->lname = "Smith";
    $tcoach->role = "First Team Coach";
    $tcoach->bio_href = "";
    $tdata = json_encode($tcoach).PHP_EOL;
    file_put_contents($pfile,$tdata);
}

function jsonCreateClubsFormat($pfile)
{
    $tclub = new BLLClub();
    $tclub->id = 1;
    $tclub->country = "Spain";
    $tclub->founded = 1900;
    $tclub->fullname = "FC Barcelona";
    $tclub->shortname = "FCB";
    $tclub->nickname = "Blaugrana";
    $tclub->majorhonours = "";
    $tclub->league = "La Liga";
    $tdata = json_encode($tclub).PHP_EOL;
    file_put_contents($pfile,$tdata);
}

function jsonCreateNewsItemsFormat($pfile)
{
    $tni = new BLLNewsItem();
    $tni->id = 1;
    $tni->heading = "Article 1";
    $tni->img_href = "news-main01.jpg";
    $tni->thumb_href = "news-main01.jpg";
    $tni->item_href = "newsitem1.part.html";
    $tni->content = "";
    $tni->tagline = "";
    $tni->summary = "";
    $tdata = json_encode($tni).PHP_EOL;
    file_put_contents($pfile,$tdata);
}

//---------Create JSON Files---------------------------------------------
//jsonCreateManagerFormat("../data/json/managers1.json");
//jsonCreatePlayerFormat("../data/json/players1.json");
//jsonCreateStadiumFormat("../data/json/stadiums1.json");
//jsonCreateExecutivesFormat("../data/json/executives1.json");
//jsonCreateKitsFormat("../data/json/kits1.json");
//jsonCreateFixturesFormat("../data/json/fixtures1.json");
//jsonCreateCoachesFormat("../data/json/coaches1.json");
//jsonCreateClubsFormat("../data/json/clubs1.json");
//jsonCreateNewsItemsFormat("../data/json/newsitems1.json");

?>