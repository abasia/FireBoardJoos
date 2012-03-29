<?php
/**
 * @version $Id: install.fireboard.php 462 2007-12-10 00:05:53Z fxstein $
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
function com_install(){
	error_reporting(E_ERROR);
	$mainframe = mosMainFrame::getInstance();
	$database = database::getInstance();

	?>
<style>
	.fbscs {
		margin: 0;
		padding: 0;
		list-style: none;
	}

	.fbscslist {
		list-style: none;
		padding: 5px 10px;
		margin: 3px 0;
		border: 1px solid #66CC66;
		background: #D6FEB8;
		display: block;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		color: #333;
	}

	.fbscslisterror {
		list-style: none;
		padding: 5px 10px;
		margin: 3px 0;
		border: 1px solid #FF9999;
		background: #FFCCCC;
		display: block;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		color: #333;
	}

	.err {
		color: #ff0000;
		font-weight: bold;
	}

	.ok {
		color: #009900;
		font-weight: bold;
	}
</style>
<div style="border:1px solid #ccc; background:#FBFBFB; padding:10px; text-align:left;margin:10px 0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="20%" valign="top" style="padding:10px;">
	<a href="index2.php?option=com_fireboard" title="Перейти к администрированию Форума"><img src="components/com_fireboard/images/logo.gif" alt="FireBoardRE" border="0"></a><br/><br/>
	<a href="index2.php?option=com_fireboard" title="Перейти к администрированию Форума"><img src="components/com_fireboard/images/logo1.jpg" alt="Gold Dragon" border="0"></a>
</td>
<td width="80%" valign="top" style="padding:10px;">
<div style="border:1px solid #FFCC99; background:#FFFFCC; padding:20px; margin:20px; clear:both;">
<p><strong>Создание базы данных:</strong></p>
<ul>
<li>Создание таблицы <b>fb_announcement: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_announcement` (
			`id` int(3) NOT NULL AUTO_INCREMENT,
			`title` tinytext,
			`sdescription` text NOT NULL,
			`description` text NOT NULL,
			`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`published` tinyint(1) NOT NULL DEFAULT '0',
			`ordering` tinyint(4) NOT NULL DEFAULT '0',
			`showdate` tinyint(1) NOT NULL DEFAULT '1',
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_attachments: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_attachments` (
			`mesid` int(11) NOT NULL DEFAULT '0',
			`filelocation` text NOT NULL,
			KEY `mesid` (`mesid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_categories: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_categories` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`parent` int(11) DEFAULT '0',
			`name` tinytext,
			`cat_emoticon` tinyint(4) NOT NULL DEFAULT '0',
			`locked` tinyint(4) NOT NULL DEFAULT '0',
			`alert_admin` tinyint(4) NOT NULL DEFAULT '0',
			`moderated` tinyint(4) NOT NULL DEFAULT '1',
			`moderators` varchar(15) DEFAULT NULL,
			`pub_access` tinyint(4) DEFAULT '1',
			`pub_recurse` tinyint(4) DEFAULT '1',
			`admin_access` tinyint(4) DEFAULT '0',
			`admin_recurse` tinyint(4) DEFAULT '1',
			`ordering` tinyint(4) NOT NULL DEFAULT '0',
			`future2` int(11) DEFAULT '0',
			`published` tinyint(4) NOT NULL DEFAULT '0',
			`checked_out` tinyint(4) NOT NULL DEFAULT '0',
			`checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`review` tinyint(4) NOT NULL DEFAULT '0',
			`hits` int(11) NOT NULL DEFAULT '0',
			`description` text NOT NULL,
			`headerdesc` text NOT NULL,
			`class_sfx` varchar(20) NOT NULL,
			`id_last_msg` int(10) NOT NULL DEFAULT '0',
			`numTopics` mediumint(8) NOT NULL DEFAULT '0',
			`numPosts` mediumint(8) NOT NULL DEFAULT '0',
			`time_last_msg` int(11) DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `parent` (`parent`),
			KEY `published_pubaccess_id` (`published`,`pub_access`,`id`),
			KEY `msg_id` (`id_last_msg`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_config: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_config` (
			`name` varchar(200) NOT NULL,
			`value` text NOT NULL,
			UNIQUE KEY `name` (`name`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Загрузка данных в <b>fb_config: </b>:
	<?php
	$sql = "INSERT INTO `#__fb_config` (`name`, `value`) VALUES
			('allowAvatar', '1'),('allowAvatarGallery', '1'),('allowAvatarUpload', '1'),('allowfavorites', '1'),
			('allowFileRegUpload', '1'),('allowFileUpload', '1'),('allowImageRegUpload', '1'),('allowImageUpload', '1'),
			('allowsubscriptions', '1'),('AnnModId', '62'),('askemail', '0'),('attach_guests', '1'),
			('avatarHeight', '100'),('avatarLargeHeight', '250'),('avatarLargeWidth', '250'),('avatarOnCat', '1'),
			('avatarQuality', '75'),('avatarSize', '100'),('avatarSmallHeight', '50'),('avatarSmallWidth', '50'),
			('avatarWidth', '100'),('avatar_src', 'fb'),('badwords', '0'),('board_offline', '0'),
			('board_ofset', '0'),('board_title', 'Форум'),('captcha', '1'),('CatImagePath', 'category_images/'),
			('cb_profile', '0'),('changename', '0'),('default_view', 'flat'),('discussBot', '0'),
			('disemoticons', '0'),('editMarkUp', '1'),('email', 'change@me.com'),('enableForumJump', '1'),
			('enableHelpPage', '1'),('enablePDF', '1'),('enableRSS', '1'),('enableRulesPage', '1'),
			('fb_profile', 'fb'),('fileSize', '1024'),('fileTypes', 'zip,txt,doc,rar'),('floodprotection', '0'),
			('help_cid', '1'),('help_infb', '1'),('help_link', ''),('historyLimit', '6'),
			('imageHeight', '800'),('imageProcessor', 'gd2'),('imageSize', '100'),('imageWidth', '1024'),
			('jmambot', '1'),('joomlaStyle', '0'),('latestCategory', ''),('latestCount', '10'),('latestCountPerPage', '5'),
			('latestReplySubject', '1'),('latestShowAuthor', '1'),('latestShowDate', '1'),('latestShowHits', '1'),
			('latestSingleSubject', '1'),('latestSubjectLength', '100'),('mailadmin', '0'),('mailfull', '0'),
			('mailmod', '0'),('maxSig', '300'),('maxSubject', '50'),('messages_per_page', '6'),
			('messages_per_page_search', '15'),('newChar', 'NEW!'),('numchildcolumn', '2'),('offline_message', '<h2>Форум временно закрыт.</h2><br/>Зайдите позже!'),
			('pm_component', 'no'),('pollmax', '5'),('polls', '1'),('PopSubjectCount', '10'),('PopUserCount', '10'),
			('postStats', '1'),('pubwrite', '0'),('rankimages', '1'),('re', '0'),('regonly', '0'),('reportmsg', '1'),
			('rteheight', '300'),('rtewidth', '450'),('rules_cid', '1'),('rules_infb', '1'),('rules_link', ''),
			('showAnnouncement', '1'),('showChildCatIcon', '1'),('showemail', '1'),('showGenStats', '1'),
			('showHistory', '1'),('showkarma', '1'),('showLatest', '1'),('showNew', '1'),('showPopSubjectStats', '1'),
			('showPopUserStats', '1'),('showranking', '1'),('showStats', '1'),('showWhoisOnline', '1'),('statsColor', '12'),
			('subscriptionschecked', '1'),('template', 'default'),('templateimagepath', 'default'),('threads_per_page', '20'),
			('useredit', '1'),('usereditTime', '0'),('usereditTimeGrace', '600'),('userlist_avatar', '1'),('userlist_email', '1'),
			('userlist_group', '1'),('userlist_joindate', '1'),('userlist_karma', '1'),('userlist_lastvisitdate', '1'),
			('userlist_name', '1'),('userlist_online', '1'),('userlist_posts', '1'),('userlist_rows', '30'),('userlist_userhits', '1'),
			('userlist_username', '1'),('userlist_usertype', '1'),('username', '1'),('usernamechange', '1'),('version', '2.0'),('wrap', '250');";
	$database->setQuery($sql);
	if(!$database->query()){
		echo ' <span class="err">НЕТ</span>';
	} else{
		echo ' <span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_favorites: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_favorites` (
			`thread` int(11) NOT NULL DEFAULT '0',
			`userid` int(11) NOT NULL DEFAULT '0',
			KEY `thread` (`thread`),
			KEY `userid` (`userid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_groups: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_groups` (
			`id` int(4) NOT NULL AUTO_INCREMENT,
			`title` varchar(255) DEFAULT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Загрузка данных в <b>fb_groups: </b>
	<?php
	$sql = "INSERT INTO `#__fb_groups` (`id`, `title`) VALUES
			(1, 'Пользователи'),(2, 'Администрация'),(3, 'Модераторы'),(4, 'Помощники'),
			(5, 'Друзья'),(6, 'V.I.P.'),(7, 'Поддержка'),(8, 'Команда');";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err"> НЕТ</span>';
	} else{
		echo '<span class="ok"> ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_messages: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `jos_fb_messages` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`parent` int(11) DEFAULT '0',
			`thread` int(11) DEFAULT '0',
			`catid` int(11) NOT NULL DEFAULT '0',
			`name` tinytext,
			`userid` int(11) NOT NULL DEFAULT '0',
			`email` tinytext,
			`subject` tinytext,
			`time` int(11) NOT NULL DEFAULT '0',
			`ip` varchar(15) DEFAULT NULL,
			`topic_emoticon` int(11) NOT NULL DEFAULT '0',
			`locked` tinyint(4) NOT NULL DEFAULT '0',
			`hold` tinyint(4) NOT NULL DEFAULT '0',
			`ordering` int(11) DEFAULT '0',
			`hits` int(11) DEFAULT '0',
			`moved` tinyint(4) DEFAULT '0',
			`modified_by` int(7) DEFAULT NULL,
			`modified_time` int(11) DEFAULT NULL,
			`modified_reason` tinytext,
			PRIMARY KEY (`id`),
			KEY `thread` (`thread`),
			KEY `parent` (`parent`),
			KEY `catid` (`catid`),
			KEY `ip` (`ip`),
			KEY `userid` (`userid`),
			KEY `time` (`time`),
			KEY `locked` (`locked`),
			KEY `hold_time` (`hold`,`time`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_messages_text: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_messages_text` (
			`mesid` int(11) NOT NULL DEFAULT '0',
			`message` text NOT NULL,
			PRIMARY KEY (`mesid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_moderation: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_moderation` (
			`catid` int(11) NOT NULL DEFAULT '0',
			`userid` int(11) NOT NULL DEFAULT '0',
			`future1` tinyint(4) DEFAULT '0',
			`future2` int(11) DEFAULT '0',
			PRIMARY KEY (`catid`,`userid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_polls: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_polls` (
			`pollid` int(11) NOT NULL AUTO_INCREMENT,
			`threadid` varchar(11) NOT NULL DEFAULT '0',
			`avtorid` int(11) NOT NULL DEFAULT '0',
			`vopros` text,
			`closed` int(1) NOT NULL DEFAULT '0',
			KEY `pollid` (`pollid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_pollsotvet: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_pollsotvet` (
			`poll_id` int(11) NOT NULL DEFAULT '0',
			`pollotvet` text,
			KEY `poll_id` (`poll_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_pollsresults: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_pollsresults` (
			`answerid` int(11) NOT NULL AUTO_INCREMENT,
			`threadid` varchar(11) NOT NULL DEFAULT '0',
			`answeruserid` int(11) NOT NULL DEFAULT '0',
			`answer` int(1) NOT NULL,
			KEY `answerid` (`answerid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_ranks: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_ranks` (
			`rank_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
			`rank_title` varchar(255) NOT NULL DEFAULT '',
			`rank_min` mediumint(8) unsigned NOT NULL DEFAULT '0',
			`rank_special` tinyint(1) unsigned NOT NULL DEFAULT '0',
			`rank_image` varchar(255) NOT NULL DEFAULT '',
			PRIMARY KEY (`rank_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Загрузка данных в <b>fb_ranks: </b>
	<?php
	$sql = "INSERT INTO `#__fb_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_special`, `rank_image`) VALUES
			(1, 'Fresh Boarder', 0, 0, 'rank1.gif'),(2, 'Junior Boarder', 20, 0, 'rank2.gif'),
			(3, 'Senior Boarder', 40, 0, 'rank3.gif'),(4, 'Expert Boarder', 80, 0, 'rank4.gif'),
			(5, 'Gold Boarder', 160, 0, 'rank5.gif'),(6, 'Platinum Boarder', 320, 0, 'rank6.gif'),
			(7, 'Administrator', 0, 1, 'rankadmin.gif'),(8, 'Moderator', 0, 1, 'rankmod.gif'),
			(9, 'Spammer', 0, 1, 'rankspammer.gif');";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_sessions: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_sessions` (
			`userid` int(11) NOT NULL DEFAULT '0',
			`allowed` text,
			`lasttime` int(11) NOT NULL DEFAULT '0',
			`readtopics` text,
			`currvisit` int(11) NOT NULL DEFAULT '0',
			PRIMARY KEY (`userid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_smileys: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_smileys` (
			`id` int(4) NOT NULL AUTO_INCREMENT,
			`code` varchar(12) NOT NULL DEFAULT '',
			`location` varchar(50) NOT NULL DEFAULT '',
			`greylocation` varchar(60) NOT NULL DEFAULT '',
			`emoticonbar` tinyint(4) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Загрузка данных в <b>fb_smileys: </b>
	<?php
	$sql = "INSERT INTO `#__fb_smileys` (`id`, `code`, `location`, `greylocation`, `emoticonbar`) VALUES
			(1, 'B)', 'cool.png', 'cool-grey.png', 1),(2, ':(', 'sad.png', 'sad-grey.png', 1),
			(3, ':)', 'smile.png', 'smile-grey.png', 1),(4, ':-)', 'smile.png', 'smile-grey.png', 0),
			(5, ':-(', 'sad.png', 'sad-grey.png', 0),(6, ':laugh:', 'laughing.png', 'laughing-grey.png', 1),
			(7, ':cheer:', 'cheerful.png', 'cheerful-grey.png', 1),(8, ';)', 'wink.png', 'wink-grey.png', 1),
			(9, ';-)', 'wink.png', 'wink-grey.png', 0),(10, ':P', 'tongue.png', 'tongue-grey.png', 1),
			(12, ':X', 'sick.png', 'sick-grey.png', 0),(13, ':x', 'sick.png', 'sick-grey.png', 0),
			(14, ':angry:', 'angry.png', 'angry-grey.png', 1),(15, ':mad:', 'angry.png', 'angry-grey.png', 0),
			(16, ':unsure:', 'unsure.png', 'unsure-grey.png', 1),(17, ':ohmy:', 'shocked.png', 'shocked-grey.png', 1),
			(18, ':huh:', 'wassat.png', 'wassat-grey.png', 1),(19, ':dry:', 'ermm.png', 'ermm-grey.png', 1),
			(20, ':ermm:', 'ermm.png', 'ermm-grey.png', 0),(21, ':lol:', 'grin.png', 'grin-grey.png', 1),
			(22, ':sick:', 'sick.png', 'sick-grey.png', 1),(23, ':silly:', 'silly.png', 'silly-grey.png', 1),
			(24, ':y32b4:', 'silly.png', 'silly-grey.png', 0),(25, ':blink:', 'blink.png', 'blink-grey.png', 1),
			(26, ':blush:', 'blush.png', 'blush-grey.png', 1),(27, ':kiss:', 'kissing.png', 'kissing-grey.png', 1),
			(28, ':rolleyes:', 'blink.png', 'blink-grey.png', 0),(29, ':woohoo:', 'w00t.png', 'w00t-grey.png', 1),
			(30, ':side:', 'sideways.png', 'sideways-grey.png', 1),(31, ':S', 'dizzy.png', 'dizzy-grey.png', 1),
			(32, ':s', 'dizzy.png', 'dizzy-grey.png', 0),(33, ':evil:', 'devil.png', 'devil-grey.png', 1),
			(34, ':whistle:', 'whistling.png', 'whistling-grey.png', 1),(35, ':pinch:', 'pinch.png', 'pinch-grey.png', 1),
			(36, ':p', 'tongue.png', 'tongue-grey.png', 0),(37, ':D', 'laughing.png', 'laughing-grey.png', 0);";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_subscriptions: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_subscriptions` (
			`thread` int(11) NOT NULL DEFAULT '0',
			`userid` int(11) NOT NULL DEFAULT '0',
			`future1` int(11) DEFAULT '0',
			KEY `thread` (`thread`),
			KEY `userid` (`userid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_users: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_users` (
			`userid` int(11) NOT NULL DEFAULT '0',
			`view` varchar(8) NOT NULL DEFAULT 'flat',
			`signature` text,
			`moderator` int(11) DEFAULT '0',
			`ordering` int(11) DEFAULT '0',
			`posts` int(11) DEFAULT '0',
			`avatar` varchar(50) DEFAULT NULL,
			`karma` int(11) DEFAULT '0',
			`karma_time` int(11) DEFAULT '0',
			`group_id` int(4) DEFAULT '1',
			`uhits` int(11) DEFAULT '0',
			`personalText` tinytext,
			`gender` tinyint(4) NOT NULL DEFAULT '0',
			`birthdate` date NOT NULL DEFAULT '0001-01-01',
			`location` varchar(50) DEFAULT NULL,
			`ICQ` varchar(50) DEFAULT NULL,
			`AIM` varchar(50) DEFAULT NULL,
			`YIM` varchar(50) DEFAULT NULL,
			`MSN` varchar(50) DEFAULT NULL,
			`SKYPE` varchar(50) DEFAULT NULL,
			`GTALK` varchar(50) DEFAULT NULL,
			`websitename` varchar(50) DEFAULT NULL,
			`websiteurl` varchar(50) DEFAULT NULL,
			`rank` tinyint(4) NOT NULL DEFAULT '0',
			`hideEmail` tinyint(1) NOT NULL DEFAULT '1',
			`showOnline` tinyint(1) NOT NULL DEFAULT '1',
			`ban` tinyint(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (`userid`),
			KEY `group_id` (`group_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>

<li>Создание таблицы <b>fb_whoisonline: </b>
	<?php
	$sql = "CREATE TABLE IF NOT EXISTS `#__fb_whoisonline` (
			`id` int(6) NOT NULL AUTO_INCREMENT,
			`userid` int(7) NOT NULL DEFAULT '0',
			`time` varchar(14) NOT NULL DEFAULT '0',
			`item` int(6) DEFAULT '0',
			`what` varchar(255) DEFAULT '0',
			`func` varchar(50) DEFAULT NULL,
			`do` varchar(50) DEFAULT NULL,
			`task` varchar(50) DEFAULT NULL,
			`link` text,
			`userip` varchar(20) NOT NULL DEFAULT '',
			`user` tinyint(2) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`),
			KEY `userid` (`userid`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;";
	$database->setQuery($sql);
	if(!$database->query()){
		echo '<span class="err">НЕТ</span>';
	} else{
		echo '<span class="ok">ОК</span>';
	}
	?>
</li>
	<?php
	$database->setQuery("SELECT id FROM #__components WHERE admin_menu_link = 'option=com_fireboard'");
	$id = $database->loadResult();
	$database->setQuery("UPDATE #__components " . "SET admin_menu_img  = '../administrator/components/com_fireboard/images/fbmenu.png'" . ",   admin_menu_link = 'option=com_fireboard' " . "WHERE id='$id'");
	$database->query();
	$database->setQuery("UPDATE `#__fb_categories` SET `moderated` = '1';");
	$database->query();
	?>
</ul>
</div>
	<?php
	if(is_writable($mainframe->getCfg("absolute_path"))){
		dircopy($mainframe->getCfg("absolute_path") . "/components/com_fireboard/_fbfiles_dist", $mainframe->getCfg("absolute_path") . "/images/fbfiles", false);
		?>
	<div style="border:1px solid #FFCC99; background:#FFFFCC; padding:20px; margin:20px; clear:both;">
		<ul>
			<li>Создание служебного каталога: <span class="ok">ОК</span></li>
		</ul>
	</div>
		<?php
	} else{
		?>
	<div style="border:1px solid #FFCC99; background:#FFFFCC; padding:20px; margin:20px; clear:both;">
		<ul class="fbscs">
			<li class="fbscslisterror">
				<div style="border:1px solid  #FF6666; background: #FFCC99; padding:10px; text-align:left; margin:10px 0;">
					<img src='images/publish_x.png' align='absmiddle'> Не удалось создать каталоги:
					<br>
                    <pre>
					<?php echo $mainframe->getCfg("absolute_path"); ?>/images/fbfiles/
						<?php echo $mainframe->getCfg("absolute_path");?>/images/fbfiles/avatars
						<?php echo $mainframe->getCfg("absolute_path");?>/images/fbfiles/avatars/gallery (каталог для размещения Аватар)
						<?php echo $mainframe->getCfg("absolute_path");?>/images/fbfiles/category_images
						<?php echo $mainframe->getCfg("absolute_path");?>/images/fbfiles/files
						<?php echo $mainframe->getCfg("absolute_path");?>/images/fbfiles/images
					</pre>
					Вручную скопируйте каталог __fbfiles_dist в каталог images/, переименуйте каталог в "fbfiles" и установите ему права доступа 0777
				</div>
			</li>
		</ul>
	</div>
		<?php
	}
	?>
<div style="border:1px solid #FFCC99; background:#FFFFCC; padding:20px; margin:20px; clear:both;">
	<strong>Инсталляция<span style="color:red"> ЗАВЕРШЕНА!</span></strong>
</div>
<div style="border:1px solid  #99CCFF; background:  #D9D9FF; padding:20px; margin:20px; clear:both;">
	<strong>Русская Редакция Fireboard 1.0 Joos</strong>
	<br/>
	<strong>Fireboard - компонент Форума для Joostina 1.3-1.4</strong><br/>
	Оригинал: &copy; 2007 <a href="http://www.bestofjoomla.com" target="_blank">Best Of Joomla</a><br/>
	Русская редакция: &copy; 2008 <a href="http://www.adeptsite.info" target="_blank">Adeptus</a><br/>
	Адаптация для Joostina: &copy; 2000-2012 <a href="mailto:illusive@bk.ru" target="_blank">Gold Dragon</a><br/>
</div>
</td>
</tr>
</table>
</div>
<?php
}

function dircopy($srcdir, $dstdir, $verbose = false){
	$num = 0;
	if(!is_dir($dstdir)){
		mkdir($dstdir);
		chmod($dstdir, 0777);
	}
	if($curdir = opendir($srcdir)){
		while($file = readdir($curdir)){
			if($file != '.' && $file != '..'){
				$srcfile = $srcdir . '/' . $file;
				$dstfile = $dstdir . '/' . $file;
				if(is_file($srcfile)){
					if(is_file($dstfile)){
						$ow = filemtime($srcfile) - filemtime($dstfile);
					} else{
						$ow = 1;
					}
					if($ow > 0){
						if($verbose){
							$tmpstr = 'Копирование: ';
							$tmpstr = str_replace('%src%', $srcfile, $tmpstr);
							$tmpstr = str_replace('%dst%', $dstfile, $tmpstr);
							echo "<li class=\"fbscslist\">" . $tmpstr;
						}
						if(copy($srcfile, $dstfile)){
							touch($dstfile, filemtime($srcfile));
							$num++;
							if($verbose){
								echo 'успешно </li>';
							}
						} else{
							echo "<li class=\"fbscslisterror\">Копирование каталога:" . $srcfile . " - ошибка!</li>";
						}
					}
				} else if(is_dir($srcfile)){
					$num += dircopy($srcfile, $dstfile, $verbose);
				}
			}
		}
		closedir($curdir);
	}
	return $num;
}

?>