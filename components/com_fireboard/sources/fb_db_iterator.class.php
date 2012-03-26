<?php
/**
* @version $Id: fb_db_iterator.class.php 462 2007-12-10 00:05:53Z fxstein $
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
class fb_DB_Iterator {
    var $db;
    var $result;
    var $ctype = 'mysql';
    function fb_DB_Iterator($db) {
        $this->db = $db;
        if(function_exists('mysql_ping')) {
            if(!@mysql_ping($db->_resource)) {
      	        $this->ctype = 'mysqli';
            }
        }
        $this->result = $db->query();
    }
    function loadNextObject(&$object) {
        if(!$this->result) {
            return FALSE;
        }
        if($this->ctype=='mysqli') {
            $object = mysqli_fetch_object($this->result);
        } else {
        	$object = mysql_fetch_object($this->result);
        }
        if($object===NULL || $object===FALSE) {
        	return FALSE;
        }
        return TRUE;
    }
    function Reset() {
        if($this->ctype=='mysqli') {
            mysqli_data_seek($this->result, 0);
        } else {
            mysql_data_seek($this->result, 0);
        }
        return TRUE;
    }
    function Free() {
    	if(is_resource())
    	{
            if($this->ctype=='mysqli') {
    		    mysqli_free_result($this->result);
            } else {
            	mysql_free_result($this->result);
            }
    	}
        return TRUE;
    }
}
