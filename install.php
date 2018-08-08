<?php 
/**
 * ====================================================================================
 *                           PREMIUM URL SHORTENER (c) KBRmedia
 * ----------------------------------------------------------------------------------
 * @copyright This software is exclusively sold at CodeCanyon.net. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in an illegal activity. You must delete this software immediately or buy a proper
 *  license from http://gempixel.com/buy/short.
 *
 *  Thank you for your cooperation and don't hesitate to contact me if anything :)
 * ====================================================================================
 *
 * @author KBRmedia (http://gempixel.com)
 * @link http://gempixel.com 
 * @package Premium Poll Script
 * @subpackage Application installer
 */
	if(!isset($_SESSION)) session_start();
	$error="";
	$message=(isset($_SESSION["msg"])?$_SESSION["msg"]:"");
	unset($_SESSION["msg"]);
	if(!isset($_GET["step"]) || $_GET["step"]=="1"){
		$step="1";
	}elseif($_GET["step"] >"1" && $_GET["step"]<="5"){
		$step=$_GET["step"];
	}else{
		die();
	}
	switch ($step) {
		case '2':
			if(file_exists("includes/Config.php")) $error='Configuration file already exists. Please delete or rename "Config.php" and recopy "Config-sample.php" from the original zip file. You cannot continue until you do this.';  

			if(isset($_POST["step2"])){
			if (empty($_POST["host"]))  $error.="<p>- You forgot to enter your host.</p>"; 
            if (empty($_POST["name"])) $error.="<p>- You forgot to enter your database name.</p>"; 
            if (empty($_POST["user"])) $error.="<p>- You forgot to enter your username.</p>"; 
	            if(empty($error)){
					 try{
					    $db = new PDO("mysql:host=".$_POST["host"].";dbname=".$_POST["name"]."", $_POST["user"], $_POST["pass"]);
								generate_config($_POST);
		            $query=get_query();
						foreach ($query as $q) {
						  $db->query($q);
						} 
						$_SESSION["msg"]="Database has been successfully imported and configuration file has been created.";
						header("Location: install.php?step=3");
					  }catch (PDOException $e){
					    $error = $e->getMessage();
					  }
	            }							
			}
		break;
		case '3':
				require_once("includes/Config.php");
					$_SESSION["msg"]="";
			    if(isset($_POST["step3"])){
			      if (empty($_POST["email"]))  $error.="<div class='error'>You forgot to enter your email.</div>"; 
			      if (empty($_POST["pass"])) $error.="<div class='error'>You forgot to enter your password.</div>"; 
			      if (empty($_POST["url"])) $error.="<div class='error'>You forgot to enter the url.</div>"; 
			    	if(!$error){
			    	$data=array(
				    	":admin"=>"1",
				    	":email"=>$_POST["email"],
				    	":password"=>Main::encode($config["secret_key"].$_POST["pass"]),
				    	":date"=>"NOW()",
				    	":membership"=>"pro",
				    	":unique_key"=>Main::strrand(20),
				    	":auth_key"=>Main::encode($config["security"].Main::strrand()),
				    	":expires" => date("Y-m-d H:i:s",strtotime("+100 years"))
			    	);

					  $db->insert("user",$data);

					  $db->update("setting",array("var"=>"?"),array("config"=>"?"),array(rtrim($_POST["url"],"/"),"url"));

					  $_SESSION["msg"]="Your admin account has been successfully created.";
					  $_SESSION["site"]=$_POST["url"];
					  $_SESSION["username"]=$_POST["username"];
					  $_SESSION["email"]=$_POST["email"];
					  $_SESSION["password"]=$_POST["pass"];
					  header("Location: install.php?step=4"); 
			        }   
			    }		
		break;
		case '4':
			$_SESSION["msg"]="";
			include("includes/Config.php");
		break;
		case '5':
			header("Location: index.php"); 
			unset($_SESSION);
			unlink(__FILE__);
			if(file_exists("main.zip")){
				unlink('main.zip');
			}
			if(file_exists("updater.php")){
				unlink('updater.php');
			}
		break;
	}
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Premium Poll Script Installation</title>
	<style type="text/css">
	body{background:#f9f9f9;font-family:Helvetica, Arial;width:860px;line-height:25px;font-size:13px;margin:0 auto;}a{color:#009ee4;font-weight:700;text-decoration:none;}a:hover{color:#000;text-decoration:none;}.container{background:#fff;border:1px solid #eee;box-shadow:0 0 0 3px #f7f7f7;border-radius:3px;display:block;overflow:hidden;margin:50px 0;}.container h1{font-size:22px;display:block;border-bottom:1px solid #eee;margin:0!important;padding:10px;}.container h2{color:#999;font-size:18px;margin:10px;}.container h3{background:#f8f8f8;border-bottom:1px solid #eee;border-radius:3px 0 0 0;text-align:center;margin:0;padding:10px 0;}.left{float:left;width:258px;}.right{float:left;width:599px;border-left:1px solid #eee;}.form{width:90%;display:block;padding:10px;}.form label{font-size:15px;font-weight:700;margin:5px 0;}.form label a{float:right;color:#009ee4;font:bold 12px arial;}.form .input{display:block;width:98%;height:15px;border:1px #ccc solid;font:bold 15px arial;color:#aaa;border-radius:2px;box-shadow:inset 1px 1px 3px #ccc,0 0 0 3px #f8f8f8;margin:10px 0;padding:10px;}.form .input:focus{border:1px #73B9D9 solid;outline:none;color:#222;box-shadow:inset 1px 1px 3px #ccc,0 0 0 3px #DEF1FA;}.form .button{height:35px;}.button{background:#1ABC9C;height:20px;width:90%;display:block;text-decoration:none;text-align:center;border-radius: 2px;color:#fff;font:15px arial bold;cursor:pointer;border-radius:3px;margin:30px auto;padding:5px 0;border:0;width: 98%;}.button:active,.button:hover{background:#1DD3AF;color:#fff;}.content{color:#999;display:block;border-top:1px solid #eee;margin:10px 0;padding:10px;}li{color:#999;}li.current{color:#000;font-weight:700;}li span{float:right;margin-right:10px;font-size:11px;font-weight:700;color:#00B300;}.left > p{border-top:1px solid #eee;color:#999;font-size:12px;margin:0;padding:10px;}.left > p >a{color:#777;}.content > p{color:#222;font-weight:700;}span.ok{float:right;border-radius:3px;background:#00B300;color:#fff;padding:2px 10px;}span.fail{float:right;border-radius:3px;background:#B30000;color:#fff;padding:2px 10px;}span.warning{float:right;border-radius:3px;background:#D27900;color:#fff;padding:2px 10px;}.message{background:#0D5C80;color:#fff;font:bold 15px arial;border:1px solid #000;box-shadow:0 0 0 1px #222;padding:10px;}.error{background:#980E0E;color:#fff;font:bold 15px arial;border-bottom:1px solid #740C0C;border-top:1px solid #740C0C;margin:0;padding:10px;}.inner,.right > p{margin:10px;}	
	</style>
  </head>
  <body>
  	<div class="container">
  		<div class="left">
			<h3>Installation Process</h3>
			<ol>
				<li<?php echo ($step=="1")?" class='current'":""?>>Requirement Check <?php echo ($step>"1")?"<span>Complete</span>":"" ?></li>
				<li<?php echo ($step=="2")?" class='current'":""?>>Database Configuration<?php echo ($step>"2")?"<span>Complete</span>":"" ?></li>
				<li<?php echo ($step=="3")?" class='current'":""?>>Basic Configuration<?php echo ($step>"3")?"<span>Complete</span>":"" ?></li>
				<li<?php echo ($step=="4")?" class='current'":""?>>Installation Complete</li>
			</ol>
			<p>
				<a href="http://gempixel.com/" target="_blank">Home</a> | 
				<a href="http://support.gempixel.com/" target="_blank">Support</a> | 
				<a href="http://gempixel.com/profile" target="_blank">Profile</a> <br />
				2012-<?php echo date("Y") ?> &copy; <a href="http://gempixel.com" target="_blank">KBRmedia</a> - All Rights Reserved
			</p>
  		</div>
  		<div class="right">
			<h1>Installation of Premium Poll Script</h1> 
			<?php if(!empty($message)) echo "<div class='message'>$message</div>"; ?>
			<?php if(!empty($error)) echo "<div class='error'>$error</div>"; ?>
			<?php if($step=="1"): ?>		
				<h2>1.0 Requirement Check</h2>
				<p>
					These are some of the important requirements of this software. "Red" means it is vital to this script, "Orange" means it is required but not vital and "Green" means it is good. If one of the checks is "Red", you will not be able to install this script because without that module/extension, the script will not work.
				</p>
				<div class="content">
					<p>
					PHP Version (need at least version 5.3)
					<?php echo check('version')?>
					</p>
					It is very important to have at least PHP Version 5.3.
				</div>
				<div class="content">
					<p>PDO Driver must be enabled 
						<?php echo check('pdo')?>
					</p>
					PDO driver is very important thus it must enabled. Without this, the script will not connect to the database hence it will not work at all. If this check fails, you will need to contact your web host and ask them to either enable it or configure it properly.
				</div>					
				<div class="content">
					<p>"Config-sample.php" must be accessible. 
						<?php echo check('config')?>
					</p>
					This installation will open that file to put values in so it must be accessible. Make sure that file is there in the <b>includes</b> folder and is writable.
				</div>										
			<?php if(!$error) echo '<a href="?step=2" class="button">Everthing Seems OK, You can now Proceed.</a>'?>
		<?php elseif($step=="2"): ?>	
		<h2>2.0 Database Configuration</h2>
		<p>
			Now you have to set up your database by filling the following fields. Make sure you fill them correctly.
		</p>
		<form method="post" action="?step=2" class="form">
		    <label>Database Host <a>Usually it is localhost, make sure to get the correct one.</a></label>
		    <input type="text" name="host" class="input" required />
		    
		    <label>Database Name</label>
		    <input type="text" name="name" class="input" required />
		    
		    <label>Database User </label>
		    <input type="text" name="user" class="input" required />    
		    
		    <label>Database Password</label>
		    <input type="password" name="pass" class="input" />   

		    <label>Table Prefix <a>Prefix for your tables to prevent conflicts e.g. poll_</a></label>
		    <input type="text" name="prefix" class="input" value="" />       

		    <label>Security Key (Longer, the better)<a>Used to encode some important information</a></label>
		    <input type="text" name="key" class="input" value="" />   

		    <label>Timezone</label><br />
		    <select name="tz">    
					<?php
						$timezone_identifiers = DateTimeZone::listIdentifiers();
						foreach($timezone_identifiers as $tz){
						    echo "<option value='$tz'>$tz</option>";
						}
					?>		    
				</select>
		    <button type="submit" name="step2" class='button'>Create my configuration file and go to step 3</button>    
		</form>
		<?php elseif($step=="3"): ?>
		<p>
			Now you have to create an admin account by filling the fields below. Make sure to add a valid email and a strong password. For the site URL, make sure to remove the last slash.
		</p>
		  <form method="post" action="?step=3" class="form">
		        <label>Admin Email</label>
		        <input type="text" name="email" class="input" required />

		        <label>Admin Password</label>
		        <input type="password" name="pass" class="input" required />   

		        <label>Site URL With http:// but without the ending slash "/"</label>
		        <input type="text" name="url" class="input" value="<?php echo get_domain() ?>" placeholder="http://" required />  

		        <input type="submit" name="step3" value="Finish Up Installation" class='button' />     
		  </form>		
		<?php elseif($step=="4"): ?>
	       <p>
 				The script has been successfully installed and your admin account has been created. Please click "Delete Install" button below to attempt to delete this file. Please make sure that it has been successfully deleted. 
	       </p>
	       <p>
	       	  Once clicked, you may see a blank page otherwise you will be redirected to your main page. If you see a blank, don't worry it is normal. All you have to do is to go to your main site, login using the info below and configure your site by clicking the "Admin" menu and then "Settings". Thanks for your purchase and enjoy :)
	       </p>
	       <p>
	       <strong>Login URL: <a href="<?php get('site') ?>/user/login" target="_blank"><?php get('site') ?>/user/login</a></strong> <br />
	       <strong>Email: <?php get('email') ?></strong> <br />
	       <strong>Password: <?php get('password') ?></strong>
	       </p>	       
	       <a href="?step=5" class="button">Delete install.php</a>	       
		<?php endif; ?>
  		</div>  		
  	</div>
  </body>
</html>
<?php 
function get_domain(){
	$url="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$url=str_replace("/install.php?step=3", "", $url);
	return $url;
}
function get($what){
	if(isset($_SESSION[strip_tags(trim($what))])){
		echo $_SESSION[strip_tags(trim($what))];
	}
}
function check($what){
	switch ($what) {
		case 'version':
			if(PHP_VERSION>="5.3"){
				return "<span class='ok'>You have ".PHP_VERSION."</span>";
			}else{
				global $error;
				$error.=1;
				return "<span class='fail'>You have ".PHP_VERSION."</span>";
			}
			break;
		case 'config':
			if(@file_get_contents('includes/Config-sample.php') && is_writable('includes/Config-sample.php')){
				return "<span class='ok'>Accessible</span>";
			}else{
				global $error;
				$error.=1;
				return "<span class='fail'>Not Accessible</span>";
			}
			break;
		case 'pdo':
			if(defined('PDO::ATTR_DRIVER_NAME') && class_exists("PDO")){
				return "<span class='ok'>Enabled</span>";
			}else{
				global $error;
				$error.=1;
				return "<span class='fail'>Disabled</span>";
			}
			break;
		case 'file':
			if(ini_get('allow_url_fopen')){
				return "<span class='ok'>Enabled</span>";
			}else{
				return "<span class='warning'>Disabled</span>";
			}
			break;	
		case 'curl':
			if(in_array('curl', get_loaded_extensions())){
				return "<span class='ok'>Enabled</span>";
			}else{
				return "<span class='warning'>Disabled</span>";
			}
			break;						
	}
}
function get_query(){
$query[]="CREATE TABLE IF NOT EXISTS `".trim($_POST["prefix"])."page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `menu` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$query[]="CREATE TABLE IF NOT EXISTS `".trim($_POST["prefix"])."payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` varchar(255) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `method` varchar(255) NOT NULL DEFAULT 'paypal',
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `expires` datetime NOT NULL,
  `date` datetime NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$query[]="CREATE TABLE IF NOT EXISTS `".trim($_POST["prefix"])."poll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(9) NOT NULL DEFAULT '0',
  `open` int(1) NOT NULL DEFAULT '1',
  `question` text NOT NULL,
  `options` text NOT NULL,
  `results` int(1) NOT NULL DEFAULT '1',
  `choice` int(1) NOT NULL DEFAULT '0',
  `share` int(1) NOT NULL DEFAULT '1',
  `pass` varchar(255) NOT NULL,
  `theme` varchar(255) NOT NULL,
  `custom` text NOT NULL,
  `count` enum('day','month','off') DEFAULT 'off',
  `created` datetime NOT NULL,
  `expires` varchar(255) NOT NULL,
  `uniqueid` varchar(8) NOT NULL,
  `votes` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$query[]="CREATE TABLE IF NOT EXISTS `".trim($_POST["prefix"])."setting` (
  `config` varchar(255) NOT NULL,
  `var` text NULL,
  UNIQUE KEY `config` (`config`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$query[]="INSERT INTO `".trim($_POST["prefix"])."setting` (`config`, `var`) VALUES
			('url', ''),
			('title', ''),
			('description', ''),
			('captcha', '0'),
			('captcha_public', ''),
			('captcha_private', ''),
			('nextpay_apikey', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'),
			('pro_monthly', ''),
			('pro_yearly', ''),
			('currency', 'USD'),
			('max_count', '25'),			
			('users', '1'),
			('user_activation', '1'),
			('smtp', ''),
			('export', '1'),
			('logo', ''),
			('email', ''),
			('ads', '0'),
			('ad728', ''),
			('ad468', ''),
			('ad300', ''),
			('theme', 'default'),
			('style', ''),
			('lang', ''),
			('fonts', '');";

$query[]="CREATE TABLE IF NOT EXISTS `".trim($_POST["prefix"])."user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `banned` int(1) NOT NULL DEFAULT '0',
  `membership` enum('free','pro') NOT NULL DEFAULT 'free',
  `date` datetime NOT NULL,
  `last_payment` datetime NOT NULL,
  `expires` datetime NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `ga` varchar(50) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `unique_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$query[]="CREATE TABLE IF NOT EXISTS `".trim($_POST["prefix"])."vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` mediumint(9) NOT NULL,
  `polluserid` mediumint(9) NOT NULL DEFAULT '0',
  `vote` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `source` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

return $query;
}
function generate_config($array){
	if(!empty($array)){
	    $file=file_get_contents('includes/Config-sample.php');
	    $file=str_replace("RHOST",trim($array["host"]),$file);
	    $file=str_replace("RDB",trim($array["name"]),$file);
	    $file=str_replace("RUSER",trim($array["user"]),$file);
	    $file=str_replace("RPASS",trim($array["pass"]),$file);                
	    $file=str_replace("RPRE",trim($array["prefix"]),$file);  
	    $file=str_replace("RTZ",trim($array["tz"]),$file);  
	    $file=str_replace("RPUB",trim(md5(api())),$file);
	    $file=str_replace("RKEY",trim($array["key"]),$file);
	    $fh = fopen('includes/Config-sample.php', 'w') or die("Can't open Config-sample.php. Make sure it is writable.");
	    fwrite($fh, $file);
	    fclose($fh); 
	    rename("includes/Config-sample.php", "includes/Config.php");
	}
}
function api(){
          $l='12';
          $api="";
          $r= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
            srand((double)microtime()*1000000); 
            for($i=0; $i<$l; $i++) { 
              $api.= $r[rand()%strlen($r)]; 
            } 
          return $api;    
      }
?>
