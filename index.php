<?php 
/**
 * ====================================================================================
 *                           Easy Media Script (c) KBRmedia
 * ----------------------------------------------------------------------------------
 * @copyright This software is exclusively sold at CodeCanyon.net. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in an illegal activity. You must delete this software immediately or buy a proper
 *  license from http://codecanyon.net/user/KBRmedia/portfolio?ref=KBRmedia.
 *
 *  Thank you for your cooperation and don't hesitate to contact me if anything :)
 * ====================================================================================
 *
 * @author KBRmedia (http://gempixel.com)
 * @link http://gempixel.com 
 * @license http://gempixel.com/license
 * @package Easy Media Script
 * @subpackage App Request Handler
 */
	if(!file_exists("includes/Config.php")){
		header("Location: install.php");
		exit;
	}
	include("includes/Config.php");
	// Run the app
	$app->run();
?>