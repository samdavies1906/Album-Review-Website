<?php
require_once ("oo_bll.inc.php");
require_once ("oo_pl.inc.php");

//===========RENDER BUSINESS LOGIC OBJECTS=======================================================================

// ----------NEWS ITEM RENDERING------------------------------------------
function renderNewsItemAsList(BLLNewsItem $pitem)
{
    $titemsrc = !empty($pitem->thumb_href) ? $pitem->thumb_href : "blank-thumb.jpg";
    $tnewsitem = <<<NI
		    <section class="list-group-item clearfix">
		        <div class="media-left media-top">
                    <img src="img/news/{$titemsrc}" width="100" />
                </div>
                <div class="media-body">
				<h4 class="list-group-item-heading">{$pitem->heading}</h4>
				<p class="list-group-item-text">{$pitem->tagline}</p>
				<a class="btn btn-xs btn-default" href="news.php?storyid={$pitem->id}">Offical Review</a>
				</div>
			</section>
NI;
    return $tnewsitem;
}

function renderNewsItemAsSummary(BLLNewsItem $pitem)
{
    $titemsrc = !empty($pitem->thumb_href) ? $pitem->thumb_href : "blank-thumb.jpg";
    $tnewsitem = <<<NI
		    <section class="row details clearfix">
		    <div class="media-left media-top">
				<img src="img/news/{$titemsrc}" width="256" />
			</div>	
			<div class="media-body">
				<h2>{$pitem->heading}</h2>
				
				<div class="ni-summary">
				<p>{$pitem->summary}</p>
				<p>{$pitem->tagline}</p>
				</div>
				<a class="btn btn-xs btn-default" href="news.php?storyid={$pitem->id}">See the official review</a>
	        </div>
			</section>
NI;
    return $tnewsitem;
}

function renderNewsItemFull(BLLNewsItem $pitem)
{
    $titemsrc = !empty($pitem->img_href) ? $pitem->img_href : "blank-thumb.jpg";
    $tnewsitem = <<<NI
		    <section class="row details">
		        <div class="well">
		        <div class="media-left">
				    <img src="img/news/{$titemsrc}" />
				</div>	
				<div class="media-body">
				    <h1>{$pitem->heading}</h1>
				    <p id="news-tag">{$pitem->tagline}</p>
				    <p id="news-summ">{$pitem->summary}</p>
				    <p id="news-main">{$pitem->content}</p>
				</div>
				</div>
			</section>
NI;
    return $tnewsitem;
}

// ----------ALBUM RENDERING---------------------------------------
function renderPlayerTable(BLLSquad $psquad)
{
    $trowdata = "";
    foreach ($psquad->squadlist as $tp) {
        $tformat = $psquad->captainindex == $tp->Artist ? " class=\"success\"" : "";
        if (empty($tformat))
            $tformat = $psquad->starplayerindex == $tp->Artist ? " class=\"danger\"" : "";
            $trowdata .= <<<ROW
<tr{$tformat}>
   <td>{$tp->Artist}</td>
   <td>{$tp->Album}</td>
   <td>{$tp->Genre} </td>
   <td>{$tp->Releasedate}</td>
   <td>{$tp->Rating}</td>
   <td><a class="btn btn-info" href="album.php?id={$tp->id}">More...</a></td>
</tr>
ROW;
    }
    $ttable = <<<TABLE
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th id="sort-sqno">Artist</th>
			<th id="sort-pos">Album</th>
			<th id="sort-name">Genre</th>
			<th id="sort-name">Release Date</th>
			<th id="sort-nat">Rating</th>
			<th> </th>
		</tr>
	</thead>
	<tbody>
	{$trowdata}
	</tbody>
</table>
TABLE;
	return $ttable;
}

function renderPlayerOverview(BLLAlbum $pp) //include some sort of list of reviews under h3

