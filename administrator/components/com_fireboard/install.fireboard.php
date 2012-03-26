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
defined ('_VALID_MOS') or die('Direct Access to this location is not allowed.');
function com_install() {
	error_reporting (E_ERROR);
    global $database, $mainframe;
?>
    <style>
        .fbscs
        {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .fbscslist
        {
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
        .fbscslisterror
        {
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
    </style>
    <div style = "border:1px solid #ccc; background:#FBFBFB; padding:10px; text-align:left;margin:10px 0;">
        <table width = "100%" border = "0" cellpadding = "0" cellspacing = "0">
            <tr>
                <td width = "20%" valign = "top" style = "padding:10px;">
                    <a href = "index2.php?option=com_fireboard" title="Перейти к администрированию Форума"><img src = "components/com_fireboard/images/logo.gif" alt = "FireBoardRE" border = "0"></a>
                </td>
                <td width = "80%" valign = "top" style = "padding:10px;">
                    <div style = "clear:both; text-align:left; padding:0 20px;">
                        <ul class = "fbscs">
                            <?php
                            $database->setQuery("SELECT id FROM #__components WHERE admin_menu_link = 'option=com_fireboard'");
                            $id = $database->loadResult();
                            $database->setQuery("UPDATE #__components " . "SET admin_menu_img  = '../administrator/components/com_fireboard/images/fbmenu.png'" . ",   admin_menu_link = 'option=com_fireboard' " . "WHERE id='$id'");
                            $database->query();
                            $database->setQuery("UPDATE `#__fb_categories` SET `moderated` = '1';");
                            $database->query();
                            /*$database->setQuery("select from #__fb_attachments where filelocation like '%" . $mainframe->getCfg("absolute_path") . "%'");
                            $is_101_version = $database->loadResult();
                            if ($is_101_version)
							{
                                $database->setQuery("update #__fb_attachments set filelocation = replace(filelocation,'" . $mainframe->getCfg("absolute_path") . "/components/com_fireboard/uploaded','/images/fbfiles');");
                                if ($database->query())
								{
                                    print '<li class="fbscslist">Таблица вложений обновлена!</li>';
                                }
                                else
								{
                                    print '<li class="fbscslisterror">Таблица вложений НЕ обновлена!</li>';
                                }
                                $database->setQuery("update #__fb_messages_text set message=replace(message,'/components/com_fireboard/uploaded','/images/fbfiles');");
                                if ($database->query())
								{
                                    print '<li class="fbscslist">Таблица вложений обновлена!</li>';
                                }
                                else
								{
                                    print '<li class="fbscslist">Таблица вложений НЕ обновлена!</li>';
                                }
                            }
							$database->setQuery("DROP TABLE #__fb_ranks");
							$re = $database->query();
							$database->setQuery("CREATE TABLE IF NOT EXISTS `#__fb_ranks` (`rank_id` mediumint(8) unsigned NOT NULL auto_increment, `rank_title`  varchar(255) NOT NULL default '', `rank_min` mediumint(8) unsigned NOT NULL default '0', `rank_special` tinyint(1) unsigned NOT NULL default '0', `rank_image` varchar(255) NOT NULL default '', PRIMARY KEY (`rank_id`))");
							$re = $database->query();
							$database->setQuery("DELETE * FROM #__fb_ranks");
							$re = $database->query();
							$database->setQuery("INSERT INTO `#__fb_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_special`, `rank_image`) VALUES (1,'Ранг 1',0,0,'rank1.gif'), (2,'Ранг 2',20,0,'rank2.gif'), (3,'Ранг 3',40,0,'rank3.gif'), (4,'Ранг 4',80,0,'rank4.gif'), (5,'Ранг 5',160,0, 'rank5.gif'), (6, 'Ранг 6', 320, 0, 'rank6.gif'), (7, 'Администратор', 0, 1, 'rankadmin.gif'), (8, 'Модератор', 0, 1, 'rankmod.gif'), (9, 'Спамер', 0, 1, 'rankspammer.gif');");
							$re = $database->query();
							$database->setQuery("SELECT COUNT(*) FROM #__fb_users");
							$users = $database->loadResult();
							if ($users)
							{
								$database->setQuery("ALTER TABLE #__fb_users "
								."\n ADD `GTALK` varchar(50) default NULL,"
								."\n ADD `websitename` varchar(50) default NULL,"
								."\n ADD `websiteurl` varchar(50) default NULL,"
								."\n ADD `rank` tinyint(4) NOT NULL default '0'"
								);
								$re = $database->query();
							}
							else
							{
								$database->setQuery("DROP TABLE #__fb_users");
								$re = $database->query();
								$database->setQuery("CREATE TABLE IF NOT EXISTS `#__fb_users` (
								`userid` int(11) NOT NULL default '0',
								`view` varchar(8) NOT NULL default 'flat',
								`signature` text,
								`moderator` int(11) default '0',
								`ordering` int(11) default '0',
								`posts` int(11) default '0',
								`avatar` varchar(50) default NULL,
								`karma` int(11) default '0',
								`karma_time` int(11) default '0',
								`group_id` int(4) default '1',
								`uhits` int(11) default '0',
								`personalText` tinytext,
								`gender` tinyint(4) NOT NULL default '0',
								`birthdate` date NOT NULL default '0001-01-01',
								`location` varchar(50) default NULL,
								`ICQ` varchar(50) default NULL,
								`AIM` varchar(50) default NULL,
								`YIM` varchar(50) default NULL,
								`MSN` varchar(50) default NULL,
								`SKYPE` varchar(50) default NULL,
								`GTALK` varchar(50) default NULL,
								`websitename` varchar(50) default NULL,
								`websiteurl` varchar(50) default NULL,
								`rank` tinyint(4) NOT NULL default '0',
								`hideEmail` tinyint(1) NOT NULL default '1',
								`showOnline` tinyint(1) NOT NULL default '1',
								PRIMARY KEY  (`userid`),
								KEY `group_id` (`group_id`)
								) COLLATE cp1251_general_ci;");
								$re = $database->query();
							}
							$database->setQuery("CREATE TABLE IF NOT EXISTS `#__fb_polls` (`pollid` int(11) NOT NULL AUTO_INCREMENT, `threadid` VARCHAR( 11 ) DEFAULT '0' NOT NULL, `avtorid` int(11) NOT NULL default '0', `vopros` text, `closed` INT( 1 ) NOT NULL DEFAULT '0', KEY `pollid` (`pollid`)) COLLATE cp1251_general_ci;");
							$re=$database->query();
							$database->setQuery("CREATE TABLE IF NOT EXISTS `#__fb_pollsotvet` (`poll_id` int(11) DEFAULT '0' NOT NULL, `pollotvet` text, KEY `poll_id` (`poll_id`)) COLLATE cp1251_general_ci;");
							$re=$database->query();
							$database->setQuery("CREATE TABLE IF NOT EXISTS `jos_fb_pollsresults` (`answerid` int(11) NOT NULL AUTO_INCREMENT, `threadid` VARCHAR( 11 ) DEFAULT '0' NOT NULL, `answeruserid` int(11) DEFAULT '0' NOT NULL, `answer` INT( 1 ) NOT NULL, KEY `answerid` (`answerid`)) COLLATE cp1251_general_ci;");
							$re=$database->query();
					        $database->setQuery("alter table `#__fb_categories` add column `class_sfx` varchar(20) NOT NULL  after `headerdesc`, COMMENT='';");
							$database->query();*/
                            if (is_writable($mainframe->getCfg("absolute_path") ))
							{
                            	dircopy($mainframe->getCfg("absolute_path") . "/components/com_fireboard/_fbfiles_dist", $mainframe->getCfg("absolute_path") . "/images/fbfiles", false);
                             }
                                else {
                            ?>
                             <li class = "fbscslisterror">
                             	<div style = "border:1px solid  #FF6666; background: #FFCC99; padding:10px; text-align:left; margin:10px 0;">
                                <img src = 'images/publish_x.png' align = 'absmiddle'> Не удалось создать каталоги:
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
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                    <div style = "border:1px solid #FFCC99; background:#FFFFCC; padding:20px; margin:20px; clear:both;">
                        <strong>Инсталляция<span style="color:red"> УСПЕШНО ЗВЕРШЕНА!</span></strong>
					</div>
                    <div style = "border:1px solid  #99CCFF; background:  #D9D9FF; padding:20px; margin:20px; clear:both;">
                        <strong>Русская Редакция Fireboard 2.0</strong>
                        <br/>
                        <strong>Fireboard - компонент Форума для Joomla! 1.0.ХХ</strong><br/>
						Оригинал: &copy; 2007 <a href = "http://www.bestofjoomla.com" target = "_blank">Best Of Joomla</a><br/>
						Русская редакция: &copy; 2008 <a href = "http://www.adeptsite.info" target = "_blank">Adeptus</a><br/>
					</div>
                </td>
            </tr>
        </table>
    </div>
<?php
    }
function dircopy($srcdir, $dstdir, $verbose = false) {
    $num = 0;
    if (!is_dir($dstdir)) {
        mkdir ($dstdir);
        chmod ($dstdir, 0777);
    }
    if ($curdir = opendir($srcdir)) {
        while ($file = readdir($curdir)) {
            if ($file != '.' && $file != '..') {
                $srcfile = $srcdir . '/' . $file;
                $dstfile = $dstdir . '/' . $file;
                if (is_file($srcfile)) {
                    if (is_file($dstfile)) {
                        $ow = filemtime($srcfile) - filemtime($dstfile);
                    }
                    else {
                        $ow = 1;
                    }
                    if ($ow > 0) {
                        if ($verbose) {
                            $tmpstr = 'Копирование: ';
                            $tmpstr = str_replace('%src%', $srcfile, $tmpstr);
                            $tmpstr = str_replace('%dst%', $dstfile, $tmpstr);
                            echo "<li class=\"fbscslist\">".$tmpstr;
                        }
                        if (copy($srcfile, $dstfile)) {
                            touch($dstfile, filemtime($srcfile));
                            $num++;
                            if ($verbose) {
                                echo 'успешно </li>';
                            }
                        }
                        else {
                            echo "<li class=\"fbscslisterror\">Копирование каталога:".$srcfile." - ошибка!</li>";
                        }
                    }
                }
                else if (is_dir($srcfile)) {
                    $num += dircopy($srcfile, $dstfile, $verbose);
                }
            }
        }
        closedir ($curdir);
    }
    return $num;
}
?>