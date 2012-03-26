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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `jos_fb_categories`
--

INSERT INTO `jos_fb_categories` (`id`, `parent`, `name`, `cat_emoticon`, `locked`, `alert_admin`, `moderated`, `moderators`, `pub_access`, `pub_recurse`, `admin_access`, `admin_recurse`, `ordering`, `future2`, `published`, `checked_out`, `checked_out_time`, `review`, `hits`, `description`, `headerdesc`, `class_sfx`, `id_last_msg`, `numTopics`, `numPosts`, `time_last_msg`) VALUES
(1, 0, 'Sample Board (Level 1 Category)', 0, 0, 0, 1, NULL, 0, 0, 0, 0, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 'Description for level 1 Category board.', '', '', 1, 1, 0, 1178882702),
(2, 1, 'Level 2 Category', 0, 0, 0, 0, NULL, 0, 0, 0, 0, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 'Level 2 Category description.', '', '', 1, 1, 0, 1178882702),
(3, 2, 'Level 3 Category A', 0, 0, 0, 1, NULL, 0, 0, 0, 0, 3, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '', '', '', 0, 0, 0, 0),
(4, 2, 'Level 3 Category B', 0, 0, 0, 1, NULL, 0, 0, 0, 0, 2, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '', '', '', 0, 0, 0, 0),
(5, 2, 'Level 3 Category C', 0, 0, 0, 1, NULL, 0, 0, 0, 0, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '', '', '', 0, 0, 0, 0),
(6, 1, 'Sample Locked Forum', 0, 1, 0, 1, NULL, 0, 0, 0, 0, 2, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 'Nobody, except Moderators and Admins can create new topics or replies in a locked forum (or move posts to it).', '', '', 0, 0, 0, 0),
(7, 1, 'Sample Review On Forum', 0, 0, 0, 1, NULL, 0, 0, 0, 0, 3, 0, 1, 0, '0000-00-00 00:00:00', 1, 0, 'Posts to be reviewed by Moderators prior to publishing them in this forum. This is useful in a Moderated forum only! If you set this without any Moderators specified, the Site Admin is solely responsible for approving/deleting submitted posts as these will be kept ''on hold''!', '', '', 0, 0, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `jos_fb_messages`
--

INSERT INTO `jos_fb_messages` (`id`, `parent`, `thread`, `catid`, `name`, `userid`, `email`, `subject`, `time`, `ip`, `topic_emoticon`, `locked`, `hold`, `ordering`, `hits`, `moved`, `modified_by`, `modified_time`, `modified_reason`) VALUES
(1, 0, 1, 2, 'bestofjoomla', 0, 'anonymous@forum.here', 'Sample Post', 1178882702, '127.0.0.1', 0, 0, 0, 0, 1, 0, 0, 0, '0');

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
(1, 'Fireboard is fully integrated forum solution for joomla, no bridges, no hacking core files: It can be installed just like any other component with only a few clicks.\r\n\r\nThe administration backend is fully integrated, native ACL implemented, and it has all the capabilities one would have come to expect from a mature, full-fledged forum solution!');

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
(62, 'na', 1301249161, '', 1332785178);

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
(62, 'flat', NULL, 1, 0, 0, NULL, 0, 0, 1, 0, NULL, 0, '0001-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `jos_fb_whoisonline`
--

INSERT INTO `jos_fb_whoisonline` (`id`, `userid`, `time`, `item`, `what`, `func`, `do`, `task`, `link`, `userip`, `user`) VALUES
(1, 0, '1332785097', 0, 'Главная', '', '', '', '/index.php?option=com_fireboard&Itemid=21', '127.0.0.1', 0),
(2, 62, '1332785178', 0, 'Главная', 'myprofile', 'userdetails', '', '/index.php?option=com_fireboard&Itemid=21&func=myprofile&do=userdetails', '127.0.0.1', 1);

