<?php
/**
 * @version $Id: fireboard.php 512 2007-12-18 22:15:28Z danialt $
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
 * @modification Gold Dragon 27.03.2012
 **/
defined('_VALID_MOS') or die();

$mtime = explode(" ", microtime());
$tstart = $mtime[1] + $mtime[0];
error_reporting(E_ALL ^ E_NOTICE);

$mainframe = mosMainFrame::getInstance();
$database = database::getInstance();
$mosConfig_lang = $mainframe->getCfg( 'lang' );

$action = mosGetParam($_REQUEST, 'action', '');
$attachfile = mosGetParam($_FILES['attachfile'], 'name', '');
$attachimage = mosGetParam($_FILES['attachimage'], 'name', '');
$catid = (int)mosGetParam($_REQUEST, 'catid', '0');
$contentURL = mosGetParam($_REQUEST, 'contentURL', '');
$do = mosGetParam($_REQUEST, 'do', '');
$email = mosGetParam($_REQUEST, 'email', '');
$favoriteMe = mosGetParam($_REQUEST, 'favoriteMe', '');
$fb_authorname = mosGetParam($_REQUEST, 'fb_authorname', '');
$fb_thread = mosGetParam($_REQUEST, 'fb_thread', '');
$func = mosGetParam($_REQUEST, 'func', 'listcat');
$id = (int)mosGetParam($_REQUEST, 'id', '');
$limit = intval(mosGetParam($_REQUEST, 'limit', 0));
$limitstart = intval(mosGetParam($_REQUEST, 'limitstart', 0));
$markaction = mosGetParam($_REQUEST, 'markaction', '');
$message = mosGetParam($_REQUEST, 'message', '');
$page = mosGetParam($_REQUEST, 'page', '');
$parentid = (int)mosGetParam($_REQUEST, 'parentid', '');
$pid = (int)mosGetParam($_REQUEST, 'pid', '');
$replyto = mosGetParam($_REQUEST, 'replyto', '');
$resubject = mosGetParam($_REQUEST, 'resubject', '');
$return = mosGetParam($_REQUEST, 'return', '');
$rowid = (int)mosGetParam($_REQUEST, 'rowid', '');
$rowItemid = mosGetParam($_REQUEST, 'rowItemid', '');
$sel = mosGetParam($_REQUEST, 'sel', '');
$subject = mosGetParam($_REQUEST, 'subject', '');
$subscribeMe = mosGetParam($_REQUEST, 'subscribeMe', '');
$thread = (int)mosGetParam($_REQUEST, 'thread', '');
$topic_emoticon = mosGetParam($_REQUEST, 'topic_emoticon', '');
$userid = (int)mosGetParam($_REQUEST, 'userid', '');
$view = mosGetParam($_REQUEST, 'view', '');
$msgpreview = mosGetParam($_REQUEST, 'msgpreview', '');

require_once (JPATH_BASE . DS . 'administrator' . DS . 'components' . DS . 'com_fireboard' . DS . 'fireboard.config.php');
// Загрузка конфигурации
FBJConfig::loadConfig();

$fbConfig = FBJConfig::getInstance();

require_once (JPATH_BASE . DS . 'components' . DS . 'com_fireboard' . DS . 'class.fireboard.php');

if(file_exists(JB_ABSADMPATH . '/language/' . JB_LANG . '.php')){
	include_once (JB_ABSADMPATH . '/language/' . JB_LANG . '.php');
} else{
	include_once (JB_ABSADMPATH . '/language/english.php');
}

