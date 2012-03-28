<?php
/**
 * @version $Id: fb_file_upload.php 462 2007-12-10 00:05:53Z fxstein $
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
require_once(JB_ABSSOURCESPATH . 'fb_helpers.php');
function fileUploadError($msg){
	global $message;	// TODO:GoDr убрать глобальную переменную
	$GLOBALS['FB_rc'] = 0;
	$message = str_replace("[file]", "", $message);
	fbAlert("$msg" . _FILE_NOT_UPLOADED);
}

$GLOBALS['FB_rc'] = 1;
$filename = explode("\.", $_FILES['attachfile']['name']);
$numExtensions = (count($filename)) - 1;
$fileName = preg_replace("/[^0-9a-zA-Z_а-яА-Я]/", "_", $filename[0]);
$fileExt = $filename[$numExtensions];
$filename = utf2win1251($filename);
$newFileName = $fileName . '.' . $fileExt;
$fileSize = $_FILES['attachfile']['size'];
if(file_exists(FB_ABSUPLOADEDPATH . "/files/$newFileName")){
	$newFileName = $fileName . '-' . md5(microtime()) . "." . $fileExt;
}
if($GLOBALS['FB_rc']){
	$fileLocation = FB_ABSUPLOADEDPATH . "/files/$newFileName";
	if(empty($_FILES['attachfile']['name'])){
		fileUploadError(_FILE_ERROR_EMPTY);
	}
	$allowedArray = explode(',', strtolower($fbConfig->fileTypes));

	if(!in_array($fileExt, $allowedArray)){
		fileUploadError(_FILE_ERROR_TYPE . " " . $fbConfig->fileTypes);
	}
	$maxImgSize = $fbConfig->fileSize * 1024;
	if($fileSize > $maxImgSize){
		fileUploadError(_FILE_ERROR_SIZE . " (" . $fbConfig->fileSize . "kb)");
	}
}
if($GLOBALS['FB_rc']){
	move_uploaded_file($_FILES['attachfile']['tmp_name'], $fileLocation);
	@chmod($fileLocation, 0777);
}
if($GLOBALS['FB_rc']){
	$code = '[file name=' . $newFileName . ' size=' . $fileSize . ']' . FB_LIVEUPLOADEDPATH . '/files/' . $newFileName . '[/file]';
	if(preg_match("/\[file\]/si", $message)){
		$message = str_replace("[file]", $code, $message);
	} else{
		$message = $message . ' ' . $code;
	}
}
function utf2win1251($content){
	$newcontent = "";
	for($i = 0; $i < strlen($content); $i++){
		$c1 = substr($content, $i, 1);
		$byte1 = ord($c1);
		if($byte1 >> 5 == 6){
			$i++;
			$c2 = substr($content, $i, 1);
			$byte2 = ord($c2);
			$byte1 &= 31;
			$byte2 &= 63;
			$byte2 |= (($byte1 & 3) << 6);
			$byte1 >>= 2;
			$word = ($byte1 << 8) + $byte2;
			if($word == 1025) $newcontent .= chr(168); else if($word == 1105) $newcontent .= chr(184); else if($word >= 0x0410 && $word <= 0x044F) $newcontent .= chr($word - 848); else{
				$a = dechex($byte1);
				$a = str_pad($a, 2, "0", STR_PAD_LEFT);
				$b = dechex($byte2);
				$b = str_pad($b, 2, "0", STR_PAD_LEFT);
				$newcontent .= "" . $a . $b . ";";
			}
		} else $newcontent .= $c1;
	}
	return $newcontent;
}
