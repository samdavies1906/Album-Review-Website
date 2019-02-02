 <?php

//Include our HTML Page Class
require_once("oo_page.inc.php");

class MasterPage
{
    //-------FIELD MEMBERS----------------------------------------
    private $_htmlpage;     //Holds our Custom Instance of an HTML Page
    private $_dynamic_1;    //Field Representing our Dynamic Content #1
    private $_dynamic_2;    //Field Representing our Dynamic Content #2
    private $_dynamic_3;    //Field Representing our Dynamic Content #3
    private $_player_ids;
    
    //-------CONSTRUCTORS-----------------------------------------
    function __construct($ptitle)
    {
        $this->_htmlpage = new HTMLPage($ptitle);
        $this->setPageDefaults();
        $this->setDynamicDefaults(); 
        $this->_player_ids = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
    }
    
    //-------GETTER/SETTER FUNCTIONS------------------------------
    public function getDynamic1() { return $this->_dynamic_1; }
    public function getDynamic2() { return $this->_dynamic_2; } 
    public function getDynamic3() { return $this->_dynamic_3; }
    public function setDynamic1($phtml) { $this->_dynamic_1 = $phtml; }
    public function setDynamic2($phtml) { $this->_dynamic_2 = $phtml; } 
    public function setDynamic3($phtml) { $this->_dynamic_3 = $phtml; }
    public function getPage(): HTMLPage { return $this->_htmlpage; } 
    
    //-------PUBLIC FUNCTIONS-------------------------------------
                   
    public function createPage()
    {
       //Create our Dynamic Injected Master Page
       $this->setMasterContent();
       //Return the HTML Page..
       return $this->_htmlpage->createPage();
    }
    
    public function renderPage()
    {
       //Create our Dynamic Injected Master Page
       $this->setMasterContent();
       //Echo the page immediately.
       $this->_htmlpage->renderPage();
    }
    
    public function addCSSFile($pcssfile)
    {
        $this->_htmlpage->addCSSFile($pcssfile);
    }
    
    public function addScriptFile($pjsfile)
    {
        $this->_htmlpage->addScriptFile($pjsfile);
    }
    
    //-------PRIVATE FUNCTIONS-----------------------------------    
    private function setPageDefaults()
    {
        $this->_htmlpage->setMediaDirectory("css","js","fonts","img","data");
        $this->addCSSFile("bootstrap.cosmo.css");
        $this->addCSSFile("site.css");
        $this->addScriptFile("jquery-2.2.4.js");
        $this->addScriptFile("bootstrap.js");
        $this->addScriptFile("holder.js");        
    }
    
    private function setDynamicDefaults()
    {
        $tcurryear = date("Y");
        //Set the Three Dynamic Points to Empty By Default.
        $this->_dynamic_1 = <<<JUMBO
<h1>Review Your Favourite Music</h1>
JUMBO;
        $this->_dynamic_2 = "";
        $this->_dynamic_3 = <<<FOOTER
<p>Sam Davies - LJMU &copy; {$tcurryear}</p>
FOOTER;
    }
    
    private function setMasterContent()
    {
        $tentryhtml = <<<FORM
        <fieldset>
        
        		 <a class="btn btn-info navbar-right" href="dataentry.php">Register</a>
        		 <a class="btn btn-info navbar-right" href="login.php">Login</a>
       </fieldset>
        		</form>
FORM;
        $email = (isset($_SESSION['myemailaddress']) ? $_SESSION['myemailaddress'] : null);
        $texithtml = <<<EXIT
        <a class="btn btn-info navbar-right" href="app_exit.php?action=exit">Exit $email</a>
EXIT;
        
       
        
        $tauth = "";
      
        if(isset($_SESSION["myemailaddress"])) 
        {
            $tauth = $texithtml; 
            
        }
        else
        {
            $tauth = $tentryhtml;
        }
        $tid = $this->_player_ids[array_rand($this->_player_ids,1)];        
        $tmasterpage = <<<MASTER
<div class="container">
	<div class="header clearfix">
	<nav>		  
		  <ul class="nav nav-pills pull-left">
		  <h3 class="text-muted"><a href="index.php">Album Reviews   <a href="index.php"><img src="img/icons/cd_Icon.png"></a></a></h3>
		  </ul>
		 
			<ul class="nav nav-pills pull-right">
			
				<li role="presentation"><a href="albums.php">Albums</a></li>
				<li role="presentation"><a href="album.php?id={$tid}">Random Album</a></li>
				 {$tauth}
			</ul>
			 
		</nav>
	</div>
	<div class="jumbotron">
		{$this->_dynamic_1}
    </div>
	<div class="row details">
		{$this->_dynamic_2}
    </div>
    <footer class="footer">
		{$this->_dynamic_3}
	</footer>
</div>        
MASTER;
        $this->_htmlpage->setBodyContent($tmasterpage); 
    }
}

?>