include_once (JB_ABSSOURCESPATH . 'fb_timeformat.class.php');
define ('JB_SECONDS_IN_HOUR', 3600);
define ('JB_SECONDS_IN_YEAR', 31536000);
define ('JB_SESSION_TIMEOUT', 1800);
define ('JB_OFFSET_BOARD', ($fbConfig->board_ofset * JB_SECONDS_IN_HOUR));
$systime = time() + JB_OFFSET_BOARD;
define ('JB_DB_MISSING_COLUMN', 1054);
$settings = $_COOKIE['fboard_settings'];
$str_FB_templ_path = JB_ABSPATH . '/template/' . ($fb_user_template ? $fb_user_template : $fbConfig->template);
$board_title = $fbConfig->board_title;
$fromBot = 0;
$prefview = $fbConfig->default_view;
if($fbConfig->joomlaStyle < 1){
	$boardclass = "fb_";
}
$mainframe->prependMetaTag('description', $fbConfig->board_title);
$mainframe->prependMetaTag('keywords', $fbConfig->board_title);
$mainframe->setPageTitle($fbConfig->board_title);
/////////////////////////////////////
function fb_is_private_has_access($catid){
	$database = FBJConfig::database();
	$my = FBJConfig::my();
	$userid = $my->id;
	$database->setQuery("select group_id from #__fb_users where userid=$userid");
	$mygroup = $database->loadResult();
	if($mygroup == 2) return 1;
	$database->setQuery("select admin_recurse from #__fb_categories where id=$catid");
	$group = $database->loadResult();
	if($group == 1) return 1;
	if($mygroup == $group){
		return 1;
	} else{
		return 0;
	}
}

/////////////////////////////////////
$ch_sfb = str_replace("charset=UTF-8 ", "", _ISO);
function jsEscape_decode($jsEscaped, $outCharCode){
	$arrMojis = explode("%u", $jsEscaped);
	for($i = 1; $i < count($arrMojis); $i++){
		$c = substr($arrMojis[$i], 0, 4);
		$cc = mb_convert_encoding(pack('H*', $c), $outCharCode, 'UTF-16');
		$arrMojis[$i] = substr_replace($arrMojis[$i], $cc, 0, 4);
		$arrMojis[$i] = urldecode($arrMojis[$i]);
	}
	if($arrMojis[0] != "") $arrMojis[0] = urldecode($arrMojis[0]);
	return implode('', $arrMojis);
}

if($func == "getpreview"){
	if(file_exists(JB_ABSTMPLTPATH . '/smile.class.php')){
		include (JB_ABSTMPLTPATH . '/smile.class.php');
	} else{
		include (JB_ABSPATH . '/template/default/smile.class.php');
	}
	$message = jsEscape_decode($msgpreview, $ch_sfb);
	$msgbody = smile::htmlwrap($msgbody, $fbConfig->wrap);
	header("Content-Type: text/html; " . _ISO);
	echo $msgbody;
	die();
}
///////////////////////////////////// 
$mainframe->addJS(JPATH_SITE . '/components/com_fireboard/template/default/js/modal.js');
$mainframe->addJS(JPATH_SITE . '/components/com_fireboard/template/default/js/dimensions.js');
$mainframe->addJS(JPATH_SITE . '/components/com_fireboard/template/default/js/hint.js');

echo mosCommonHTML::loadJqueryPlugins('fancybox/jquery.fancybox', true, true);
$mainframe->addCustomFooterTag('<script type="text/javascript">$(function(){$("a[rel*=fancybox]").fancybox();})</script>');

$mainframe->addCustomHeadTag('<script type="text/javascript">jr_expandImg_url = "' . JB_URLIMAGESPATH . '";</script>');
$mainframe->addCustomHeadTag('<script type="text/javascript" src="' . JB_COREJSURL . '"></script>');

if($fbConfig->joomlaStyle < 1){
	$mainframe->addCustomHeadTag('<link type="text/css" rel="stylesheet" href="' . JB_TMPLTCSSURL . '" />');
} else{
	$mainframe->addCustomHeadTag('<link type="text/css" rel="stylesheet" href="' . JB_DIRECTURL . '/template/default/joomla.css" />');
}
if(file_exists(JB_ABSTMPLTPATH . '/plugin/who/who.class.php')){
	include (JB_ABSTMPLTPATH . '/plugin/who/who.class.php');
} else{
	include (JB_ABSPATH . '/template/default/plugin/who/who.class.php');
}
if(file_exists(JB_ABSTMPLTPATH . '/fb_layout.php')){
	require_once (JB_ABSTMPLTPATH . '/fb_layout.php');
} else{
	require_once (JB_ABSPATH . '/template/default/fb_layout.php');
}
require_once (JB_ABSSOURCESPATH . 'fb_permissions.php');
require_once (JB_ABSSOURCESPATH . 'fb_category.class.php');
if($catid != ''){
	$thisCat = new jbCategory($database, $catid);
}

