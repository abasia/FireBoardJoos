<?php
/**
 * @version $Id: class.fireboard.php 512 2007-12-18 22:15:28Z danialt $
 * Fireboard Component
 * @package Fireboard
 * @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.bestofjoomla.com
 *
 * Russian edition by Adeptus (c) 2007
 *
 */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
$Itemid = intval(mosGetParam($_REQUEST, 'Itemid'));
$mosConfig_absolute_path = FBJConfig::getCfg('absolute_path');
$mosConfig_live_site = FBJConfig::getCfg('live_site');
$fbConfig = FBJConfig::getInstance();

if(!defined("FB_FB_ITEMID")){
	if($Itemid < 1){
		$database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_fireboard' AND published = 1");
		$Itemid = $database->loadResult();
		if($Itemid < 1){
			$Itemid = 0;
		}
	}
	define("FB_FB_ITEMID", (int)$Itemid);
	define("FB_FB_ITEMID_SUFFIX", "&amp;Itemid=" . FB_FB_ITEMID);

	// UddeIM
	if($fbConfig->pm_component == 'uddeim'){
		$database->setQuery('SELECT id FROM #__menu WHERE link=`index.php?option=com_uddeim`');
		$UIM_itemid = $database->loadResult();
		define("FB_UIM_ITEMID", (int)$UIM_itemid);
		define("FB_UIM_ITEMID_SUFFIX", "&amp;Itemid=" . FB_UIM_ITEMID);
	}
	// MISSUS
	if($fbConfig->pm_component == 'missus'){
		$database->setQuery('SELECT id FROM #__menu WHERE link=`index.php?option=com_missus`');
		$MISSUS_itemid = $database->loadResult();
		define("FB_MISSUS_ITEMID", (int)$MISSUS_itemid);
		define("FB_MISSUS_ITEMID_SUFFIX", "&amp;Itemid=" . FB_MISSUS_ITEMID);
	}
	// Ссылка на профиль
	if($fbConfig->fb_profile == "joostina"){
		$profilelink = 'index.php?option=com_mypms&amp;task=showprofile&amp;user=';
		define("FB_PROFILE_LINK_SUFFIX", "index.php?option=com_mypms&amp;task=showprofile&amp;Itemid=" . FB_CPM_ITEMID . "&amp;user=");
	} else{
		$profilelink = 'index.php?option=com_fireboard&amp;func=fbprofile&amp;task=showprf&amp;userid=';
		define("FB_PROFILE_LINK_SUFFIX", "index.php?option=com_fireboard&amp;func=fbprofile&amp;task=showprf&amp;Itemid=" . FB_FB_ITEMID . "&amp;userid=");
	}
}
define('JB_JABSPATH', $mainframe->getCfg('absolute_path'));
// Joomla absolute path
define('JB_JLIVEURL', $mainframe->getCfg('live_site'));
// fireboard live url
define('JB_LIVEURL', JB_JLIVEURL . '/index.php?option=com_fireboard' . FB_FB_ITEMID_SUFFIX);
define('JB_CLEANLIVEURL', JB_JLIVEURL . '/index2.php?option=com_fireboard&amp;no_html=1' . FB_FB_ITEMID_SUFFIX);
define('JB_LIVEURLREL', 'index.php?option=com_fireboard' . FB_FB_ITEMID_SUFFIX);
define('JB_ABSPATH', JB_JABSPATH . '/components/com_fireboard');
// fireboard absolute path
define('JB_ABSSOURCESPATH', JB_ABSPATH . '/sources/');
// fireboard souces absolute path
define('JB_DIRECTURL', JB_JLIVEURL . '/components/com_fireboard');
// fireboard direct url
define('JB_URLSOURCESPATH', JB_DIRECTURL . '/sources/');
// fireboard sources url
define('JB_LANG', $mainframe->getCfg('lang'));
define('JB_ABSADMPATH', JB_JABSPATH . '/administrator/components/com_fireboard');
if(!defined("JB_JCSSURL")){
	$database->setQuery("SELECT template FROM #__templates_menu where client_id ='0'");
	$current_stylesheet = $database->loadResult();
	define('JB_JCSSURL', JB_JLIVEURL . '/templates/' . $current_stylesheet . '/css/template_css.css');
}
// fireboard uploaded files directory
define('FB_ABSUPLOADEDPATH', JB_JABSPATH . DS . 'images'.DS.'fbfiles');
define('FB_LIVEUPLOADEDPATH', JB_JLIVEURL . '/images/fbfiles');
// now continue with other paths
$fb_user_template = strval(mosGetParam($_COOKIE, 'fb_user_template', ''));
$fb_user_img_template = strval(mosGetParam($_COOKIE, 'fb_user_img_template', ''));
if(strlen($fb_user_template) > 0){
	$fb_cur_template = $fb_user_template;
} else{
	$fb_cur_template = $fbConfig->template;
}
if(strlen($fb_user_img_template) > 0){
	$fb_cur_img_template = $fb_user_img_template;
} else{
	$fb_cur_img_template = $fbConfig->templateimagepath;
}
define('JB_ABSTMPLTPATH', JB_ABSPATH . '/template/' . $fb_cur_template);
define('JB_ABSTMPLTMAINIMGPATH', JB_ABSPATH . '/template/' . $fbConfig->templateimagepath);
// IMAGES ABSOLUTE PATH
define('JB_ABSIMAGESPATH', JB_ABSTMPLTMAINIMGPATH . '/images/' . JB_LANG . '/');
// absolute images path
define('JB_ABSICONSPATH', JB_ABSIMAGESPATH . 'icons/');
// absolute icons path
define('JB_ABSEMOTIONSPATH', JB_ABSIMAGESPATH . 'emoticons/');
// absolute emoticons path
define('JB_ABSGRAPHPATH', JB_ABSIMAGESPATH . 'graph/');
// absolute graph path
define('JB_ABSRANKSPATH', JB_ABSIMAGESPATH . 'ranks/');
// absolute ranks path
define('JB_ABSCATIMAGESPATH', FB_ABSUPLOADEDPATH . '/' . $fbConfig->CatImagePath);
define('JB_TMPLTURL', JB_DIRECTURL . '/template/' . $fb_cur_template);
define('JB_TMPLTMAINIMGURL', JB_DIRECTURL . '/template/' . $fb_cur_img_template);
// IMAGES URL PATH
define('JB_TMPLTCSSURL', JB_TMPLTURL . '/forum.css');
if(is_dir(JB_ABSTMPLTMAINIMGPATH . '/images/' . JB_LANG . '')){
	define('JB_URLIMAGESPATH', JB_TMPLTMAINIMGURL . '/images/' . JB_LANG . '/');
} else{
	define('JB_URLIMAGESPATH', JB_TMPLTMAINIMGURL . '/images/english/');
}
// url images path
define('JB_URLICONSPATH', JB_URLIMAGESPATH . 'icons/');
// url icons path
define('JB_URLEMOTIONSPATH', JB_URLIMAGESPATH . 'emoticons/');
// url emoticons path
define('JB_URLGRAPHPATH', JB_URLIMAGESPATH . 'graph/');
// url graph path
define('JB_URLRANKSPATH', JB_URLIMAGESPATH . 'ranks/');
// url ranks path
define('JB_URLCATIMAGES', FB_LIVEUPLOADEDPATH . '/' . $fbConfig->CatImagePath);
if(file_exists(JB_ABSTMPLTPATH . '/js/jquery-latest.pack.js')){
	define('JB_JQURL', JB_DIRECTURL . '/template/' . $fb_cur_template . '/js/jquery-latest.pack.js');
} else{
	define('JB_JQURL', JB_DIRECTURL . '/template/default/js/jquery-latest.pack.js');
}
if(file_exists(JB_ABSTMPLTPATH . '/js/bojForumCore.js')){
	define('JB_COREJSURL', JB_DIRECTURL . '/template/' . $fb_cur_template . '/js/bojForumCore.js');
} else{
	define('JB_COREJSURL', JB_DIRECTURL . '/template/default/js/bojForumCore.js');
}

