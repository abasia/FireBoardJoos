<?php
/**
 * @version $Id: fb_image_upload.php 462 2007-12-10 00:05:53Z fxstein $
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
$fbConfig = FBJConfig::getInstance();
require_once(JB_ABSSOURCESPATH . 'fb_helpers.php');

function imageUploadError($msg, $message){
	$GLOBALS['FB_rc'] = 0;
	$message = str_replace("[img]", "", $message);
	fbAlert("$msg" . _IMAGE_NOT_UPLOADED);
	return $message;
}

$GLOBALS['FB_rc'] = 1;
if($GLOBALS['FB_rc']){
	if(empty($_FILES['attachimage']['name'])){
		imageUploadError(_IMAGE_ERROR_EMPTY, $message);
	}

	// Проверяем тип
	$imageType = array(1 => 'gif', 2 => 'jpg', 3 => 'png');
	$imgInfo = getimagesize($_FILES['attachimage']['tmp_name']);
	if(!$imgInfo OR ($imgInfo[2] < 1 OR $imgInfo[2] > 3)){
		imageUploadError(_IMAGE_ERROR_TYPE, $message);
	}
	$imageExt = $imageType[$imgInfo[2]];

	// Проверяем размера
	$maxAvSize = $fbConfig->avatarSize * 1024;
	if($_FILES['attachimage']['size'] > $maxAvSize){
		imageUploadError(_IMAGE_ERROR_SIZE . " (" . $fbConfig->imageSize . "kb)", $message);
	}

	// проверяем ширину
	list($width, $height) = getimagesize($_FILES['attachimage']['tmp_name']);
	if($width > $fbConfig->imageWidth){
		imageUploadError(_IMAGE_ERROR_WIDTH . " (" . $fbConfig->imageWidth . " pixels)", $message);
	}
	// проверяем высоту
	if($height > $fbConfig->imageHeight){
		imageUploadError(_IMAGE_ERROR_HEIGHT . " (" . $fbConfig->imageHeight . " pixels)", $message);
	}
}
if($GLOBALS['FB_rc']){
	$imageName = $my->id . '-' . time() . '.' . $imageExt;
	$imageLocation = FB_ABSUPLOADEDPATH . DS . "images" . DS . $imageName;
	move_uploaded_file($_FILES['attachimage']['tmp_name'], $imageLocation);
	@chmod($imageLocation, 0777);
}
if($GLOBALS['FB_rc']){
	if($width < '100'){
		$code = '[img]' . FB_LIVEUPLOADEDPATH . '/images/' . $imageName . '[/img]';
	} else{
		$code = '[img size=' . $width . ']' . FB_LIVEUPLOADEDPATH . '/images/' . $imageName . '[/img]';
	}

	if(preg_match("/\[img\]/si", $message)){
		$message = str_replace("[img]", $code, $message);
	} else{
		$message = $message . ' ' . $code;
	}
}
