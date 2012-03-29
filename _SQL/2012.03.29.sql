-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Мар 29 2012 г., 08:11
-- Версия сервера: 5.1.61
-- Версия PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yarbb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_announcement`
--

CREATE TABLE IF NOT EXISTS `jos_fb_announcement` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `sdescription` text NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` tinyint(4) NOT NULL DEFAULT '0',
  `showdate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_attachments`
--

CREATE TABLE IF NOT EXISTS `jos_fb_attachments` (
  `mesid` int(11) NOT NULL DEFAULT '0',
  `filelocation` text NOT NULL,
  KEY `mesid` (`mesid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_categories`
--

CREATE TABLE IF NOT EXISTS `jos_fb_categories` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `jos_fb_categories`
--

INSERT INTO `jos_fb_categories` (`id`, `parent`, `name`, `cat_emoticon`, `locked`, `alert_admin`, `moderated`, `moderators`, `pub_access`, `pub_recurse`, `admin_access`, `admin_recurse`, `ordering`, `future2`, `published`, `checked_out`, `checked_out_time`, `review`, `hits`, `description`, `headerdesc`, `class_sfx`, `id_last_msg`, `numTopics`, `numPosts`, `time_last_msg`) VALUES
(8, 0, 'Администрация', 0, 0, 0, 1, NULL, 0, 1, 0, 1, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '', '', '', 7, 1, 5, 1332942326),
(9, 8, 'Работа сайта', 0, 0, 0, 1, NULL, 0, 1, 0, 1, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '', '', '', 7, 1, 5, 1332942326),
(10, 9, 'что-то такое', 0, 0, 0, 1, NULL, 0, 1, 0, 1, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '', '', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_config`
--

CREATE TABLE IF NOT EXISTS `jos_fb_config` (
  `name` varchar(200) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `jos_fb_config`
--

INSERT INTO `jos_fb_config` (`name`, `value`) VALUES
('allowAvatar', '1'),
('allowAvatarGallery', '1'),
('allowAvatarUpload', '1'),
('allowfavorites', '1'),
('allowFileRegUpload', '1'),
('allowFileUpload', '1'),
('allowImageRegUpload', '1'),
('allowImageUpload', '1'),
('allowsubscriptions', '1'),
('AnnModId', '62'),
('askemail', '0'),
('attach_guests', '1'),
('avatarHeight', '100'),
('avatarLargeHeight', '250'),
('avatarLargeWidth', '250'),
('avatarOnCat', '1'),
('avatarQuality', '75'),
('avatarSize', '100'),
('avatarSmallHeight', '50'),
('avatarSmallWidth', '50'),
('avatarWidth', '100'),
('avatar_src', 'fb'),
('badwords', '0'),
('board_offline', '0'),
('board_ofset', '0'),
('board_title', 'Форум'),
('captcha', '1'),
('CatImagePath', 'category_images/'),
('cb_profile', '0'),
('changename', '0'),
('default_view', 'flat'),
('discussBot', '0'),
('disemoticons', '0'),
('editMarkUp', '1'),
('email', 'change@me.com'),
('enableForumJump', '1'),
('enableHelpPage', '1'),
('enablePDF', '1'),
('enableRSS', '1'),
('enableRulesPage', '1'),
('fb_profile', 'fb'),
('fileSize', '1024'),
('fileTypes', 'zip,txt,doc,rar'),
('floodprotection', '0'),
('help_cid', '1'),
('help_infb', '1'),
('help_link', ''),
('historyLimit', '6'),
('imageHeight', '800'),
('imageProcessor', 'gd2'),
('imageSize', '100'),
('imageWidth', '1024'),
('jmambot', '1'),
('joomlaStyle', '0'),
('latestCategory', ''),
('latestCount', '10'),
('latestCountPerPage', '5'),
('latestReplySubject', '1'),
('latestShowAuthor', '1'),
('latestShowDate', '1'),
('latestShowHits', '1'),
('latestSingleSubject', '1'),
('latestSubjectLength', '100'),
('mailadmin', '0'),
('mailfull', '0'),
('mailmod', '0'),
('maxSig', '300'),
('maxSubject', '50'),
('messages_per_page', '6'),
('messages_per_page_search', '15'),
('newChar', 'NEW!'),
('numchildcolumn', '2'),
('offline_message', '<h2>Форум временно закрыт.</h2><br/>Зайдите позже!'),
('pm_component', 'no'),
('pollmax', '5'),
('polls', '1'),
('PopSubjectCount', '10'),
('PopUserCount', '10'),
('postStats', '1'),
('pubwrite', '0'),
('rankimages', '1'),
('re', '0'),
('regonly', '0'),
('reportmsg', '1'),
('rteheight', '300'),
('rtewidth', '450'),
('rules_cid', '1'),
('rules_infb', '1'),
('rules_link', ''),
('showAnnouncement', '1'),
('showChildCatIcon', '1'),
('showemail', '1'),
('showGenStats', '1'),
('showHistory', '1'),
('showkarma', '1'),
('showLatest', '1'),
('showNew', '1'),
('showPopSubjectStats', '1'),
('showPopUserStats', '1'),
('showranking', '1'),
('showStats', '1'),
('showWhoisOnline', '1'),
('statsColor', '12'),
('subscriptionschecked', '1'),
('template', 'default'),
('templateimagepath', 'default'),
('threads_per_page', '20'),
('useredit', '1'),
('usereditTime', '0'),
('usereditTimeGrace', '600'),
('userlist_avatar', '1'),
('userlist_email', '1'),
('userlist_group', '1'),
('userlist_joindate', '1'),
('userlist_karma', '1'),
('userlist_lastvisitdate', '1'),
('userlist_name', '1'),
('userlist_online', '1'),
('userlist_posts', '1'),
('userlist_rows', '30'),
('userlist_userhits', '1'),
('userlist_username', '1'),
('userlist_usertype', '1'),
('username', '1'),
('usernamechange', '1'),
('version', '2.0'),
('wrap', '250');

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_favorites`
--

CREATE TABLE IF NOT EXISTS `jos_fb_favorites` (
  `thread` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  KEY `thread` (`thread`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_groups`
--

CREATE TABLE IF NOT EXISTS `jos_fb_groups` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `jos_fb_groups`
--

INSERT INTO `jos_fb_groups` (`id`, `title`) VALUES
(1, 'Пользователи'),
(2, 'Администрация'),
(3, 'Модераторы'),
(4, 'Помощники'),
(5, 'Друзья'),
(6, 'V.I.P.'),
(7, 'Поддержка'),
(8, 'Команда');

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_messages`
--

CREATE TABLE IF NOT EXISTS `jos_fb_messages` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `jos_fb_messages`
--

INSERT INTO `jos_fb_messages` (`id`, `parent`, `thread`, `catid`, `name`, `userid`, `email`, `subject`, `time`, `ip`, `topic_emoticon`, `locked`, `hold`, `ordering`, `hits`, `moved`, `modified_by`, `modified_time`, `modified_reason`) VALUES
(2, 0, 2, 9, 'test', 63, 'test@test.ru', 'первая тема', 1331628844, '127.0.0.1', 1, 0, 0, 0, 39, 0, NULL, NULL, NULL),
(3, 2, 2, 9, 'admin', 62, 'mail@mail.ru', 'RE: первая тема', 1331629047, '127.0.0.1', 1, 0, 0, 0, 0, 0, NULL, NULL, NULL),
(4, 2, 2, 9, 'test', 63, 'test@test.ru', 'RE: первая тема', 1331631405, '127.0.0.1', 1, 0, 0, 0, 0, 0, NULL, NULL, NULL),
(5, 2, 2, 9, 'admin', 62, 'mail@mail.ru', 'RE: первая тема', 1332758174, '127.0.0.1', 1, 0, 0, 0, 0, 0, 62, 1332766392, 'Добавлено'),
(6, 2, 2, 9, 'admin', 62, 'mail@mail.ru', 'RE: первая тема', 1332910660, '127.0.0.1', 1, 0, 0, 0, 0, 0, 62, 1332925738, 'Добавлено'),
(7, 2, 2, 9, 'test', 63, 'test@test.ru', 'RE: первая тема', 1332942326, '127.0.0.1', 1, 0, 0, 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_messages_text`
--

CREATE TABLE IF NOT EXISTS `jos_fb_messages_text` (
  `mesid` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  PRIMARY KEY (`mesid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `jos_fb_messages_text`
--

INSERT INTO `jos_fb_messages_text` (`mesid`, `message`) VALUES
(1, 'Fireboard is fully integrated forum solution for joomla, no bridges, no hacking core files: It can be installed just like any other component with only a few clicks.\r\n\r\nThe administration backend is fully integrated, native ACL implemented, and it has all the capabilities one would have come to expect from a mature, full-fledged forum solution!'),
(2, 'первое сообщение'),
(3, 'второе сообщение'),
(4, ';) ;)'),
(5, ':side: :side:\n\n\n[b][i][u]Добавлено: 26-03-2012 16:52[/u][/i][/b]\n\nпвв[b]пп пв[/b]квпк впк пка\n\n\n[b][i][u]Добавлено: 26-03-2012 16:53[/u][/i][/b]\n\nава'),
(6, 'ываыв фыва asd asdf asd asdf\n\n\n[b][i][u]Добавлено: 28-03-2012 13:08[/u][/i][/b]\n\n:laugh:'),
(7, 'gfgfgf');

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_moderation`
--

CREATE TABLE IF NOT EXISTS `jos_fb_moderation` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `future1` tinyint(4) DEFAULT '0',
  `future2` int(11) DEFAULT '0',
  PRIMARY KEY (`catid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `jos_fb_moderation`
--

INSERT INTO `jos_fb_moderation` (`catid`, `userid`, `future1`, `future2`) VALUES
(8, 62, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_polls`
--

CREATE TABLE IF NOT EXISTS `jos_fb_polls` (
  `pollid` int(11) NOT NULL AUTO_INCREMENT,
  `threadid` varchar(11) NOT NULL DEFAULT '0',
  `avtorid` int(11) NOT NULL DEFAULT '0',
  `vopros` text,
  `closed` int(1) NOT NULL DEFAULT '0',
  KEY `pollid` (`pollid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_pollsotvet`
--

CREATE TABLE IF NOT EXISTS `jos_fb_pollsotvet` (
  `poll_id` int(11) NOT NULL DEFAULT '0',
  `pollotvet` text,
  KEY `poll_id` (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_pollsresults`
--

CREATE TABLE IF NOT EXISTS `jos_fb_pollsresults` (
  `answerid` int(11) NOT NULL AUTO_INCREMENT,
  `threadid` varchar(11) NOT NULL DEFAULT '0',
  `answeruserid` int(11) NOT NULL DEFAULT '0',
  `answer` int(1) NOT NULL,
  KEY `answerid` (`answerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_ranks`
--

CREATE TABLE IF NOT EXISTS `jos_fb_ranks` (
  `rank_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rank_title` varchar(255) NOT NULL DEFAULT '',
  `rank_min` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rank_special` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rank_image` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `jos_fb_ranks`
--

INSERT INTO `jos_fb_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_special`, `rank_image`) VALUES
(1, 'Fresh Boarder', 0, 0, 'rank1.gif'),
(2, 'Junior Boarder', 20, 0, 'rank2.gif'),
(3, 'Senior Boarder', 40, 0, 'rank3.gif'),
(4, 'Expert Boarder', 80, 0, 'rank4.gif'),
(5, 'Gold Boarder', 160, 0, 'rank5.gif'),
(6, 'Platinum Boarder', 320, 0, 'rank6.gif'),
(7, 'Administrator', 0, 1, 'rankadmin.gif'),
(8, 'Moderator', 0, 1, 'rankmod.gif'),
(9, 'Spammer', 0, 1, 'rankspammer.gif');

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_sessions`
--

CREATE TABLE IF NOT EXISTS `jos_fb_sessions` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `allowed` text,
  `lasttime` int(11) NOT NULL DEFAULT '0',
  `readtopics` text,
  `currvisit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `jos_fb_sessions`
--

INSERT INTO `jos_fb_sessions` (`userid`, `allowed`, `lasttime`, `readtopics`, `currvisit`) VALUES
(62, '8,9', 1332928978, '', 1332936463),
(63, 'na', 1332942775, '2', 1332994217);

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_smileys`
--

CREATE TABLE IF NOT EXISTS `jos_fb_smileys` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `code` varchar(12) NOT NULL DEFAULT '',
  `location` varchar(50) NOT NULL DEFAULT '',
  `greylocation` varchar(60) NOT NULL DEFAULT '',
  `emoticonbar` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Дамп данных таблицы `jos_fb_smileys`
--

INSERT INTO `jos_fb_smileys` (`id`, `code`, `location`, `greylocation`, `emoticonbar`) VALUES
(1, 'B)', 'cool.png', 'cool-grey.png', 1),
(2, ':(', 'sad.png', 'sad-grey.png', 1),
(3, ':)', 'smile.png', 'smile-grey.png', 1),
(4, ':-)', 'smile.png', 'smile-grey.png', 0),
(5, ':-(', 'sad.png', 'sad-grey.png', 0),
(6, ':laugh:', 'laughing.png', 'laughing-grey.png', 1),
(7, ':cheer:', 'cheerful.png', 'cheerful-grey.png', 1),
(8, ';)', 'wink.png', 'wink-grey.png', 1),
(9, ';-)', 'wink.png', 'wink-grey.png', 0),
(10, ':P', 'tongue.png', 'tongue-grey.png', 1),
(12, ':X', 'sick.png', 'sick-grey.png', 0),
(13, ':x', 'sick.png', 'sick-grey.png', 0),
(14, ':angry:', 'angry.png', 'angry-grey.png', 1),
(15, ':mad:', 'angry.png', 'angry-grey.png', 0),
(16, ':unsure:', 'unsure.png', 'unsure-grey.png', 1),
(17, ':ohmy:', 'shocked.png', 'shocked-grey.png', 1),
(18, ':huh:', 'wassat.png', 'wassat-grey.png', 1),
(19, ':dry:', 'ermm.png', 'ermm-grey.png', 1),
(20, ':ermm:', 'ermm.png', 'ermm-grey.png', 0),
(21, ':lol:', 'grin.png', 'grin-grey.png', 1),
(22, ':sick:', 'sick.png', 'sick-grey.png', 1),
(23, ':silly:', 'silly.png', 'silly-grey.png', 1),
(24, ':y32b4:', 'silly.png', 'silly-grey.png', 0),
(25, ':blink:', 'blink.png', 'blink-grey.png', 1),
(26, ':blush:', 'blush.png', 'blush-grey.png', 1),
(27, ':kiss:', 'kissing.png', 'kissing-grey.png', 1),
(28, ':rolleyes:', 'blink.png', 'blink-grey.png', 0),
(29, ':woohoo:', 'w00t.png', 'w00t-grey.png', 1),
(30, ':side:', 'sideways.png', 'sideways-grey.png', 1),
(31, ':S', 'dizzy.png', 'dizzy-grey.png', 1),
(32, ':s', 'dizzy.png', 'dizzy-grey.png', 0),
(33, ':evil:', 'devil.png', 'devil-grey.png', 1),
(34, ':whistle:', 'whistling.png', 'whistling-grey.png', 1),
(35, ':pinch:', 'pinch.png', 'pinch-grey.png', 1),
(36, ':p', 'tongue.png', 'tongue-grey.png', 0),
(37, ':D', 'laughing.png', 'laughing-grey.png', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_subscriptions`
--

CREATE TABLE IF NOT EXISTS `jos_fb_subscriptions` (
  `thread` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `future1` int(11) DEFAULT '0',
  KEY `thread` (`thread`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `jos_fb_subscriptions`
--

INSERT INTO `jos_fb_subscriptions` (`thread`, `userid`, `future1`) VALUES
(1, 62, 0),
(2, 63, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_users`
--

CREATE TABLE IF NOT EXISTS `jos_fb_users` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `jos_fb_users`
--

INSERT INTO `jos_fb_users` (`userid`, `view`, `signature`, `moderator`, `ordering`, `posts`, `avatar`, `karma`, `karma_time`, `group_id`, `uhits`, `personalText`, `gender`, `birthdate`, `location`, `ICQ`, `AIM`, `YIM`, `MSN`, `SKYPE`, `GTALK`, `websitename`, `websiteurl`, `rank`, `hideEmail`, `showOnline`, `ban`) VALUES
(62, 'flat', NULL, 1, 0, 4, 'gallery/butterfly.gif', 0, 1332924989, 2, 1, NULL, 0, '0001-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 0),
(63, 'flat', NULL, 0, 0, 3, '63.jpg', 0, 0, 1, 6, NULL, 0, '0001-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `jos_fb_whoisonline`
--

CREATE TABLE IF NOT EXISTS `jos_fb_whoisonline` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Дамп данных таблицы `jos_fb_whoisonline`
--

INSERT INTO `jos_fb_whoisonline` (`id`, `userid`, `time`, `item`, `what`, `func`, `do`, `task`, `link`, `userip`, `user`) VALUES
(34, 63, '1332994217', 0, 'RE: первая тема', 'view', '', '', '/index.php?option=com_fireboard&Itemid=4&func=view&catid=9&id=7', '127.0.0.1', 1),
(35, 63, '1332994217', 0, 'Главная', 'uploadavatar', '', '', '/index.php?option=com_fireboard&amp;Itemid=4&func=uploadavatar', '127.0.0.1', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