function FB_fmodReplace($x, $y){
	$i = floor($x / $y);
	return $x - $i * $y;
}

function getFBGroupName($id){
	$database = FBJConfig::database();
	$gr = '';
	$database->setQuery("select id, title from #__fb_groups as g, #__fb_users as u where u.group_id = g.id and u.userid= $id");
	$database->loadObject($gr);
	//if ($gr->id > 1) {
	return $gr;
	//}
}

function escape_quotes($receive){
	if(!is_array($receive)){
		$thearray = array($receive);
	} else{
		$thearray = $receive;
	}
	foreach(array_keys($thearray) as $string){
		$thearray[$string] = addslashes($thearray[$string]);
		$thearray[$string] = preg_replace("/[\\/]+/", "/", $thearray[$string]);
	}
	if(!is_array($receive)){
		return $thearray[0];
	} else{
		return $thearray;
	}
}

class FBTools{
	var $id = null;

	public static function fbGetInternalTime($time = null){
		$fbConfig = FBJConfig::getInstance();
		if($time === 0){
			return 0;
		}
		if($time === null){
			$time = time();
		}
		return $time + ($fbConfig->board_ofset * 3600);
	}

	public static function fbGetShowTime($time = null, $space = 'FB'){
		$fbConfig = FBJConfig::getInstance();
		if($time === 0){
			return 0;
		}
		if($time === null){
			$time = FBTools::fbGetInternalTime();
			$space = 'FB';
		}
		if($space == 'UTC'){
			return $time + ($fbConfig->board_ofset * 3600);
		}
		return $time;
	}

