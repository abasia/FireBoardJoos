<?php
/**
* @version $Id: stats.class.php 210 2007-07-27 17:20:19Z danialt $
* Fireboard Component
* @package Fireboard
* @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.bestofjoomla.com
*
* Based on joomlaboard Component
* @copyright (C) 2000 - 2004 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Jan de Graaff
*
* Russian edition by Adeptus (c) 2007
*
**/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
class jbStats {
	function get_total_messages($start='',$end='') {
		global $database;
		$where=array();
		if (!empty($start))
			$where[]='time > UNIX_TIMESTAMP(\'' . $start. '\')';
		if (!empty($end))
			$where[]='time < UNIX_TIMESTAMP(\'' . $end . '\')';
		$query='SELECT COUNT(*) FROM #__fb_messages WHERE moved=0 AND hold=0';
		if (count($where)>0)
			$query.=' AND '.implode(' AND ',$where);
		$database->setQuery($query);
		return intval($database->loadResult());
	}
	function get_total_topics($start='',$end='') {
		global $database;
		$where=array();
		if (!empty($start))
			$where[]='time > UNIX_TIMESTAMP(\'' . $start. '\')';
		if (!empty($end))
			$where[]='time < UNIX_TIMESTAMP(\'' . $end . '\')';
		$query='SELECT COUNT(*) FROM #__fb_messages WHERE moved=0 AND hold=0 AND parent=0';
		if (count($where)>0)
			$query.=' AND '.implode(' AND ',$where);
		$database->setQuery($query);
		return intval($database->loadResult());
	}
	function get_top_topics() {
		global $database;
		$database->setQuery('SELECT * FROM #__fb_messages WHERE parent = 0 AND hits > 0  ORDER BY hits DESC LIMIT 5');
		$results=$database->loadObjectList();
		return count($results) > 0 ? $results : array();
	}
	function get_total_categories() {
		global $database;
		$database->setQuery('SELECT COUNT(*) FROM #__fb_categories WHERE parent=0');
		return intval($database->loadResult());
	}
	function get_top_categories() {
		global $database;
		$database->setQuery('SELECT catid,COUNT(id) as totalmsg FROM #__fb_messages' .
				' GROUP BY c.id ORDER BY catid LIMIT 5');
		$results=$database->loadObjectList();
		if (count($results)>0) {
				$ids=implode(',',$results);
				$database->setQuery('SELECT name FROM #__fb_categories WHERE id IN ('.$ids.') ORDER BY catid');
				$names=$database->loadResultArray();
				$i=0;
				foreach ($results as $result)
					$result->name=$names[$i++];
		}
		else
			$results=array();
		return $results;
	}
	function get_total_sections() {
		global $database;
		$database->setQuery('SELECT COUNT(*) FROM #__fb_categories WHERE parent>0');
		return intval($database->loadResult());
	}
	function get_latest_member() {
		global $database;
		$database->setQuery('SELECT username FROM #__users WHERE block=0 AND activation=\'\' ORDER BY id DESC LIMIT 1');
		return $database->loadResult();
	}
	function get_total_members() {
		global $database;
		$database->setQuery('SELECT COUNT(*) FROM #__users');
		return intval($database->loadresult());
	}
	function get_top_posters() {
		global $database;
		$database->setQuery('SELECT s.userid,s.posts,u.username FROM #__fb_users as s ' .
				"\n INNER JOIN  #__users as u ON s.userid=u.id" .
				"\n WHERE s.posts > 0 ORDER BY s.posts DESC LIMIT 10");
		return count($database->loadObjectList()) > 0 ? $database->loadObjectList() : array();
	}
	function get_top_profiles() {
		global $database;
		$database->setQuery('SELECT s.userid,s.uhits,u.username FROM #__fb_users as s ' .
				"\n INNER JOIN  #__users as u ON s.userid=u.id" .
				"\n WHERE s.uhits > 0 ORDER BY s.uhits DESC LIMIT 10");
		return count($database->loadObjectList()) > 0 ? $database->loadObjectList() : array();
	}
	 function get_top_cbprofiles() {
	 	global $database;
 		$database->setQuery("SELECT u.username AS user, p.hits FROM #__users AS u"
			. "\n LEFT JOIN #__comprofiler AS p ON p.user_id = u.id"
			. "\n WHERE p.hits > 0 ORDER BY p.hits DESC LIMIT 10");
		return count($database->loadObjectList()) > 0 ? $database->loadObjectList() : array();
	 }
}