require_once (JPATH_BASE . '/includes/patTemplate/patTemplate.php');

$obj_FB_tmpl = new patTemplate();
$obj_FB_tmpl->setBasedir($str_FB_templ_path);
if($my->id != 0){
	$aro_group = $acl->getAroGroup($my->id);
	$is_admin = (strtolower($aro_group->name) == 'super administrator' || strtolower($aro_group->name) == 'administrator');
} else{
	$aro_group = 0;
	$is_admin = 0;
}
$is_moderator = fb_has_moderator_permission($database, $thisCat, $my->id, $is_admin);
if($func == 'fb_rss'){
	include (JB_ABSSOURCESPATH . 'fb_rss.php');
	die();
}
if($func == 'fb_pdf'){
	include (JB_ABSSOURCESPATH . 'fb_pdf.php');
	die();
}
$cbitemid = 0;
if($fbConfig->cb_profile){
	$UElanguagePath = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/language';
	$UElanguage = $mainframe->getCfg('lang');
	if(!file_exists($UElanguagePath . '/' . $mosConfig_lang . '/' . $mosConfig_lang . '.php')){
		$UElanguage = 'default_language';
	}
	include_once ($UElanguagePath . '/' . $UElanguage . '/' . $UElanguage . '.php');
}
$useIcons = 0;
if(file_exists(JB_ABSTMPLTPATH . '/icons.php')){
	include_once (JB_ABSTMPLTPATH . '/icons.php');
	$useIcons = 1;
} else{
	include_once (JB_ABSPATH . '/template/default/icons.php');
}
$fbIcons = FBJIcons::getInstance();

