<?php
/**
 * @version $Id: stats.class.php 462 2007-12-10 00:05:53Z fxstein $
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
$database->setQuery("SELECT COUNT(*) FROM #__users");
$totalmembers = $database->loadResult();
$database->setQuery("SELECT COUNT(*) FROM #__fb_messages WHERE moved=0 AND hold=0");
$totalmsgs = $database->loadResult();
$database->setQuery("SELECT COUNT(*) FROM #__fb_messages WHERE parent=0 AND moved=0 AND hold=0");
$totaltitles = $database->loadResult();
$database->setQuery("SELECT COUNT(*) FROM #__fb_categories WHERE parent=0");
$totalcats = $database->loadResult();
$database->setQuery("SELECT COUNT(*) FROM #__fb_categories WHERE parent>0");
$totalsections = $database->loadResult();
unset($_lastestmember);
$database->setQuery("SELECT id, username FROM #__users WHERE block=0 AND activation='' ORDER BY id DESC LIMIT 0,1");
$database->loadObject($_lastestmember);
$lastestmember = $_lastestmember->username;
$lastestmemberid = $_lastestmember->id;
$today = date('Y-m-d');
$yesterday = time() - (1 * 24 * 60 * 60);
$yesterday = date('Y-m-d', $yesterday);
$todaystart = strtotime(date("Y-m-d 00:00:01"));
$todayend = strtotime(date("Y-m-d 23:59:59"));
$yesterdaystart = strtotime(date("$yesterday 00:00:01")); #NOTE: 00:00:00 is daystart
$yesterdayend = strtotime(date("$yesterday 23:59:59"));
$database->setQuery("SELECT COUNT(*) FROM #__fb_messages WHERE time > $todaystart AND time < $todayend AND parent>0");
$todaytotal = $database->loadResult();
$database->setQuery("SELECT COUNT(*) FROM #__fb_messages WHERE time > $yesterdaystart AND time < $yesterdayend AND parent>0");
$yesterdaytotal = $database->loadResult();
$database->setQuery("SELECT COUNT(*) FROM #__fb_messages WHERE time > $todaystart AND time < $todayend AND parent=0");
$todaystitle = $database->loadResult();
$database->setQuery("SELECT COUNT(*) FROM #__fb_messages WHERE time > $yesterdaystart AND time < $yesterdayend AND parent=0");
$yesterdaystitle = $database->loadResult();
$PopUserCount = $fbConfig->PopUserCount;
$database->setQuery("SELECT p.userid, p.posts, u.username FROM #__fb_users AS p" . "\n LEFT JOIN #__users AS u ON u.id = p.userid" . "\n WHERE p.posts > 0 ORDER BY p.posts DESC LIMIT $PopUserCount");
$topposters = $database->loadObjectList();
$database->setQuery("SELECT u.uhits AS hits, u.userid AS user_id, j.username AS user  FROM #__fb_users AS u" . "\n LEFT JOIN #__users AS j ON j.id = u.userid" . "\n WHERE u.uhits > 0 ORDER BY u.uhits DESC LIMIT $PopUserCount");
$topprofiles = $database->loadObjectList();
$database->setQuery("SELECT uhits FROM #__fb_users" . "\n WHERE uhits > 0 ORDER BY uhits DESC LIMIT 1");
$topprofil = $database->loadResult();
$database->setQuery("SELECT posts FROM #__fb_users WHERE posts > 0 ORDER BY posts DESC LIMIT 0,1");
$topmessage = $database->loadResult();
$PopSubjectCount = $fbConfig->PopSubjectCount;
$database->setQuery("SELECT * FROM #__fb_messages WHERE moved=0 AND hold=0 AND parent=0 ORDER BY hits DESC LIMIT $PopSubjectCount");
$toptitles = $database->loadObjectList();
$database->setQuery("SELECT hits FROM #__fb_messages WHERE moved=0 AND hold=0 AND parent=0 ORDER BY hits DESC LIMIT 1");
$toptitlehits = $database->loadResult();
