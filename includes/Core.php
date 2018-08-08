<?php
/**
 * ====================================================================================
 *                           Premium Poll Script (c) KBRmedia
 * ----------------------------------------------------------------------------------
 *  LICENSE: This software is exclusively sold at CodeCanyon.net. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in illegal activity. You must delete this software immediately or buy a proper
 *  license from http://codecanyon.net/user/KBRmedia/portfolio?ref=KBRmedia.
 *
 *  Thank you for your cooperation and don't hesitate to contact me if anything :)
 * ====================================================================================
 *
 * @package Premium Poll Script
 * @subpackage App Request Handler 
 * @author KBRmedia (http://gempixel.com)
 * @copyright 2014 KBRmedia
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since v1.1
 */
  if(!isset($_SESSION)) session_start();
	
	if($config["gzip"]){
	  ob_start("ob_gzhandler"); // Compress Page
	}
	// Starts a session
	if(!isset($_SESSION)){
	  session_start();
	}

	if(!isset($config["debug"]) || $config["debug"]==0) {
	  error_reporting(0);
	}else{
	  error_reporting(-1);
	}

	if(!isset($config["secret_key"]) || $config["secret_key"]=="RKEY"){
	  $config["secret_key"]="";
	}

	if(!empty($config["timezone"])){
		date_default_timezone_set($config["timezone"]);
	}
	// Defined Paths
	define("_VERSION","1.1");
	define("APP",1);
	define("ROOT",dirname(dirname(__FILE__)));

	// Connect to database
	include(ROOT."/includes/Database.class.php");	
	$db = new Database($config, $dbinfo);
	$config=$db->get_config();	
	$config["smtp"]=json_decode($config["smtp"],TRUE);
	
	
	// Template Path
	define("TEMPLATE",ROOT."/themes/{$config["theme"]}");
	
	// Application Helper
	include(ROOT."/includes/Main.class.php");
	Main::set("config",$config);

  	// Start Application		
	include(ROOT."/includes/App.class.php");
		$app = new App($db,$config);	
	
	// Default Language
	$_language=$config["lang"];
	// Set Language from Cookie
	if(isset($_COOKIE["lang"])) $_language=Main::clean($_COOKIE["lang"],3,TRUE);	
	// Set Language
	if(isset($_GET["lang"]) && strlen($_GET["lang"])=="2"){
		setcookie("lang",strip_tags($_GET["lang"]),strtotime('+30 days'),'/', NULL, 0);
		$_language=strip_tags($_GET["lang"]);
	}		
	// Get Language File
	if(isset($_language) && $_language!="en" && file_exists(ROOT."/includes/languages/".Main::clean($_language,3,TRUE).".php")) {
  	include(ROOT."/includes/languages/".Main::clean($_language).".php");
  	if(isset($lang) && is_array($lang)) {
  		Main::set("lang",$lang);
  		$app->lang=$_language;
  	}
	}
	// Read string function
	function e($text){
		return Main::e($text);
	}
?>