{
	$tauth = "";
	
	$treview = file_get_contents("data/html/reviews-{$pp->Album}.html");
	
	if(isset($_SESSION["myemailaddress"]))
	{
		
		$timgref = "img/player/{$pp->Artist}.jpg";
		$timg = file_exists($timgref) ? $timgref : "img/player/blank.jpg";
		$toverview = <<<OV
    <article class="row marketing">
        <h2>Album Details</h2>
        <div class="col-xs-4">
            <img class="img-thumbnail" src="$timg" width="256" />
        </div>
         <div class="col-xs-6 text-center">
            <h1 class="text-center">Artist: {$pp->Artist}</h1>
             <h1>Album: {$pp->Album}</h1>
              <h2>Genre: {$pp->Genre}</h2>
              <h2>Release Date: {$pp->Releasedate}</h2>
              		 <h3>Rating: {$pp->Rating}</h3>
              		 		<h3><p><a href="http://localhost:8080/4122COMP/Coursework/news.php?storyid={$pp->id}">Look at the official reviews here</a></p></h3>
              		 				<h3><p><a href="http://localhost:8080/4122COMP/Coursework/review.php">Leave your own review here</a></p></h3>
              		 		 <div class="well col-xs-8">
              		 		   <h2>User reviews</h2>
              		 		   
              		 			{$treview}
              		 				
              		 		</div>
		
		
        </div>
    </article>
OV;

	}
	
		
	else {
		$timgref = "img/player/{$pp->Artist}.jpg";
		$timg = file_exists($timgref) ? $timgref : "img/player/blank.jpg";
		$toverview = <<<OV
    <article class="row marketing">
        <h2>Album Details</h2>
        <div class="col-xs-4">
            <img class="img-thumbnail" src="$timg" width="256" />
        </div>
         <div class="col-xs-6 text-center">
            <h1 class="text-center">Artist: {$pp->Artist}</h1>
             <h1>Album: {$pp->Album}</h1>
              <h2>Genre: {$pp->Genre}</h2>
              <h2>Release Date: {$pp->Releasedate}</h2>
              		 <h3>Rating: {$pp->Rating}</h3>
              		 		<h3><p><a href="http://localhost:8080/4122COMP/Coursework/news.php?storyid={$pp->id}">Look at the offical reviews here</a></p></h3>
              		 		<h3><p><a href="http://localhost:8080/4122COMP/Coursework/login.php">Log in to leave your own review</a></p></h3>
              		 		 <div class="well col-xs-8">
              		 		{$treview}
              		 		</div>
        </div>
    </article>
OV;
	}
	
	
	
	
    return $toverview;
}





function renderFixtureDetails(BLLFixture $pf, $ptitle, $pid = "club-results")
{
    $treport = !empty($pf->report) ? $pf->report : "Fixture report to follow";
    
    $tfixture = <<<HTML
        <section>
				<h2>
					<img width="24" src="img/clubs/fcb.png"><abbr title="FC Barcelona">Barcelona</abbr>
					<span class="info">{$pf->goalsfor}</span>
				</h2>
        		<h2>
					<img width="24"	src="img/clubs/{$pf->opp_abbr}.png"><abbr title="{$pf->opp_full}">{$pf->opp_abbr}</abbr>
					<span class="info">{$pf->goalsagainst}</span>
				</h2>
				<p><strong>Barcelona vs {$pf->opp_full}</strong></p>
				<p>{$pf->competition}</p>
				<p class="text-success>{$pf->date} {$pf->kickoff}</p>
				<p class="text-danger">{$pf->venue} (Att: {$pf->attendance})</p>
				<section class="well">
				{$treport}
				</section>
			</div>
		</section>
HTML;
    return $tfixture;
}

// ----------KIT RENDERING------------------------------------------------
function renderKitTable(array $pkitlist)
{
    $trowdata = "";
    foreach ($pkitlist as $tk) 
    {
        $tlink = "<a class=\"btn btn-info\" href=\"kit.php?kitid={$tk->id}\">More...</a>";
        $trowdata .= "<tr>
                          <td>{$tk->kittype}</td>
                          <td>{$tk->kityear}</td>
                          <td>{$tk->manufacturer}</td>
                          <td>{$tlink}</td>
                      </tr>";
    }
    $ttable = <<<TABLE
<table class="table table-striped table-hover">
	<thead>
		<tr>
	       	<th>Kit Desc</th>
			<th>Kit Year</th>
			<th>Kit Manufacturer</th>
			<th> </th>
		</tr>
	</thead>
	<tbody>
	   {$trowdata}
	</tbody>
</table>
TABLE;
    return $ttable;
}