$my_id = $my->id;
if($fbConfig->regonly && !$my_id){
	echo _FORUM_UNAUTHORIZIED . "<br />";
	echo _FORUM_UNAUTHORIZIED2;
} else if($fbConfig->board_offline && !$is_admin){
	echo $fbConfig->offline_message;
} else{
	if($my_id > 0){
		setcookie("fboard_settings[member_id]", $my_id, time() + JB_SECONDS_IN_YEAR, '/');
		$new_fb_user = 0;
		$previousVisit = 0;
		$resetView = 0;
		$database->setQuery("SELECT userid, allowed, lasttime, readtopics, currvisit from #__fb_sessions where userid=" . $my_id);
		if(!$database->query()){
			if($database->getErrorNum() == JB_DB_MISSING_COLUMN && strpos($database->getErrorMsg(), "currvisit") != 0){
				$database->setQuery("ALTER TABLE #__fb_sessions ADD COLUMN currvisit int(11) NOT NULL default '0' AFTER readtopics");
				if(!$database->query()) die ("Serious db upgrade problem " . $database->getErrorNum() . ":" . $database->getErrorMsg());
				$database->setQuery("UPDATE #__fb_sessions SET currvisit=lasttime");
				if(!$database->query()) die ("Serious db upgrade problem " . $database->getErrorNum() . ":" . $database->getErrorMsg());
				$database->setQuery("SELECT userid, allowed, lasttime, readtopics, currvisit from #__fb_sessions where userid=" . $my_id);
				if(!$database->query()) die ("Serious db problem " . $database->getErrorNum() . ":" . $database->getErrorMsg());
			} else{
				die (_AFB_DB_PROBLEM . $database->getErrorNum() . ":" . $database->getErrorMsg());
			}
		}
		$fbSessionArray = $database->loadObjectList();
		$fbSession = $fbSessionArray[0];
		if($fbSession->userid == ""){
			$new_fb_user = 1;
			$resetView = 1;
			$previousVisit = $systime - JB_SECONDS_IN_YEAR;
			$database->setQuery("INSERT INTO #__fb_sessions (userid,allowed,lasttime,readtopics,currvisit) values ($my_id, 'na',  $previousVisit,'',$systime)");
			if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
		} else{
			$previousVisit = $fbSession->lasttime;
			$database->setQuery("UPDATE #__fb_sessions SET currvisit=$systime where userid=$my_id");
			if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
		}
		if($new_fb_user == 0 && $markaction != "allread"){
			$inactivePeriod = $fbSession->currvisit + JB_SESSION_TIMEOUT;

			if($inactivePeriod < $systime){
				$resetView = 1;
				$previousVisit = $fbSession->currvisit;
				$database->setQuery("UPDATE #__fb_sessions SET allowed='na', readtopics='', lasttime=$previousVisit where userid=$my_id");
				if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
			}
		} else{
			if($newfb_user == 1){
				$allowed_forums = "";
			} else if($markaction == "allread"){
				$previousVisit = $systime;
				$database->setQuery("UPDATE #__fb_sessions SET lasttime=$previousVisit, readtopics='' where userid=$my_id");
				if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
				echo "<script> alert('" . _GEN_ALL_MARKED . "'); window.location='" . sefRelToAbs(JB_LIVEURLREL) . "';</script>\n";
			}
		}
		$database->setQuery("select view from #__fb_users where userid=$my_id");
		$database->query();
		$prefview = $database->loadResult();
		if($prefview == ""){
			$prefview = $fbConfig->default_view;
			$database->setQuery("insert into #__fb_users (userid,view,moderator) values ('$my_id','$prefview','$is_admin')");
			if(!$database->query()) echo _PROBLEM_CREATING_PROFILE;
			if($fbConfig->cb_profile){
				$cbprefview = $prefview == "threaded" ? "_UE_FB_VIEWTYPE_THREADED" : "_UE_FB_VIEWTYPE_FLAT";

				$database->setQuery("update #__comprofiler set fbviewtype='$cbprefview' where user_id='$my_id'");
				if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
			}
		} else if($fbConfig->cb_profile){
			$database->setQuery("select fbviewtype from #__comprofiler where user_id='$my_id'");
			if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
			$fbviewtype = $database->loadResult();
			$prefview = $fbviewtype == "_UE_FB_VIEWTYPE_THREADED" ? "threaded" : "flat";
		}
		if($resetView == 1){
			setcookie("fboard_settings[current_view]", $prefview, time() + JB_SECONDS_IN_YEAR, '/');
			$view = $prefview;
		}
		$prevCheck = $previousVisit;
	} else{
		$prevCheck = $systime;
	}
	if($view == "" && $settings['current_view'] == ""){
		$view = $prefview == "" ? $fbConfig->default_view : $prefview;
		setcookie("fboard_settings[current_view]", $view, time() + JB_SECONDS_IN_YEAR, '/');
	} else if($view == "" && $settings['current_view'] != ""){
		$view = $settings['current_view'];
	}
	$database->setQuery("SELECT max(posts) from #__fb_users");
	if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
	$maxPosts = $database->loadResult();
	$readTopics = $fbSession->readtopics;
	$read_topics = explode(',', $readTopics);
	if($func == "showcat" || $func == "view" || $func == "post"){
		$database->setQuery("SELECT parent FROM #__fb_categories WHERE id=$catid");
		if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
		$strCatParent = $database->loadResult();
		if($catid == '' || $strCatParent == 0){
			$func = 'listcat';
		}
	}
	switch($func){
		case 'view':
			$fbMenu = jb_get_menu(FB_CB_ITEMID, $fbConfig, $fbIcons, $my_id, 3, $view, $catid, $id, $thread);
			break;
		case 'showcat':
			$database->setQuery("SELECT count(*) FROM #__fb_messages WHERE catid=$catid and hold=1");
			if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
			$numPending = $database->loadResult();
			$fbMenu = jb_get_menu(FB_CB_ITEMID, $fbConfig, $fbIcons, $my_id, 2, $view, $catid, $id, $thread, $is_moderator, $numPending);
			break;
		default:
			$fbMenu = jb_get_menu(FB_CB_ITEMID, $fbConfig, $fbIcons, $my_id, 1);
			break;
	}
	$obj_FB_tmpl->readTemplatesFromFile("header.html");
	$obj_FB_tmpl->addVar('jb-header', 'menu', $fbMenu);
	$obj_FB_tmpl->addVar('jb-header', 'board_title', $board_title);
	$obj_FB_tmpl->addVar('jb-header', 'css_path', JB_DIRECTURL . '/template/' . $fbConfig->template . '/forum.css');
	$obj_FB_tmpl->addVar('jb-header', 'offline_message', $fbConfig->board_offline ? '<span id="fbOffline">' . _FORUM_IS_OFFLINE . '</span>' : '');
	$obj_FB_tmpl->addVar('jb-header', 'searchbox', getSearchBox());
	$obj_FB_tmpl->addVar('jb-header', 'pb_imgswitchurl', JB_URLIMAGESPATH . "shrink.gif");
	$obj_FB_tmpl->displayParsedTemplate('jb-header');
	if(file_exists(JB_ABSTMPLTPATH . '/plugin/profilebox/profilebox.php')){
		include (JB_ABSTMPLTPATH . '/plugin/profilebox/profilebox.php');
	} else{
		include (JB_ABSPATH . '/template/default/plugin/profilebox/profilebox.php');
	}

	switch(strtolower($func)){
		case 'who':
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/who/who.php')){
				include (JB_ABSTMPLTPATH . '/plugin/who/who.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/who/who.php');
			}
			break;
		#########################################################################################
		case 'announcement':
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/announcement/announcement.php')){
				include (JB_ABSTMPLTPATH . '/plugin/announcement/announcement.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/announcement/announcement.php');
			}
			break;
		#########################################################################################
		case 'stats':
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/stats/stats.class.php')){
				include (JB_ABSTMPLTPATH . '/plugin/stats/stats.class.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/stats/stats.class.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/stats/stats.php')){
				include (JB_ABSTMPLTPATH . '/plugin/stats/stats.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/stats/stats.php');
			}
			break;
		#########################################################################################
		case 'fbprofile':
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/fbprofile/fbprofile.php')){
				include (JB_ABSTMPLTPATH . '/plugin/fbprofile/fbprofile.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/fbprofile/fbprofile.php');
			}
			break;
		#########################################################################################
		case 'userlist':
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/userlist/userlist.php')){
				include (JB_ABSTMPLTPATH . '/plugin/userlist/userlist.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/userlist/userlist.php');
			}
			break;
		#########################################################################################
		case 'post':
			$database->setQuery("SELECT ban FROM #__fb_users WHERE userid=" . $my->id);
			$myban = $database->loadResult();
			if($myban){
				?>
			<script type="text/javascript">
				$j.prompt('<?php echo _AFB_UBANNED;?>', { buttons:{ OK:false } });
				window.history.back();
			</script>
			<?php
				break;
			}
			if(file_exists(JB_ABSTMPLTPATH . '/smile.class.php')){
				include (JB_ABSTMPLTPATH . '/smile.class.php');
			} else{
				include (JB_ABSPATH . '/template/default/smile.class.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/post.php')){
				include (JB_ABSTMPLTPATH . '/post.php');
			} else{
				include (JB_ABSPATH . '/template/default/post.php');
			}
			break;
		#########################################################################################
		case 'poll':
			$database->setQuery("SELECT ban FROM #__fb_users WHERE userid=" . $my->id);
			$myban = $database->loadResult();
			if($myban){
				?>
			<script type="text/javascript">
				$j.prompt('<?php echo _AFB_UBANNED;?>', { buttons:{ OK:false } });
				window.history.back();
			</script>
			<?php
				break;
			}
			if(file_exists(JB_ABSTMPLTPATH . '/smile.class.php')){
				include (JB_ABSTMPLTPATH . '/smile.class.php');
			} else{
				include (JB_ABSPATH . '/template/default/smile.class.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/post.php')){
				include (JB_ABSTMPLTPATH . '/post.php');
			} else{
				include (JB_ABSPATH . '/template/default/post.php');
			}
			break;
		#########################################################################################
		case 'view':
			if(file_exists(JB_ABSTMPLTPATH . '/smile.class.php')){
				include (JB_ABSTMPLTPATH . '/smile.class.php');
			} else{
				include (JB_ABSPATH . '/template/default/smile.class.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/view.php')){
				include (JB_ABSTMPLTPATH . '/view.php');
			} else{
				include (JB_ABSPATH . '/template/default/view.php');
			}
			break;
		#########################################################################################
		case 'faq':
			if(file_exists(JB_ABSTMPLTPATH . '/faq.php')){
				include (JB_ABSTMPLTPATH . '/faq.php');
			} else{
				include (JB_ABSPATH . '/template/default/faq.php');
			}
			break;
		#########################################################################################
		case 'showcat':
			if(file_exists(JB_ABSTMPLTPATH . '/smile.class.php')){
				include (JB_ABSTMPLTPATH . '/smile.class.php');
			} else{
				include (JB_ABSPATH . '/template/default/smile.class.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/showcat.php')){
				include (JB_ABSTMPLTPATH . '/showcat.php');
			} else{
				include (JB_ABSPATH . '/template/default/showcat.php');
			}
			break;
		#########################################################################################
		case 'listcat':
			if(file_exists(JB_ABSTMPLTPATH . '/listcat.php')){
				include (JB_ABSTMPLTPATH . '/listcat.php');
			} else{
				include (JB_ABSPATH . '/template/default/listcat.php');
			}
			break;
		#########################################################################################
		case 'review':
			if(file_exists(JB_ABSTMPLTPATH . '/smile.class.php')){
				include (JB_ABSTMPLTPATH . '/smile.class.php');
			} else{
				include (JB_ABSPATH . '/template/default/smile.class.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/moderate_messages.php')){
				include (JB_ABSTMPLTPATH . '/moderate_messages.php');
			} else{
				include (JB_ABSPATH . '/template/default/moderate_messages.php');
			}
			break;
		#########################################################################################
		case 'rules':
			include (JB_ABSSOURCESPATH . 'fb_rules.php');
			break;
		#########################################################################################
		case 'userprofile':
			if(file_exists(JB_ABSTMPLTPATH . '/smile.class.php')){
				include (JB_ABSTMPLTPATH . '/smile.class.php');
			} else{
				include (JB_ABSPATH . '/template/default/smile.class.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile.php')){
				include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile.php');
			}
			break;
		#########################################################################################
		case 'myprofile':
			if(file_exists(JB_ABSTMPLTPATH . '/smile.class.php')){
				include (JB_ABSTMPLTPATH . '/smile.class.php');
			} else{
				include (JB_ABSPATH . '/template/default/smile.class.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile.php')){
				include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile.php');
			}
			break;
		#########################################################################################
		case 'report':
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/report/report.php')){
				include (JB_ABSTMPLTPATH . '/plugin/report/report.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/report/report.php');
			}
			break;
		#########################################################################################
		case 'uploadavatar':
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_avatar_upload.php')){
				include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_avatar_upload.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_avatar_upload.php');
			}
			break;
		#########################################################################################
		case 'latest':
			if(file_exists(JB_ABSTMPLTPATH . '/latestx.php')){
				include (JB_ABSTMPLTPATH . '/latestx.php');
			} else{
				include (JB_ABSPATH . '/template/default/latestx.php');
			}
			break;
		#########################################################################################
		case 'search':
			require_once (JB_ABSSOURCESPATH . 'fb_search.class.php');
			$searchword = mosGetParam($_REQUEST, 'searchword', '');
			$obj_FB_search = new jbSearch($database, $searchword, $my_id, $limitstart, $fbConfig->messages_per_page_search);
			$obj_FB_search->show();
			break;
		case 'advsearch':
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/advancedsearch/advsearch.php')){
				include (JB_ABSTMPLTPATH . '/plugin/advancedsearch/advsearch.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/advancedsearch/advsearch.php');
			}
			break;
		case 'advsearchresult':
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/advancedsearch/advsearchresult.php')){
				include (JB_ABSTMPLTPATH . '/plugin/advancedsearch/advsearchresult.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/advancedsearch/advsearchresult.php');
			}
			break;
		#########################################################################################
		case 'markthisread':
			$database->setQuery("SELECT readtopics FROM #__fb_sessions WHERE userid=$my_id");
			if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
			$allreadyRead = $database->loadResult();
			$database->setQuery("SELECT thread FROM #__fb_messages WHERE catid=$catid and thread not in ('$allreadyRead') GROUP BY THREAD");
			if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
			$readForum = $database->loadObjectList();
			$readTopics = '--';
			foreach($readForum as $rf){
				$readTopics = $readTopics . ',' . $rf->thread;
			}
			$readTopics = str_replace('--,', '', $readTopics);
			if($allreadyRead != ""){
				$readTopics = $readTopics . ',' . $allreadyRead;
			}
			$database->setQuery("UPDATE #__fb_sessions set readtopics='$readTopics' WHERE userid=$my_id");
			if(!$database->query()) die (_AFB_DB_PROBLEM . $database->getErrorMsg());
			echo "<script> alert('" . _GEN_FORUM_MARKED . "'); window.history.go(-1); </script>\n";
			break;
		#########################################################################################
		case 'karma':
			include (JB_ABSSOURCESPATH . 'fb_karma.php');
			break;
		#########################################################################################
		case 'bulkactions':
			switch($do){
				case "bulkDel":
					FBTools::fbDeletePosts($is_moderator, $return);
					break;
				case "bulkMove":
					FBTools::fbMovePosts($catid, $is_moderator, $return);
					break;
			}
			break;
		######################
		case "templatechooser":
			$fb_user_template = strval(mosGetParam($_COOKIE, 'fb_user_template', ''));
			$fb_user_img_template = strval(mosGetParam($_REQUEST, 'fb_user_img_template', $fb_user_img_template));
			$fb_change_template = strval(mosGetParam($_REQUEST, 'fb_change_template', $fb_user_template));
			$fb_change_img_template = strval(mosGetParam($_REQUEST, 'fb_change_img_template', $fb_user_img_template));
			if($fb_change_template){
				$fb_change_template = preg_replace('#\W#', '', $fb_change_template);
				if(strlen($fb_change_template) >= 40){
					$fb_change_template = substr($fb_change_template, 0, 39);
				}
				if(file_exists($mosConfig_absolute_path . '/components/com_fireboard/template/' . $fb_change_template . '/forum.css')){
					$lifetime = 60 * 10;
					$fb_current_template = $fb_change_template;
					setcookie('fb_user_template', "$fb_change_template", time() + $lifetime);
				} else{
					setcookie('fb_user_template', '', time() - 3600);
				}
			}
			if($fb_change_img_template){
				$fb_change_img_template = preg_replace('#\W#', '', $fb_change_img_template);
				if(strlen($fb_change_img_template) >= 40){
					$fb_change_img_template = substr($fb_change_img_template, 0, 39);
				}
				if(file_exists($mosConfig_absolute_path . '/components/com_fireboard/template/' . $fb_change_img_template . '/forum.css')){
					$lifetime = 60 * 10;
					$fb_current_img_template = $fb_change_img_template;
					setcookie('fb_user_img_template', "$fb_change_img_template", time() + $lifetime);
				} else{
					setcookie('fb_user_img_template', '', time() - 3600);
				}
			}
			mosRedirect(sefRelToAbs(JB_LIVEURLREL));
			break;
		#########################################################################################
		default:
			if(file_exists(JB_ABSTMPLTPATH . '/listcat.php')){
				include (JB_ABSTMPLTPATH . '/listcat.php');
			} else{
				include (JB_ABSPATH . '/template/default/listcat.php');
			}
			break;
	}
	if(mosCountModules('fb_bottom')){
		?>
	<div class="bof-bottom-modul">
		<?php
		mosLoadModules('fb_bottom', -2);
		?>
	</div>
	<?php
	}
	echo '<div class="fb_credits">';
	if($fbConfig->enableRSS){
		$rsslink = sefReltoAbs('index2.php?option=com_fireboard&amp;func=fb_rss&amp;no_html=1' . FB_FB_ITEMID_SUFFIX);
		echo '<a href="' . $rsslink . '" target="_blank" ><img class="rsslink" src="' . JB_URLEMOTIONSPATH . 'rss.gif" border="0" alt="' . _LISTCAT_RSS . '" title="' . _LISTCAT_RSS . '" /></a>';
	}
	echo '</div>';
	$obj_FB_tmpl->readTemplatesFromFile("footer.html");
	$obj_FB_tmpl->displayParsedTemplate('fb-footer');
}
$mtime = explode(" ", microtime());
$tend = $mtime[1] + $mtime[0];
$tpassed = ($tend - $tstart);
?>