	public static function whoisID($id){
		$database = FBJConfig::database();
		$id = intval($database->getEscaped($id));
		$database->setQuery("select username from #__users where id=$id");
		return $database->loadResult();
	}

	function reCountBoards(){
		$database = FBJConfig::database();
		include_once (JB_ABSSOURCESPATH . 'fb_db_iterator.class.php');
		$database->setQuery("UPDATE #__fb_categories SET id_last_msg='0', time_last_msg='0', numTopics='0', numPosts ='0'");
		$database->query();
		$database->setQuery("select id, time, parent, catid from #__fb_messages order by id asc");
		$messages_iter = new fb_DB_Iterator($database);
		$database->setQuery("select id, parent, numTopics, numPosts,id_last_msg, time_last_msg from #__fb_categories order by id asc");
		$cats = $database->loadObjectList();
		foreach($cats as $c){
			$ctg[$c->id] = $c;
		}
		$i = 0;
		while($messages_iter->loadNextObject($l)){
			$i++;
			$cat_l = $l->catid;
			while($cat_l){
				if($l->parent == 0){
					$ctg[$cat_l]->numTopics++;
				} else{
					$ctg[$cat_l]->numPosts++;
				}
				$ctg[$cat_l]->id_last_msg = $l->id;
				$ctg[$cat_l]->time_last_msg = $l->time;
				$cat_l = $ctg[$cat_l]->parent;
			}
		}
		foreach($ctg as $cc){
			$database->setQuery("UPDATE `#__fb_categories` SET `time_last_msg`='" . $cc->time_last_msg . "',`id_last_msg`='" . $cc->id_last_msg . "',`numTopics`='" . $cc->numTopics . "',`numPosts`='" . $cc->numPosts . "' WHERE (`id`='" . $cc->id . "') ");
			$database->query();
			echo $database->getErrorMsg();
		}
		$messages_iter->Free();
	}

