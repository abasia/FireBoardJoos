<?php
/**
* @version 2.0
* @package FireboardRE
* @copyright (C) 2008 Adeptus
*/
	header("Cache-Control: no-cache");
	header("Pragma: nocache");
	header("Content-Type: text/html; charset=\"windows-1251\"");
	define( '_VALID_MOS', 1 );
	Error_Reporting(E_ERROR);
	require( '../../../../../globals.php' );
	require_once( '../../../../../configuration.php' );
	require_once( '../../../../../includes/joomla.php' );
	require_once( '../../../../../includes/database.php' );
	global $mosConfig_live_site,$database,$mosConfig_absolute_path,$mosConfig_lang,$mosConfig_dbprefix;
	$thread = intval(mosGetParam($_POST, 'thread'));
	if ($thread)
	{
		$database->setQuery("DELETE FROM ".$mosConfig_dbprefix."fb_polls WHERE threadid=$thread");
		$database->query();
		$database->setQuery("DELETE FROM ".$mosConfig_dbprefix."fb_pollsresults WHERE threadid=$thread");
		$database->query();
		$database->setQuery("DELETE FROM ".$mosConfig_dbprefix."fb_pollsotvet WHERE poll_id=$thread");
		$database->query();
		$database->setQuery("SELECT MIN(id) FROM ".$mosConfig_dbprefix."fb_messages WHERE thread=$thread");
		$msg_id = $database->loadResult();
		$database->setQuery("SELECT message FROM ".$mosConfig_dbprefix."fb_messages_text WHERE mesid=$msg_id");
		$msg = $database->loadResult();
		$msg = '[Голосование удалено '.date('d.m.Y').']\n'.$msg;
		$database->setQuery("UPDATE ".$mosConfig_dbprefix."fb_messages_text SET message='".$msg."' WHERE mesid=$msg_id");
		$database->query();
	}
	//print_r($_POST);
