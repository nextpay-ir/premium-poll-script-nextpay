<?php
/**
 * ====================================================================================
 *                           Premium Poll Script (c) KBRmedia
 * ----------------------------------------------------------------------------------
 *  @copyright - This software is exclusively sold at CodeCanyon.net. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in illegal activity. You must delete this software immediately or buy a proper
 *  license from http://codecanyon.net/user/KBRmedia/portfolio?ref=KBRmedia.
 *
 *	@license http://gempixel.com/license
 *
 *  Thank you for your cooperation and don't hesitate to contact me if anything :)
 * ====================================================================================
 *
 * @author KBRmedia (http://gempixel.com)
 * @link http://gempixel.com
 * @package Premium Poll Script
 * @subpackage Dispatch Admin
 */
	require_once("../includes/Config.php");	

	// Set up some admin variables
	include (ROOT."/includes/Admin.class.php");	
	$admin = new Admin($config,$db);
	$admin->run();	
?>