	public static function modifyCategoryStats($msg_id, $msg_parent, $msg_time, $msg_cat){
		$database = FBJConfig::database();
		$database->setQuery("select id, parent, numTopics, numPosts,id_last_msg, time_last_msg from #__fb_categories order by id asc");
		$cats = $database->loadObjectList();
		foreach($cats as $c){
			$ctg[$c->id] = $c;
		}
		while($msg_cat){
			if($msg_parent == 0){
				$ctg[$msg_cat]->numTopics++;
			} else{
				$ctg[$msg_cat]->numPosts++;
			}
			$ctg[$msg_cat]->id_last_msg = $msg_id;
			$ctg[$msg_cat]->time_last_msg = $msg_time;
			$database->setQuery("UPDATE `#__fb_categories`" . " SET `time_last_msg`='" . $ctg[$msg_cat]->time_last_msg . "'" . ",`id_last_msg`='" . $ctg[$msg_cat]->id_last_msg . "'" . ",`numTopics`='" . $ctg[$msg_cat]->numTopics . "'" . ",`numPosts`='" . $ctg[$msg_cat]->numPosts . "'" . " WHERE (`id`='" . $ctg[$msg_cat]->id . "') ");
			$database->query();
			echo $database->getErrorMsg();
			$msg_cat = $ctg[$msg_cat]->parent;
		}
		return;
	}

	public static function decreaseCategoryStats($msg_id, $msg_cat){
		$database = FBJConfig::database();
		$database->setQuery("select id, parent, numTopics, numPosts,id_last_msg, time_last_msg from #__fb_categories order by id asc");
		$cats = $database->loadObjectList();
		foreach($cats as $c){
			$ctg[$c->id] = $c;
		}
		$database->setQuery('select id FROM #__fb_messages WHERE id=' . $msg_id . ' OR thread=' . $msg_id);
		$msg_ids = $database->loadResultArray();
		$cntTopics = 0;
		$cntPosts = 0;
		if(count($msg_ids) > 0){
			foreach($msg_ids as $msg){
				if($msg == $msg_id){
					$cntTopics = 1;
				} else{
					$cntPosts++;
				}
			}
		}
		while($msg_cat){
			unset($lastMsgInCat);
			$database->setQuery("select id, time from #__fb_messages where catid={$msg_cat} and (thread <> {$msg_id} AND id<>{$msg_id}) order by time desc limit 1;");
			$database->loadObject($lastMsgInCat);
			$ctg[$msg_cat]->numTopics = (int)($ctg[$msg_cat]->numTopics - $cntTopics);
			$ctg[$msg_cat]->numPosts = (int)($ctg[$msg_cat]->numPosts - $cntPosts);
			$ctg[$msg_cat]->id_last_msg = $lastMsgInCat->id;
			$ctg[$msg_cat]->time_last_msg = $lastMsgInCat->time;
			$msg_cat = $ctg[$msg_cat]->parent;
		}
		foreach($ctg as $cc){
			$database->setQuery("UPDATE `#__fb_categories` SET `time_last_msg`='" . $cc->time_last_msg . "',`id_last_msg`='" . $cc->id_last_msg . "',`numTopics`='" . $cc->numTopics . "',`numPosts`='" . $cc->numPosts . "' WHERE `id`='" . $cc->id . "' ");
			$database->query();
			echo $database->getErrorMsg();
		}
		return;
	}

	public static function showBulkActionCats($disabled = 1){
		$options = array();
		$options[] = mosHTML::makeOption('0', "&nbsp;");
		$lists['parent'] = FB_GetAvailableForums(0, "", $options, $disabled);
		echo $lists['parent'];
	}

