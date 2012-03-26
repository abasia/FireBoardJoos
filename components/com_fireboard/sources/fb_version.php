<?php
/**
* @version $Id: fb_version.php 530 2007-12-23 15:35:27Z danialt $
* Fireboard Component
* @package Fireboard
* @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.bestofjoomla.com
*
* Russian edition by Adeptus (c) 2007
*
**/
defined( '_VALID_MOS' ) or die( 'Restricted access' );
class fireboardVersion {
	var $PRODUCT 	= 'FireBoardRE';
	var $RELEASE 	= '2.0';
	var $DEV_STATUS = 'Stable';
	var $DEV_LEVEL 	= '4';
	var $BUILD	 	= '$Revision: 530 $';
	var $CODENAME 	= 'Teakwood';
	var $RELDATE 	= '23 april 2008';
	var $RELTIME 	= '01:00';
	var $RELTZ 		= 'UTC';
	var $COPYRIGHT 	= "Copyright (C) 2008 Adeptus. All rights reserved.";
	var $URL 		= '<a href="http://www.adeptsite.info"  title="Visit Adeptus!" target="_blank">FireBoardRE </a> is a Free Software released under the GNU/GPL License.';
	var $SITE 		= 1;
	var $RESTRICT	= 0;
	var $SVN			= 0;
	function getLongVersion() {
		return $this->PRODUCT .' '. $this->RELEASE .'.'. $this->DEV_LEVEL .' '
			. $this->DEV_STATUS
			.' [ '.$this->CODENAME .' ] '. $this->RELDATE .' '
			. $this->RELTIME .' '. $this->RELTZ;
	}
	function getShortVersion() {
		return $this->RELEASE .'.'. $this->DEV_LEVEL;
	}
	function getHelpVersion() {
		if ($this->RELEASE > '1.0') {
			return '.' . str_replace( '.', '', $this->RELEASE );
		} else {
			return '';
		}
	}
}
$_FB_VERSION = new fireboardVersion();
$fbversion = $_FB_VERSION->PRODUCT.' '.$_FB_VERSION->RELEASE.' '._FB_VERSION->RELDATE;