function renderKitOverview(BLLKit $pkit)
{
    $tkithtml = <<<OV
    <h2>Kit Details</h2>
    <img src="img/kits/{$pkit->kitimage_href}" width="512"/>
    <h1>{$pkit->kittype} {$pkit->kityear}</h1>
    <h3>Sponsor: <strong>{$pkit->sponsor}</strong></h3>
    <h3>Manufacturer: <strong>{$pkit->manufacturer}</strong>
    <div class="col">
        <ul>
        <li>Shirt: <strong>{$pkit->shirtdesc}</strong></li>
        <li>Shorts:<strong>{$pkit->shortsdesc}</strong> </li>
        <li>Socks: <strong>{$pkit->socksdesc}</strong></li>
        </ul>
    </div>
OV;
    return $tkithtml;
}

// ----------STADIUM RENDERING--------------------------------------------
function renderStadiumSummary(BLLStadium $ps)
{
   $tshtml = <<<OVERVIEW
    <div class="well">
            <ul class="list-group">
                <li class="list-group-item">
                    Stadium Name: <strong>{$ps->name}</strong>
                </li>
                <li class="list-group-item">
                    Capacity: <strong>{$ps->capacity}</strong>
                </li>
                <li class="list-group-item">
                    Capacity: <strong>{$ps->capacity}</strong>
                </li>
                <li class="list-group-item">
                    Location: <strong>{$ps->addr}</strong>
                </li>
            </ul>
            <a class="btn btn-info" href="stadium.php?id={$ps->id}">Find out more...</a>
    </div>
OVERVIEW;
   return $tshtml;
}

function renderStadiumOverview(BLLStadium $ps)
{
    $tdesc = empty($ps->desc) ? "Details to Follow" : $ps->desc;
    $tci = [];
    $turl = "img/stadium/{$ps->imgdir}";
    //Get the Images
    foreach (new DirectoryIterator($turl) as $tfi) 
    {
        if($tfi->isDot())
            continue;
            $txml = <<<XML
<Image>
<img_href>{$tfi->getFilename()}</img_href>
<title> </title>
<lead> </lead>
</Image>
XML;
        $titem = new PLCarouselImage($txml);
        $tci[] = $titem;
    }
    $tcarousel = renderUICarousel($tci,$turl,"stad-carousel");
    $tmap = renderUIGoogleMap($ps->long,$ps->lat);
    
    $tshtml = <<<OVERVIEW
<div class="row">
  <h1>{$ps->name}</h1>
  <h3>Capacity: <strong>{$ps->capacity}</strong></h3>
  <h3>Location: <strong>{$ps->addr}</strong></h3>
  <h3>Stadium Overview</h3>
  {$tdesc}
</div>
<div class="row details">
  {$tcarousel}
</div>
<div class="row details">
<div id="stad-map">
{$tmap}
</div>
</div>
OVERVIEW;
    return $tshtml;
}