	public static function fbDeletePosts($isMod, $return){
		$database = FBJConfig::database();
		if(!FBTools::isModOrAdmin() && !$isMod){
			return;
		}
		$items = fbGetArrayInts("fbDelete");
		$dellattach = 1;
		foreach($items as $id => $value){
			$database->setQuery('SELECT id,catid,parent,thread,subject,userid FROM #__fb_messages WHERE id=' . $id);
			if(!$database->query()){
				return -2;
			}
			$database->loadObject($mes);
			$thread = $mes->thread;
			if($mes->parent == 0){
				$database->setQuery('DELETE FROM #__fb_polls WHERE threadid=' . $thread);
				$database->query();
				$database->setQuery('DELETE FROM #__fb_pollsotvet WHERE poll_id=' . $thread);
				$database->query();
				$database->setQuery('DELETE FROM #__fb_pollsresults WHERE threadid=' . $thread);
				$database->query();
				$children = array();
				$userids = array();
				$database->setQuery('SELECT userid,id, catid FROM #__fb_messages WHERE thread=' . $id . ' OR id=' . $id);
				foreach($database->loadObjectList() as $line){
					$children[] = $line->id;
					if($line->userid > 0){
						$userids[] = $line->userid;
					}
				}
				$children = implode(',', $children);
				$userids = implode(',', $userids);
			} else{
				$database->setQuery('UPDATE #__fb_messages SET parent=\'' . $mes->parent . '\' WHERE parent=\'' . $id . '\'');
				if(!$database->query()){
					return -1;
				}
				$children = $id;
				$userids = $mes->userid > 0 ? $mes->userid : '';
			}
			$database->setQuery('DELETE FROM #__fb_messages WHERE id=' . $id . ' OR thread=' . $id);
			if(!$database->query()){
				return -2;
			}
			FBTools::decreaseCategoryStats($id, $mes->catid);
			$database->setQuery('DELETE FROM #__fb_messages_text WHERE mesid IN (' . $children . ')');
			if(!$database->query()){
				return -3;
			}
			if(count($userids) > 0){
				$database->setQuery('UPDATE #__fb_users SET posts=posts-1 WHERE userid IN (' . $userids . ')');
				if(!$database->query()){
					return -4;
				}
			}
			$database->setQuery('SELECT mesid FROM #__fb_messages_text WHERE message=\'catid=' . $mes->catid . '&amp;id=' . $id . '\'');
			$int_ghost_id = $database->loadResult();
			if($int_ghost_id > 0){
				$database->setQuery('DELETE FROM #__fb_messages WHERE id=' . $int_ghost_id);
				$database->query();
				$database->setQuery('DELETE FROM #__fb_messages_text WHERE mesid=' . $int_ghost_id);
				$database->query();
			}
			if($dellattach){
				$database->setQuery('SELECT filelocation FROM #__fb_attachments WHERE mesid IN (' . $children . ')');
				$fileList = $database->loadObjectList();
				if(count($fileList) > 0){
					foreach($fileList as $fl){
						unlink($fl->filelocation);
					}
					$database->setQuery('DELETE FROM #__fb_attachments WHERE mesid IN (' . $children . ')');
					$database->query();
				}
			}
		}
		mosRedirect($return, _FB_BULKMSG_DELETED);
	}

	public static function isModOrAdmin($id = 0){
		$database = FBJConfig::database();
		$my = FBJConfig::my();
		$userid = intval($id);
		if($userid){
			$user = new mosUser($database);
			$user->load($userid);
		} else{
			$user = $my;
		}
		if(strtolower($user->usertype) == 'super administrator' || strtolower($user->usertype) == 'administrator'){
			return true;
		} else{
			return false;
		}
	}

