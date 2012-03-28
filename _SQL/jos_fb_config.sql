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
('chat', '1'),
('chat_guests', '1'),
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
('imageSize', '500'),
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
