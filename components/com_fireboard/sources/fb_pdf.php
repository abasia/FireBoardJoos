<?php
/**
 * @version $Id: fb_pdf.php 462 2007-12-10 00:05:53Z fxstein $
 * Fireboard Component
 * @package Fireboard
 * @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.bestofjoomla.com
 *
 * Based on Joomlaboard Component
 * @copyright (C) 2000 - 2004 TSMF / Jan de Graaff / All Rights Reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @author TSMF & Jan de Graaff
 *
 * Russian edition by Adeptus (c) 2007
 *
 **/
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
function dofreePDF($database){
	$mosConfig_sitename = FBJConfig::getCfg('sitename');
	$fbConfig = FBJConfig::getInstance();
	require_once (JB_ABSSOURCESPATH . 'fb_auth.php');
	$is_Mod = 0;
	if(!$is_admin){
		$database->setQuery("SELECT userid FROM #__fb_moderation WHERE catid='$catid' and userid='$my->id'");
		if($database->loadResult()){
			$is_Mod = 1;
		}
	} else{
		$is_Mod = 1;
	}
	if(!$is_Mod){
		unset ($allow_forum);
		$allow_forum = array();
		$database->setQuery("SELECT id,pub_access,pub_recurse,admin_access,admin_recurse FROM #__fb_categories where id=$catid");
		$row = $database->loadObjectList();
		if($fbSession->allowed != "na" && !$new_fb_user){
			$allow_forum = explode(',', $fbSession->allowed);
		} else{
			$allow_forum = array();
		}
		$letPass = 0;
		$letPass = fb_auth::validate_user($row[0], $allow_forum, $aro_group->group_id, $acl);
	}
	if($letPass || $is_Mod){
		$id = intval(mosGetParam($_REQUEST, 'id', 1));
		$catid = intval(mosGetParam($_REQUEST, 'catid', 2));
		include (JB_JABSPATH . '/includes/class.ezpdf.php');
		$database->setQuery("SELECT `thread` FROM #__fb_messages WHERE id='$id' AND catid='$catid'");
		$threadid = $database->loadResult();
		$database->setQuery("SELECT a.*, b.message FROM #__fb_messages AS a, #__fb_messages_text AS b WHERE a.thread = '$threadid' AND a.catid='$catid' AND a.parent=0 AND a.id=b.mesid");
		$row = $database->loadObjectList();
		$mes_text = $row[0]->message;
		$mes_text = str_replace('<p>', "\n\n", $mes_text);
		$mes_text = str_replace('<P>', "\n\n", $mes_text);
		$mes_text = str_replace('<br />', "\n", $mes_text);
		$mes_text = str_replace('<br>', "\n", $mes_text);
		$mes_text = str_replace('<BR />', "\n", $mes_text);
		$mes_text = str_replace('<BR>', "\n", $mes_text);
		$mes_text = str_replace('<li>', "\n - ", $mes_text);
		$mes_text = str_replace('<LI>', "\n - ", $mes_text);
		$mes_text = strip_tags($mes_text);
		$mes_text = str_replace('{mosimage}', '', $mes_text);
		$mes_text = str_replace('{mospagebreak}', '', $mes_text);
		$mes_text = preg_replace("/\[(.*?)\]/si", "", $mes_text);
		$mes_text = decodeHTML($mes_text);
		$pdf = new Cezpdf('a4', 'P');
		$pdf->ezSetCmMargins(2, 1.5, 1, 1);
		$pdf->selectFont('./fonts/Helvetica.afm');
		$all = $pdf->openObject();
		$pdf->saveState();
		$pdf->setStrokeColor(0, 0, 0, 1);
		$pdf->line(10, 40, 578, 40);
		$pdf->line(10, 822, 578, 822);
		$pdf->addText(30, 34, 6, $fbConfig->board_title . ' - ' . $mosConfig_sitename);
		$strtmp = _FB_PDF_VERSION;
		$strtmp = str_replace('%version%', $fbConfig->version, $strtmp);
		$pdf->addText(250, 34, 6, $strtmp);
		$strtmp = _FB_PDF_DATE;
		$strtmp = str_replace('%date%', date('j F, Y, H:i', FBTools::fbGetShowTime()), $strtmp);
		$pdf->addText(450, 34, 6, $strtmp);
		$pdf->restoreState();
		$pdf->closeObject();
		$pdf->addObject($all, 'all');
		$pdf->ezSetDy(30);
		$txt0 = $row[0]->subject;
		$pdf->ezText($txt0, 14);
		$pdf->ezText(_VIEW_POSTED . " " . $row[0]->name . " - " . date(_DATETIME, $row[0]->time), 8);
		$pdf->ezText("_____________________________________", 8);
		$txt3 = "\n";
		$txt3 .= stripslashes($mes_text);
		$pdf->ezText($txt3, 10);
		$pdf->ezText("\n============================================================================\n\n", 8);
		$database->setQuery("SELECT a.*, b.message FROM #__fb_messages AS a, #__fb_messages_text AS b WHERE a.catid=$catid AND a.thread=$threadid AND a.id=b.mesid AND a.parent != 0 ORDER BY a.time ASC");
		$replies = $database->loadObjectList();
		$countReplies = count($replies);
		if($countReplies > 0){
			foreach($replies as $reply){
				$mes_text = $reply->message;
				$mes_text = str_replace('<p>', "\n\n", $mes_text);
				$mes_text = str_replace('<P>', "\n\n", $mes_text);
				$mes_text = str_replace('<br />', "\n", $mes_text);
				$mes_text = str_replace('<br>', "\n", $mes_text);
				$mes_text = str_replace('<BR />', "\n", $mes_text);
				$mes_text = str_replace('<BR>', "\n", $mes_text);
				$mes_text = str_replace('<li>', "\n - ", $mes_text);
				$mes_text = str_replace('<LI>', "\n - ", $mes_text);
				$mes_text = strip_tags($mes_text);
				$mes_text = str_replace('{mosimage}', '', $mes_text);
				$mes_text = str_replace('{mospagebreak}', '', $mes_text);
				$mes_text = preg_replace("/\[(.*?)\]/si", "", $mes_text);
				$mes_text = decodeHTML($mes_text);
				$txt0 = $reply->subject;
				$pdf->ezText($txt0, 14);
				$pdf->ezText(_VIEW_POSTED . " " . $reply->name . " - " . date(_DATETIME, $reply->time), 8);
				$pdf->ezText("_____________________________________", 8);
				$txt3 = "\n";
				$txt3 .= stripslashes($mes_text);
				$pdf->ezText($txt3, 10);
				$pdf->ezText("\n============================================================================\n\n", 8);
			}
		}
		$pdf->ezStream();
	} else{
		echo "Вам недоступен этот ресурс. Ваш IP-адрес зафиксирован, Администратору будет направлено сообщение об этой ошибке.";
	}
}

function decodeHTML($string){
	$string = strtr($string, array_flip(get_html_translation_table(HTML_ENTITIES)));
	$string = preg_replace("/&#([0-9]+);/me", "chr('\\1')", $string);
	return $string;
}

function get_php_setting($val){
	$r = (ini_get($val) == '1' ? 1 : 0);
	return $r ? 'ON' : 'OFF';
}

dofreePDF($database);