	public static function fbMovePosts($catid, $isMod, $return){
		$database = FBJConfig::database();
		if(!FBTools::isModOrAdmin() && !$isMod){
			return;
		}
		$items = fbGetArrayInts("fbDelete");
		foreach($items as $id => $value){
			$catid = (int)$catid;
			$id = (int)$id;
			$database->setQuery("SELECT `subject`, `catid`, `time` AS timestamp FROM #__fb_messages WHERE `id`=" . $id);
			$oldRecord = $database->loadObjectList();
			$newSubject = _MOVED_TOPIC . " " . $oldRecord[0]->subject;
			$database->setQuery("SELECT MAX(time) AS timestamp FROM #__fb_messages WHERE `thread`=" . $id);
			$lastTimestamp = $database->loadResult();
			if($lastTimestamp == ""){
				$lastTimestamp = $oldRecord[0]->timestamp;
			}
			$database->setQuery("UPDATE #__fb_messages SET `catid`='$catid' WHERE `id`='$id'");
			if($database->query()){
				$database->setQuery("UPDATE #__fb_messages set `catid`='$catid' WHERE `thread`='$id'");
				if(!$database->query()){
					$err = "Severe database error. Update your database manually so the replies to the topic are matched to the new forum as well";
				}
			} else{
				$err = _POST_TOPIC_NOT_MOVED;
			}
		}
		mosRedirect($return, $err ? $err : _POST_SUCCESS_MOVE);
	}

	public static function isJoomla15(){
		$mainframe = FBJConfig::mainframe();
		return is_dir($mainframe->getCfg("absolute_path") . "/libraries/");
	}

	public static function fbRemoveXSS($val, $reverse = 0){
		$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
		$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
		$ra = array_merge($ra1, $ra2);
		$ra2 = $ra;
		array_walk($ra2, "fbReturnDashed");
		if($reverse){
			$val = str_ireplace($ra2, $ra, $val);
		} else{
			$val = str_ireplace($ra, $ra2, $val);
		}
		return $val;
	}
}

/**
 * Users Table Class
 * Provides access to the #__fb_users table
 */
class fbUserprofile extends mosDBTable{
	var $userid = null;
	var $view = null;
	var $signature = null;
	var $moderator = null;
	var $ordering = null;
	var $posts = null;
	var $avatar = null;
	var $karma = null;
	var $karma_time = null;
	var $group_id = null;
	var $uhits = null;
	var $personalText = null;
	var $gender = null;
	var $birthdate = null;
	var $location = null;
	var $ICQ = null;
	var $AIM = null;
	var $YIM = null;
	var $MSN = null;
	var $SKYPE = null;
	var $GTALK = null;
	var $websitename = null;
	var $websiteurl = null;
	var $hideEmail = null;
	var $showOnline = null;

	function fbUserprofile(&$database){
		$this->mosDBTable('#__fb_users', 'userid', $database);
	}
}

/**
 * Moderator Table Class
 */
class fbModeration extends mosDBTable{
	/** @var int Unique id*/
	var $catid = null;
	/** @var int */
	var $userid = null;
	/** @var int */
	var $future1 = null;
	/** @var int */
	var $future2 = null;

	function fbModeration(&$database){
		$this->mosDBTable('#__fb_moderation', 'catid', $database);
	}
}

class fbForum extends mosDBTable{
	/** @var int Unique id*/
	var $id = null;
	/** @var string */
	var $parent = null;
	/** @var string */
	var $name = null;
	var $cat_emoticon = null;
	var $locked = null;
	var $alert_admin = null;
	var $moderated = null;
	var $pub_access = null;
	var $pub_recurse = null;
	var $admin_access = null;
	var $admin_recurse = null;
	var $public = null;
	var $ordering = null;
	var $future2 = null;
	var $published = true;
	var $checked_out = null;
	var $checked_out_time = null;
	var $review = null;
	var $hits = null;
	var $description = null;
	//var $class_sfx = null;
	var $headerdesc = null;

	function fbForum(&$database){
		$this->mosDBTable('#__fb_categories', 'id', $database);
	}
}

function JJ_categoryArray($admin = 0){
	$database = FBJConfig::database();
	$query = "SELECT c.*, c.parent" . "\n FROM #__fb_categories c";
	if(!$admin){
		$query .= "\n WHERE published =1 " . "\n AND ( pub_access = 0" // this will wait till a better session management system comes
			//.($fbSession?" || id IN ($fbSession->allowed)":"")
			. " ) ";
	}
	$query .= "\n ORDER BY ordering, name";
	$database->setQuery($query);
	$items = $database->loadObjectList();
	$children = array();
	foreach($items as $v){
		$pt = $v->parent;
		$list = @$children[$pt] ? $children[$pt] : array();
		array_push($list, $v);
		$children[$pt] = $list;
	}
	$array = fbTreeRecurse(0, '', array(), $children, 10, 0, 1);
	return $array;
}