//=============RENDER PRESENTATION LOGIC OBJECTS==================================================================
function renderUICarousel(array $pimgs, $pimgdir,$pid = "mycarousel")
{
    $tci = "";
    $count = 0;
    
    // -------Build the Images---------------------------------------------------------
    foreach ($pimgs as $titem) {
        $tactive = $count === 0 ? " active" : "";
        $thtml = <<<ITEM
        <div class="item{$tactive}">
            <img class="img-responsive" src="{$pimgdir}/{$titem->img_href}">
            <div class="container">
                <div class="carousel-caption">
                    <h1>{$titem->title}</h1>
                    <p class="lead">{$titem->lead}</p>
		        </div>
			</div>
	    </div>
ITEM;
        $tci .= $thtml;
        $count ++;
    }
    
    // --Build Navigation-------------------------
    $tdot = "";
    $tdotset = "";
    $tarrows = "";
    
    if ($count > 1) {
        for ($i = 0; $i < count($pimgs); $i ++) {
            if ($i === 0)
                $tdot .= "<li data-target=\"#{$pid}\" data-slide-to=\"$i\" class=\"active\"></li>";
            else
                $tdot .= "<li data-target=\"#{$pid}\" data-slide-to=\"$i\"></li>";
        }
        $tdotset = <<<INDICATOR
        <ol class="carousel-indicators">
        {$tdot}
        </ol>
INDICATOR;
    }
    if ($count > 1) {
        $tarrows = <<<ARROWS
		<a class="left carousel-control" href="#{$pid}" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#{$pid}" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
ARROWS;
    }
    
    $tcarousel = <<<CAROUSEL
    <div class="carousel slide" id="{$pid}">
            {$tdotset}
			<div class="carousel-inner">
				{$tci}
			</div>
		    {$tarrows}
    </div>
CAROUSEL;
    return $tcarousel;
}

function renderUITabs(array $ptabs, $ptabid)
{
    $count = 0;
    $ttabnav = "";
    $ttabcontent = "";
    
    foreach ($ptabs as $ttab) {
        $tnavactive = "";
        $ttabactive = "";
        if ($count === 0) {
            $tnavactive = " class=\"active\"";
            $ttabactive = " active in";
        }
        $ttabnav .= "<li{$tnavactive}><a href=\"#{$ttab->tabid}\" data-toggle=\"tab\">{$ttab->tabname}</a></li>";
        $ttabcontent .= "<article class=\"tab-pane fade{$ttabactive}\" id=\"{$ttab->tabid}\">{$ttab->content}</article>";
        $count ++;
    }
    
    $ttabhtml = <<<HTML
        <ul class="nav nav-tabs">
        {$ttabnav}
        </ul>
    	<div class="tab-content" id="{$ptabid}">
			  {$ttabcontent}
		</div>
HTML;
    return $ttabhtml;
}

function renderUIQuote(PLQuote $pquote)
{
    $tquote = <<<QUOTE
    <blockquote>
    {$pquote->quote}
    <small>{$pquote->person} in <cite title="{$pquote->source}">{$pquote->pub}</cite></small>
	</blockquote>
QUOTE;
    return $tquote;
}

function renderUIHomeArticle(PLHomeArticle $phome, $pwidth = 6)
{
    $thome = <<<HOME
    <article class="col-lg-{$pwidth}">
		<h2>{$phome->heading}</h2>
		<h4>
			<span class="label label-success">{$phome->tagline}</span>
		</h4>
		<div class="home-thumb">
			<img src="img/{$phome->storyimg_href}" />
		</div>
		<div>
		  <strong>
			{$phome->summary}
		  </strong>
		</div>
        <div>
		    {$phome->content}
        </div>
        <div class="options details">
			<a class="btn btn-info" href="{$phome->link}">{$phome->linktitle}</a>
        </div>
	</article>
HOME;
    return $thome;
}



function renderUIStatistics(array $pstats)
{
    $tstats = "";
    foreach ($pstats as $tstat) {
        $tstats .= <<<STAT
        <li class="list-group-item">
            <span class="badge">{$tstat->value}</span>
            <strong>{$tstat->stat}: </strong>
            <a href="player.php?name={$tstat->ref}">{$tstat->holder}</a>
        </li>
STAT;
    }
    
    $tpanel = <<<PANEL
    <div class="well well-lg">
        <ul class="list-group">
            {$tstats}
        </ul>
    </div>

PANEL;
    return $tpanel;
}

function renderUIGoogleMap($plong, $plat)
{
    $tmaphtml = <<<MAP
    <iframe width="100%" height="100%"
                        frameborder="1" scrolling="no" marginheight="0"
                        marginwidth="0"
                        src="http://maps.google.com/maps?f=q&amp;
                        source=s_q&amp;hl=en&amp;
                        geocode=&amp;q={$plong},{$plat}
                        &amp;output=embed"></iframe>
MAP;
    return $tmaphtml;
}

?>