<?php
/**
 * @version 2.0
 * @package FireboardRE
 * @copyright (C) 2008 Adeptus
 */
header("Cache-Control: no-cache");
header("Pragma: nocache");
header("Content-Type: text/html; charset=\"windows-1251\"");
define('_VALID_MOS', 1);
Error_Reporting(E_ERROR);
require('../../../../../globals.php');
require_once('../../../../../configuration.php');
require_once('../../../../../includes/joomla.php');
require_once('../../../../../includes/database.php');
global $mosConfig_live_site, $database, $mosConfig_absolute_path, $mosConfig_lang, $mosConfig_dbprefix;
$thread = intval(mosGetParam($_POST, 'thread'));
if($thread){
	$database->setQuery("UPDATE " . $mosConfig_dbprefix . "fb_polls SET closed=1 WHERE threadid=$thread");
	$database->query();
}