function fbTreeRecurse($id, $indent, $list, &$children, $maxlevel = 9999, $level = 0, $type = 1){
	if(@$children[$id] && $level <= $maxlevel){
		foreach($children[$id] as $v){
			$id = $v->id;
			if($type){
				$pre = '&nbsp;';
				$spacer = '...';
			} else{
				$pre = '- ';
				$spacer = '&nbsp;&nbsp;';
			}
			if($v->parent == 0){
				$txt = $v->name;
			} else{
				$txt = $pre . $v->name;
			}
			$pt = $v->parent;
			$list[$id] = $v;
			$list[$id]->treename = "$indent$txt";
			$list[$id]->children = count(@$children[$id]);
			$list = fbTreeRecurse($id, $indent . $spacer, $list, $children, $maxlevel, $level + 1, $type);
		}
	}
	return $list;
}

function JJ_categoryParentList($catid, $action, $options = array()){
	$list = JJ_categoryArray();
	$this_treename = '';
	foreach($list as $item){
		if($this_treename){
			if($item->id != $catid && strpos($item->treename, $this_treename) === false){
				$options[] = mosHTML::makeOption($item->id, $item->treename);
			}
		} else{
			if($item->id != $catid){
				$options[] = mosHTML::makeOption($item->id, $item->treename);
			} else{
				$this_treename = "$item->treename/";
			}
		}
	}
	$parent = mosHTML::selectList($options, 'catid', 'class="inputbox fbs" size="1"  onchange = "if(this.options[this.selectedIndex].value > 0){ forms[\'jumpto\'].submit() }"', 'value', 'text', $catid);
	return $parent;
}

function FB_GetAvailableForums($catid, $action, $options = array(), $disabled, $multiple = 0){
	$list = JJ_categoryArray();
	$this_treename = '';
	foreach($list as $item){
		if($this_treename){
			if($item->id != $catid && strpos($item->treename, $this_treename) === false){
				$options[] = mosHTML::makeOption($item->id, $item->treename);
			}
		} else{
			if($item->id != $catid){
				$options[] = mosHTML::makeOption($item->id, $item->treename);
			} else{
				$this_treename = "$item->treename/";
			}
		}
	}
	$parent = mosHTML::selectList($options, 'catid', 'class="inputbox fbs" ' . ($multiple ? ' size="5" MULTIPLE ' : ' size="1" ') . ' id="FB_AvailableForums" ' . ($disabled ? " disabled " : ""), 'value', 'text', $catid);
	return $parent;
}

