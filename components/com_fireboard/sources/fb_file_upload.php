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

function fileUploadError($msg, $message){
	$GLOBALS['FB_rc'] = 0;
	$message = str_replace("[file]", "", $message);
	fbAlert("$msg" . _FILE_NOT_UPLOADED);
	return $message;
}

$GLOBALS['FB_rc'] = 1;
if($GLOBALS['FB_rc']){
	if(empty($_FILES['attachfile']['name'])){
		fileUploadError(_FILE_ERROR_EMPTY, $message);
	}

	// разрешённые расширения
	$allowedArray = explode(',', strtolower($fbConfig->fileTypes));
	// получаем расширение файла
	$preg = '/\.[a-zA-Z0-9_]{1,}$/i';
	$file_ext_tmp =  preg_match($preg, $_FILES['attachfile']['name'], $tmp);
	if (!$file_ext_tmp){
		fileUploadError(_FILE_ERROR_TYPE . " " . $fbConfig->fileTypes, $message);
	}else{
		$fileExt = strtolower(str_replace('.', '', $tmp[0]));
		if(!in_array($fileExt, $allowedArray)){
			fileUploadError(_FILE_ERROR_TYPE . " " . $fbConfig->fileTypes, $message);
		}
	}

	// проверка размера
	$maxFileSize = $fbConfig->fileSize * 1024;
	if($_FILES['attachfile']['size'] > $maxFileSize){
		fileUploadError(_FILE_ERROR_SIZE . " (" . $fbConfig->fileSize . "kb) ", $message);
	}
}

if($GLOBALS['FB_rc']){
	$fileName = $my->id . '-' . time() . '.' . $fileExt;
	$fileLocation = FB_ABSUPLOADEDPATH . DS . "files" . DS . $fileName;
	move_uploaded_file($_FILES['attachfile']['tmp_name'], $fileLocation);
	@chmod($fileLocation, 0777);
}
if($GLOBALS['FB_rc']){
	$code = '[file name=' . $fileName . ' size=' . $_FILES['attachfile']['size'] . ']' . FB_LIVEUPLOADEDPATH . '/files/' . $fileName . '[/file]';
	if(preg_match("/\[file\]/si", $message)){
		$message = str_replace("[file]", $code, $message);
	} else{
		$message = $message . ' ' . $code;
	}
}
