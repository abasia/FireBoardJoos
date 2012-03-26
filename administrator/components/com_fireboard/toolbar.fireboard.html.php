<?php
/**
 * @version $Id: toolbar.fireboard.html.php 462 2007-12-10 00:05:53Z fxstein $
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
class TOOLBAR_simpleBoard{
	public static function _ADMIN(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::addNew();
		mosMenuBar::spacer();
		mosMenuBar::publish();
		mosMenuBar::spacer();
		mosMenuBar::unpublish();
		mosMenuBar::spacer();
		mosMenuBar::editList();
		mosMenuBar::spacer();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function _EDIT(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::unpublish('removemoderator');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function _NEWMOD_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::publish('addmoderator');
		mosMenuBar::spacer();
		mosMenuBar::unpublish('removemoderator');
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function _EDIT_CONFIG(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save('saveconfig');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function _EDITUSER_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save('saveuserprofile');
		mosMenuBar::spacer();
		mosMenuBar::cancel('showprofiles', 'Назад');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function _PROFILE_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::custom('userprofile', 'edit.png', 'edit_f2.png', 'Изменить');
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function CSS_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save('saveeditcss');
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function _PRUNEFORUM_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::spacer();
		mosMenuBar::custom('doprune', 'delete.png', 'delete_f2.png', 'Очистить', false);
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function _SYNCUSERS_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::custom('douserssync', 'delete.png', 'delete_f2.png', 'Старт', false);
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function BACKONLY_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	public static function DEFAULT_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	public static function _SHOWSMILEY_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::addNew('newsmiley', 'Новый');
		mosMenuBar::spacer();
		mosMenuBar::custom('editsmiley', 'edit.png', 'edit_f2.png', 'Изменить');
		mosMenuBar::spacer();
		mosMenuBar::custom('deletesmiley', 'delete.png', 'delete_f2.png', 'Удалить');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	public static function _EDITSMILEY_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save('savesmiley');
		mosMenuBar::spacer();
		mosMenuBar::cancel('showsmilies');
		mosMenuBar::endTable();
	}

	public static function _NEWSMILEY_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save('savesmiley');
		mosMenuBar::spacer();
		mosMenuBar::cancel('showsmilies');
		mosMenuBar::endTable();
	}

	public static function _SHOWRANKS_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::addNew('newRank', 'Новый');
		mosMenuBar::spacer();
		mosMenuBar::custom('editRank', 'edit.png', 'edit_f2.png', 'Изменить');
		mosMenuBar::spacer();
		mosMenuBar::custom('deleteRank', 'delete.png', 'delete_f2.png', 'Удалить');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	public static function _SHOWGROUPS_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::custom('editGroup', 'edit.png', 'edit_f2.png', 'Изменить');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	public static function _EDITRANK_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save('saveRank');
		mosMenuBar::spacer();
		mosMenuBar::cancel('ranks');
		mosMenuBar::endTable();
	}

	public static function _NEWRANK_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save('saveRank');
		mosMenuBar::spacer();
		mosMenuBar::cancel('ranks');
		mosMenuBar::endTable();
	}

	public static function _SHOWRESTRICT_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::custom('editrestrictedUser', 'edit.png', 'edit_f2.png', 'Редакт.');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	public static function _SHOWRESTRICTUSER_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::addNew('newRestrictUser', 'Добавить');
		mosMenuBar::spacer();
		mosMenuBar::deleteList('', 'removerestrictedUser', 'Удалить');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	public static function _ADDRESTRICTEDUSER_MENU(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::save('saveRestrictedUser');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}
}