//
//Begin Smilies mod
//
function generate_smilies(){
	$database = FBJConfig::database();
	$inline_columns = 4;
	$inline_rows = 5;
	$database->setQuery("SELECT code, location, emoticonbar FROM #__fb_smileys ORDER BY id");
	if($database->query()){
		$num_smilies = 0;
		$rowset = array();
		$set = $database->loadAssocList();
		$num_iconbar = 0;
		foreach($set as $smilies){
			$key_exists = false;
			foreach($rowset as $check){
				if($check['location'] == $smilies['location']){
					$key_exists = true;
				}
			}
			if($key_exists == false){
				$rowset[] = array('code' => $smilies['code'], 'location' => $smilies['location'], 'emoticonbar' => $smilies['emoticonbar']);
			}

			if($smilies['emoticonbar'] == 1){
				$num_iconbar++;
			}
		}
		$num_smilies = count($rowset);
		if($num_smilies){
			$smilies_count = min(20, $num_smilies);
			$smilies_split_row = $inline_columns - 1;
			$s_colspan = 0;
			$row = 0;
			$col = 0;
			reset($rowset);
			if(file_exists(JB_ABSPATH . '/template/default/plugin/emoticons/emoticons.js.php')){
				include (JB_ABSPATH . '/template/default/plugin/emoticons/emoticons.js.php');
				reset($rowset);
			} else{
				die ("file is missing: " . JB_ABSPATH . '/template/default/plugin/emoticons/emoticons.js.php');
			}
			$cur = 0;
			foreach($rowset as $data){
				if($data['emoticonbar'] == 1){
					$cur++;
					if(!($cur > $inline_rows * $inline_columns)){
						if(!$col){
							echo '<tr align="center" valign="middle">' . "\n";
						}
						echo '<td onclick="javascript:emo(\'' . $data['code'] . ' \')" style="cursor:pointer"><img class="btnImage" src="' . JB_URLEMOTIONSPATH . $data['location'] . '" border="0" alt="' . $data['code'] . ' " title="' . $data['code'] . ' " /></td>' . "\n";
						$s_colspan = max($s_colspan, $col + 1);
						if($col == $smilies_split_row){
							$col = 0;
							$row++;
							echo "</tr>\n";
						} elseif($cur == $num_iconbar && $s_colspan !== 0){
							echo "<td colspan=\"" . $s_colspan . "\"></td></tr>";
						} else{
							$col++;
						}
					}
				}
			}
			if($num_smilies > $inline_rows * $inline_columns){
				echo "<tr><td align=\"center\" class=\"moresmilies\" colspan=\"" . $inline_columns . "\" onclick=\"javascript:moreForumSmileys();\" style=\"cursor:pointer\"><b>" . _FB_EMOTICONS_MORE_SMILIES . "</b></td></tr>";
			}
		}
	}
}

function fbGetArrayInts($name, $type = NULL){
	if($type == NULL){
		$type = $_POST;
	}
	$array = mosGetParam($type, $name, array(0));
	mosArrayToInts($array);
	if(!is_array($array)){
		$array = array(0);
	}
	return $array;
}

function time_since($older_date, $newer_date){
	$chunks = array(array(60 * 60 * 24 * 365, _FB_DATE_YEAR, _FB_DATE_YEARS), array(60 * 60 * 24 * 30, _FB_DATE_MONTH, _FB_DATE_MONTHS), array(60 * 60 * 24 * 7, _FB_DATE_WEEK, _FB_DATE_WEEKS), array(60 * 60 * 24, _FB_DATE_DAY, _FB_DATE_DAYS), array(60 * 60, _FB_DATE_HOUR, _FB_DATE_HOURS), array(60, _FB_DATE_MINUTE, _FB_DATE_MINUTES),);
	$since = $newer_date - $older_date;
	if($since <= 0){
		return '?';
	}
	for($i = 0, $j = count($chunks); $i < $j; $i++){
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];
		$names = $chunks[$i][2];
		if(($count = floor($since / $seconds)) != 0){
			break;
		}
	}
	$output = ($count == 1) ? '1 ' . $name : $count . ' ' . $names;
	if($i + 1 < $j){
		$seconds2 = $chunks[$i + 1][0];
		$name2 = $chunks[$i + 1][1];
		$names2 = $chunks[$i + 1][2];
		if(($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0){
			$output .= ($count2 == 1) ? ', 1 ' . $name2 : ', ' . $count2 . ' ' . $names2;
		}
	}
	return $output;
}

function make_pattern(&$pat, $key){
	$pat = '/' . preg_quote($pat, '/') . '/i';
}

if(!function_exists('str_ireplace')){
	function str_ireplace($search, $replace, $subject){
		if(is_array($search)){
			array_walk($search, 'make_pattern');
		} else{
			$search = '/' . preg_quote($search, '/') . '/i';
		}
		return preg_replace($search, $replace, $subject);
	}
}
function fbReturnDashed(&$string, $key){
	$string = "_" . $string . "_";
}
