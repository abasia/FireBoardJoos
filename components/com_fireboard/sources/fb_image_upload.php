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
function imageUploadError($msg){
	global $message;	// TODO:GoDr убрать глобальную переменную
	$GLOBALS['FB_rc'] = 0;
	$message = str_replace("[img]", "", $message);
	fbAlert("$msg" . _IMAGE_NOT_UPLOADED);
}

$GLOBALS['FB_rc'] = 1;
$filename = explode("\.", $_FILES['attachimage']['name']);
$numExtensions = (count($filename)) - 1;
$imageName = preg_replace("/[^0-9a-zA-Z_]/", "_", $filename[0]);
$imageExt = $filename[$numExtensions];
$newFileName = $imageName . '.' . $imageExt;
$imageSize = $_FILES['attachimage']['size'];
if(file_exists(FB_ABSUPLOADEDPATH . "/images/$newFileName")){
	$newFileName = $imageName . '-' . md5(microtime()) . "." . $imageExt;
}
if($GLOBALS['FB_rc']){
	$imageLocation = FB_ABSUPLOADEDPATH . "/images/$newFileName";
	if(empty($_FILES['attachimage']['name'])){
		imageUploadError(_IMAGE_ERROR_EMPTY);
	}
	if(!($imgtype = FB_check_image_type($imageExt))){
		imageUploadError(_IMAGE_ERROR_TYPE);
	}
	$maxImgSize = $fbConfig->imageSize * 1024;
	if($imageSize > $maxImgSize){
		imageUploadError(_IMAGE_ERROR_SIZE . " (" . $fbConfig->imageSize . "kb)");
	}
	list($width, $height) = @getimagesize($_FILES['attachimage']['tmp_name']);
	if($width > $fbConfig->imageWidth){
		imageUploadError(_IMAGE_ERROR_WIDTH . " (" . $fbConfig->imageWidth . " pixels");
	}
	if($height > $fbConfig->imageHeight){
		imageUploadError(_IMAGE_ERROR_HEIGHT . " (" . $fbConfig->imageHeight . " pixels");
	}
}
if($GLOBALS['FB_rc']){
	move_uploaded_file($_FILES['attachimage']['tmp_name'], $imageLocation);
	@chmod($imageLocation, 0777);
}
if($GLOBALS['FB_rc']){
	if($width < '100'){
		$code = '[img]' . FB_LIVEUPLOADEDPATH . '/images/' . $newFileName . '[/img]';
	} else{
		$code = '[img size=' . $width . ']' . FB_LIVEUPLOADEDPATH . '/images/' . $newFileName . '[/img]';
	}

	if(preg_match("/\[img\]/si", $message)){
		$message = str_replace("[img]", $code, $message);
	} else{
		$message = $message . ' ' . $code;
	}
}
