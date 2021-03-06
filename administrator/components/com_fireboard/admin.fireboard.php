<?php
/**
 * @version $Id: admin.fireboard.php 529 2007-12-23 14:45:45Z danialt $
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
error_reporting(E_ALL ^ E_NOTICE);
include_once (JPATH_BASE_ADMIN . '/components/com_fireboard/fireboard.config.php');

// Загрузка конфигурации
FBJConfig::loadConfig();

require_once (JPATH_BASE . "/components/com_fireboard/class.fireboard.php");
require_once ($mainframe->getPath('admin_html'));
if(file_exists($mainframe->getCfg('absolute_path') . '/administrator/components/com_fireboard/language/' . $mainframe->getCfg('lang') . '.php')){
	include ($mainframe->getCfg('absolute_path') . '/administrator/components/com_fireboard/language/' . $mainframe->getCfg('lang') . '.php');
} else{
	include ($mainframe->getCfg('absolute_path') . '/administrator/components/com_fireboard/language/english.php');
}
$cid = mosGetParam($_REQUEST, 'cid', array(0));
if(!is_array($cid)){
	$cid = array(0);
}
$uid = mosGetParam($_REQUEST, 'uid', array(0));
if(!is_array($uid)){
	$uid = array($uid);
}
$order = mosGetParam($_REQUEST, 'order');

$no_html = mosGetParam($_REQUEST, 'no_html');
$pt_stop = "0";
/* header  */
/* upgrading from SB */
$database->setQuery("#__fb_messages");
$table_nm = $database->_sql;
$jb_upgrade = false;
if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $table_nm . "'"))){
	$jb_upgrade = true;
}
if(!$jb_upgrade && $task != "installfb" && !$no_html){
	?>
<style>
	fieldset {
		border: 1px solid orange
	}

	legend {
		padding: 0.2em 0.5em;
		border: 1px solid orange;
		color: red;
		font-size: 90%;
		text-align: right;
	}
</style>
<fieldset>
	<legend>
		<?php echo _FB_DBWIZ; ?>
	</legend>
	<?php echo _FB_DBMETHOD; ?>
	<ul>
		<li><label for="installclean"><b><?php echo _FB_DBCLEAN; ?></b></label>
			<br/>
			<input name="installclean" value="<?php echo _FB_INSTALL_APPLY; ?>" type="button"
				   onclick="location.href='index2.php?option=com_fireboard&task=installfb&mode=1';"></li>
	</ul>
</fieldset>
<?php
}
/* /header  */
if(!$no_html){
	HTML_SIMPLEBOARD::showFbHeader();
}
switch($task){
	case "puzzreset":
		resetPuzzle();
		break;
	case "restrictedUser":
		restrictedUser($option, $id);
		break;
	case "editrestrictedUser":
		editrestrictedUser($option, $id);
		break;
	case "newRestrictUser":
		newRestrictUser($option, $_POST["forum_id"]);
		break;
	case "saveRestrictedUser":
		saveRestrictedUser($option, $id);
		break;
	case "removerestrictedUser";
		removerestrictedUser($option, $id, $_POST["forum_id"]);
		break;
	case "reupgrade":
		reupgrade();
		break;
	case "banuser":
		banuser($banid);
		break;
	case "installfb":
		$mode = mosGetParam($_REQUEST, "mode", 1);
		com_install_fireboard($mode);
		break;
	case "new":
		editForum(0, $option);
		break;
	case "edit":
		editForum($cid[0], $option);
		break;
	case "edit2":
		editForum($uid[0], $option);
		break;
	case "save":
		saveForum($option);
		break;
	case "cancel":
		cancelForum($option);
		break;
	case "publish":
		publishForum($cid, 1, $option);
		break;
	case "unpublish":
		publishForum($cid, 0, $option);
		break;
	case "remove":
		deleteForum($cid, $option);
		break;
	case "orderup":
		orderForum($cid[0], -1, $option);
		break;
	case "orderdown":
		orderForum($cid[0], 1, $option);
		break;
	case "showconfig":
		FBJConfig::showConfig($option);
		break;
	case "saveconfig":
		FBJConfig::saveConfig($option);
		break;
	case "newmoderator":
		newModerator($option, $id);
		break;
	case "addmoderator":
		addModerator($option, $id, $cid, 1);
		break;
	case "removemoderator":
		addModerator($option, $id, $cid, 0);
		break;
	case "showprofiles":
		showProfiles($option, $order);
		break;
	case "profiles":
		showProfiles($option, $order);
		break;
	case "userprofile":
		editUserProfile($uid);
		break;
	case "showinstructions":
		showInstructions();
		break;
	case "showCss":
		showCss($option);
		break;
	case "saveeditcss":
		$file = mosGetParam($_REQUEST, "file", 1);
		$csscontent = mosGetParam($_REQUEST, "csscontent", 1);
		saveCss($file, $csscontent, $option);
		break;
	case "instructions":
		showInstructions();
		break;
	case "saveuserprofile":
		saveUserProfile($option);
		break;
	case "upgradetables":
		upgradeTables($option);
		break;
	case "loadSample":
		loadSample($database, $option);
		break;
	case "removeSample":
		removeSample($database, $option);
		break;
	case "pruneforum":
		pruneforum($database, $option);
		break;
	case "doprune":
		doprune($database, $option);
		break;
	case "douserssync":
		douserssync($database, $option);
		break;
	case "syncusers":
		syncusers($database, $option);
		break;
	case "browseImages":
		browseUploaded($database, $option, 1);
		break;
	case "browseFiles":
		browseUploaded($database, $option, 0);
		break;
	case "replaceImage":
		replaceImage($database, $option, $img, $OxP);
		break;
	case "deleteFile":
		deleteFile($database, $option, $fileName);
		break;
	case "showAdministration":
		showAdministration($option);
		break;
	case "loadCBprofile":
		loadCBprofile($database, $option);
		break;
	case 'recount':
		FBTools::reCountBoards();
		mosRedirect("index2.php?option=com_fireboard", _FB_RECOUNTFORUMS_DONE);
		break;
	case "showsmilies":
		showsmilies($option);
		break;
	case "editsmiley":
		editsmiley($option, $id);
		break;
	case "savesmiley":
		savesmiley($option, $id);
		break;
	case "deletesmiley":
		deletesmiley($option, $id);
		break;
	case "newsmiley":
		newsmiley($option);
		break;
	case 'ranks':
		showRanks($option);
		break;
	case "editRank":
		editRank($option, $id);
		break;
	case "saveRank":
		saveRank($option, $id);
		break;
	case "deleteRank":
		deleteRank($option, $id);
		break;
	case "newRank":
		newRank($option);
		break;
	case 'groups':
		showGroups($option);
		break;
	case 'cpanel':
	default:
		HTML_Simpleboard::controlPanel();
		break;
}
HTML_SIMPLEBOARD::showFbFooter();
/** @noinspection PhpInconsistentReturnPointsInspection */
function showAdministration($option){
	$database = database::getInstance();
	$mainframe = mosMainFrame::getInstance();

	$limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', 10);
	$limitstart = $mainframe->getUserStateFromRequest("view{$option}limitstart", 'limitstart', 0);
	$levellimit = $mainframe->getUserStateFromRequest("view{$option}limit", 'levellimit', 10);
	$database->setQuery("SELECT a.*, a.name AS category, u.name AS editor, g.name AS groupname, h.name AS admingroup" . "\nFROM #__fb_categories AS a" . "\nLEFT JOIN #__users AS u ON u.id = a.checked_out" . "\nLEFT JOIN #__core_acl_aro_groups AS g ON g." . ((FBTools::isJoomla15()) ? "" : "group_") . "id = a.pub_access" . "\nLEFT JOIN #__core_acl_aro_groups AS h ON h." . ((FBTools::isJoomla15()) ? "" : "group_") . "id = a.admin_access" . "\n GROUP BY a.id" . "\n ORDER BY a.ordering, a.name");
	$rows = $database->loadObjectList();
	if($database->getErrorNum()){
		echo $database->stderr();
		return false;
	}
	$children = array();
	foreach($rows as $v){
		$pt = $v->parent;
		$list = @$children[$pt] ? $children[$pt] : array();
		array_push($list, $v);
		$children[$pt] = $list;
	}
	$list = fbTreeRecurse(0, '', array(), $children, max(0, $levellimit - 1));
	$total = count($list);
	require_once (FBJConfig::getCfg('absolute_path') . '/administrator/includes/pageNavigation.php');
	$pageNav = new mosPageNav($total, $limitstart, $limit);
	$levellist = mosHTML::integerSelectList(1, 20, 1, 'levellimit', 'size="1" onchange="document.adminForm.submit();"', $levellimit);
	$list = array_slice($list, $pageNav->limitstart, $pageNav->limit);
	HTML_SIMPLEBOARD::showAdministration($list, $pageNav, $option);
	return true;
}

//---------------------------------------
//-E D I T   F O R U M-------------------
//---------------------------------------
function editForum($uid, $option){
	$acl = gacl::getInstance();
	$database = FBJConfig::database();
	$my = FBJConfig::my();

	$row = new fbForum($database);
	$row->load($uid);
	if($uid){
		$row->checkout($my->id);
		$categories = array();
	} else{
		$categories[] = mosHTML::makeOption(0, _FB_TOPLEVEL);
		$row->parent = 0;
		$row->published = 0;
		$row->ordering = 9999;
	}
	$database->setQuery("SELECT a.id AS value, a.name AS text" . "\nFROM #__fb_categories AS a" . "\nWHERE parent='0' AND id<>'$row->id'" . "\nORDER BY ordering");
	$categories = array_merge($categories, $database->loadObjectList());
	if($row->parent == 0){
		$database->setQuery("SELECT distinct '0' AS value, _FB_TOPLEVEL AS text" . "\nFROM #__fb_categories AS a" . "\nWHERE parent='0' AND id<>'$row->id'" . "\nORDER BY ordering");
		$categories = array_merge($categories, (array)$database->loadObjectList());
		$categoryList = mosHTML::selectList($categories, 'parent', 'class="inputbox" size="1"', 'value', 'text', $row->parent);
	} else{
		$categoryList = mosHTML::selectList($categories, 'parent', 'class="inputbox" size="1"', 'value', 'text', $row->parent);
	}
	$categoryList = showCategories($row->parent, "parent", "", "4");
	$yesno = array();
	$yesno[] = mosHTML::makeOption('0', _ANN_NO);
	$yesno[] = mosHTML::makeOption('1', _ANN_YES);
	$noyes = array();
	$noyes[] = mosHTML::makeOption('1', _ANN_YES);
	$noyes[] = mosHTML::makeOption('0', _ANN_NO);
	$lists = array();
	$accessLists = array();
	$pub_groups = array();
	$pub_groups[] = mosHTML::makeOption(0, _FB_EVERYBODY);
	$pub_groups[] = mosHTML::makeOption(-1, _FB_ALLREGISTERED);
	$pub_groups = array_merge($pub_groups, $acl->get_group_children_tree(null, _FB_REGISTERED, true));
	$adm_groups = array();
	$adm_groups = array_merge($adm_groups, $acl->get_group_children_tree(null, _FB_PUBLICBACKEND, true));

	$database->setQuery("SELECT * FROM #__fb_groups");
	$allgroups = $database->loadObjectList();
	foreach($allgroups as $group){
		$usergroups[] = mosHTML::makeOption($group->id, $group->title);
	}
	$lists['admin_recurse'] = mosHTML::selectList($usergroups, 'admin_recurse', 'class="inputbox" size="8"', 'value', 'text', $row->admin_recurse);

	$accessLists['pub_access'] = mosHTML::selectList($pub_groups, 'pub_access', 'class="inputbox" size="4"', 'value', 'text', $row->pub_access);
	$accessLists['admin_access'] = mosHTML::selectList($adm_groups, 'admin_access', 'class="inputbox" size="4"', 'value', 'text', $row->admin_access);
	$lists['pub_recurse'] = mosHTML::selectList($yesno, 'pub_recurse', 'class="inputbox" size="1"', 'value', 'text', $row->pub_recurse);
	//$lists['admin_recurse'] = mosHTML::selectList($yesno, 'admin_recurse', 'class="inputbox" size="1"', 'value', 'text', $row->admin_recurse);
	$lists['forumLocked'] = mosHTML::selectList($yesno, 'locked', 'class="inputbox" size="1"', 'value', 'text', $row->locked);
	$lists['forumModerated'] = mosHTML::selectList($noyes, 'moderated', 'class="inputbox" size="1"', 'value', 'text', $row->moderated);
	$lists['forumReview'] = mosHTML::selectList($yesno, 'review', 'class="inputbox" size="1"', 'value', 'text', $row->review);
	$moderatorList = array();
	if($row->moderated == 1){
		$database->setQuery("SELECT * " . "\n FROM #__fb_moderation AS a " . "\n LEFT JOIN #__users as u" . "\n ON a.userid=u.id where a.catid=$row->id");
		$moderatorList = $database->loadObjectList();
	}

	HTML_SIMPLEBOARD::editForum($row, $categoryList, $moderatorList, $lists, $accessLists, $option);
}

function saveForum($option){
	$database = FBJConfig::database();

	$row = new fbForum($database);

	if(!$row->bind($_POST)){
		echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
		exit();
	}

	if(!$row->check()){
		echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
		exit();
	}

	if(!$row->store()){
		echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
		exit();
	}

	$row->checkin();
	$row->updateOrder("parent='$row->parent'");
	mosRedirect("index2.php?option=$option&task=showAdministration");
}

function publishForum($cid = null, $publish = 1, $option){
	$database = FBJConfig::database();
	$my = FBJConfig::my();

	if(!is_array($cid) || count($cid) < 1){
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('" . _FB_SELECTANITEMTO . " $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode(',', $cid);
	$database->setQuery("UPDATE #__fb_categories SET published='$publish'" . "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))");

	if(!$database->query()){
		echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
		exit();
	}

	if(count($cid) == 1){
		$row = new fbForum($database);
		$row->checkin($cid[0]);
	}

	mosRedirect("index2.php?option=$option&task=showAdministration");
}

function deleteForum($cid = null, $option){
	$database = FBJConfig::database();
	$my = FBJConfig::my();

	if(!is_array($cid) || count($cid) < 1){
		$action = 'delete';
		echo "<script> alert('" . _FB_SELECTANITEMTO . " $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode(',', $cid);
	$database->setQuery("DELETE FROM #__fb_categories" . "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))");

	if($database->query()){ //now we got to clear up all posts
		$database->setQuery("SELECT id, parent FROM #__fb_messages where catid in ($cids)");
		$mesList = $database->loadObjectList();

		if(count($mesList) > 0){
			$fail = 0;

			foreach($mesList as $ml){
				$database->setQuery("DELETE FROM #__fb_messages WHERE id = $ml->id");

				if($database->query()){
					$database->setQuery("DELETE FROM #__fb_messages_text WHERE mesid=$ml->id");
					$database->query();
				} else{
					$fail = 1;
				}

				//and clear up all subscriptions as well
				if($ml->parent == 0){ //this was a topic message to which could have been subscribed
					$database->setQuery("DELETE FROM #__fb_subscriptions WHERE thread=$ml->id");

					if(!$database->query()){
						$fail = 1;
					}
				}
			}
		}
	} else{
		echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
		exit();
	}

	if($fail != 0){
		echo "<script> alert('" . _FB_ERRORSUBS . "'); window.history.go(-1); </script>\n";
	}

	mosRedirect("index2.php?option=$option&task=showAdministration");
}

function cancelForum($option){
	$database = FBJConfig::database();
	$row = new fbForum($database);
	$row->bind($_POST);
	$row->checkin();
	mosRedirect("index2.php?option=$option&task=showAdministration");
}

function orderForum($uid, $inc, $option){
	$database = FBJConfig::database();
	$row = new fbForum($database);
	$row->load($uid);
	$row->move($inc, "parent='$row->parent'");
	mosRedirect("index2.php?option=$option&task=showAdministration");
}

function showInstructions(){
	HTML_SIMPLEBOARD::showInstructions();
}

//===============================
// CSS functions
//===============================
function showCss($option){
	$fbConfig = FBJConfig::getInstance();
	$file = "../components/com_fireboard/template/" . $fbConfig->template . "/forum.css";
	@chmod($file, 0766);
	$permission = is_writable($file);
	if(!$permission){
		echo "<h1><span style='color:red'>" . _FB_WARNING . "</span></h1><BR>";
		echo "<B>Your css file is <#__root>/components/com_fireboard/template/" . $fbConfig->template . "/forum.css</b><BR>";
		echo "<B>" . _FB_CHMOD1 . "</B><BR><BR>";
	}
	HTML_SIMPLEBOARD::showCss($file, $option);
}

function saveCss($file, $csscontent, $option){
	$tmpstr = _FB_CSS_SAVE;
	$tmpstr = str_replace("%file%", $file, $tmpstr);
	echo $tmpstr;
	if(is_writable($file) == false){
		echo "<script>alert('" . _FB_TFINW . "')</script>";
		echo "<script>document.location.href='index2.php?option=com_fireboard&task=showCss'</script>\n";
	}
	echo "<script>alert('" . _FB_FBCFS . "')</script>";
	echo "<script>document.location.href='index2.php?option=com_fireboard&task=showCss'</script>\n";
	if($fp = fopen($file, "w")){
		fputs($fp, stripslashes($csscontent));
		fclose($fp);
		mosRedirect("index2.php?option=$option&task=showCss", _FB_CFS);
	} else{
		mosRedirect("index2.php?option=$option", _FB_CFCNBO);
	}
}

//===============================
// Moderator Functions
//===============================
function newModerator($option, $id = null){
	$database = FBJConfig::database();
	$limit = intval(mosGetParam($_POST, 'limit', 10));
	$limitstart = intval(mosGetParam($_POST, 'limitstart', 0));
	$database->setQuery("SELECT * FROM #__users AS a" . "\n LEFT JOIN #__fb_users AS b" . "\n ON a.id=b.userid" . "\n WHERE b.moderator=1 LIMIT $limitstart,$limit");
	$userList = $database->loadObjectList();
	$countUL = count($userList);
	$database->setQuery("SELECT COUNT(*) FROM #__users AS a" . "\n LEFT JOIN #__fb_users AS b" . "\n ON a.id=b.userid where b.moderator=1");
	$total = $database->loadResult();
	if($limit > $total){
		$limitstart = 0;
	}
	require_once ("includes/pageNavigation.php");
	$pageNav = new mosPageNav($total, $limitstart, $limit);
	$forumName = '';
	$database->setQuery("select name from #__fb_categories where id=$id");
	$forumName = $database->loadResult();
	$database->setQuery("select userid from #__fb_moderation where catid=$id");
	$moderatorList = $database->loadObjectList();
	$moderators = 0;
	$modIDs[] = array();
	if(count($moderatorList) > 0){
		foreach($moderatorList as $ml){
			$modIDs[] = $ml->userid;
		}
		$moderators = 1;
	} else{
		$moderators = 0;
	}
	HTML_SIMPLEBOARD::newModerator($option, $id, $moderators, $modIDs, $forumName, $userList, $countUL, $pageNav);
}

function addModerator($option, $id, $cid = null, $publish = 1){
	$database = FBJConfig::database();
	$numcid = count($cid);
	if($publish == 1){
		$action = 'add';
	} else{
		$action = 'remove';
	}
	if(!is_array($cid) || $numcid < 1){
		echo "<script> alert('" . _FB_SELECTMODTO . " $action'); window.history.go(-1);</script>\n";
		exit;
	}
	if($action == 'add'){
		for($i = 0, $n = $numcid; $i < $n; $i++){
			$database->setQuery("INSERT INTO #__fb_moderation set catid='$id', userid='$cid[$i]'");
			if(!$database->query()){
				echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
				exit();
			}
		}
	} else{
		for($i = 0, $n = $numcid; $i < $n; $i++){
			$database->setQuery("DELETE FROM #__fb_moderation WHERE catid='$id' and userid='$cid[$i]'");
			if(!$database->query()){
				echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
				exit();
			}
		}
	}
	$row = new fbForum($database);
	$row->checkin($id);
	mosRedirect("index2.php?option=$option&task=edit2&uid=" . $id);
}

//===============================
//   User Profile functions
//===============================
function showProfiles($option, $order){
	$database = FBJConfig::database();
	$mainframe = FBJConfig::mainframe();
	$limit = intval(mosGetParam($_POST, 'limit', 50));
	$limitstart = intval(mosGetParam($_POST, 'limitstart', 0));
	$search = $mainframe->getUserStateFromRequest("search{$option}", 'search', '');
	$search = $database->getEscaped(trim(strtolower($search)));
	$where = array();
	if(isset($search) && $search != ""){
		$where[] = "(u.username LIKE '%$search%' OR u.email LIKE '%$search%' OR u.name LIKE '%$search%')";
	}
	if($order == 1){
		$database->setQuery("select * from #__fb_users AS sbu" . "\n LEFT JOIN #__users AS u" . "\n ON sbu.userid=u.id " . (count($where) ? "\nWHERE " . implode(' AND ', $where) : "") . "\n ORDER BY sbu.moderator DESC" . "\n LIMIT $limitstart,$limit");
	} else if($order == 2){
		$database->setQuery("SELECT * FROM #__fb_users AS sbu" . "\n LEFT JOIN #__users AS u " . "\n ON sbu.userid=u.id " . (count($where) ? "\nWHERE " . implode(' AND ', $where) : "") . "\n ORDER BY u.name ASC " . "\n LIMIT $limitstart,$limit");
	} else if($order < 1){
		$database->setQuery("SELECT * FROM #__fb_users AS sbu " . "\n LEFT JOIN #__users AS u" . "\n ON sbu.userid=u.id " . (count($where) ? "\nWHERE " . implode(' AND ', $where) : "") . "\n ORDER BY sbu.userid" . "\n LIMIT $limitstart,$limit");
	}
	$profileList = $database->loadObjectList();
	$countPL = count($profileList);
	$database->setQuery("SELECT COUNT(*) FROM #__fb_users AS sbu" . "\n LEFT JOIN #__users AS u" . "\n ON sbu.userid=u.id" . (count($where) ? "\nWHERE " . implode(' AND ', $where) : ""));
	$total = $database->loadResult();
	if($limit > $total){
		$limitstart = 0;
	}
	require_once ("includes/pageNavigation.php");
	$pageNavSP = new mosPageNav($total, $limitstart, $limit);
	HTML_SIMPLEBOARD::showProfiles($option, $profileList, $countPL, $pageNavSP, $order, $search);
}

function editUserProfile($uid){
	$acl = gacl::getInstance();
	$database = FBJConfig::database();
	$database->setQuery("SELECT * FROM #__fb_users LEFT JOIN #__users on #__users.id=#__fb_users.userid WHERE userid=$uid[0]");
	$userDetails = $database->loadObjectList();
	$user = $userDetails[0];
	$prefview = $user->view;
	$ordering = $user->ordering;
	$moderator = $user->moderator;
	$userRank = $user->rank;
	$userGroup = $user->group_id;
	$ban = $user->ban;
	$result = '';
	$result = $acl->getAroGroup($uid[0]);
	$database->setQuery("SELECT * FROM #__fb_ranks WHERE rank_special = '1'");
	$specialRanks = $database->loadObjectList();
	$yesnoRank[] = mosHTML::makeOption('0', _AFB_NORANG);
	foreach($specialRanks as $ranks){
		$yesnoRank[] = mosHTML::makeOption($ranks->rank_id, $ranks->rank_title);
	}
	$selectRank = mosHTML::selectList($yesnoRank, 'newrank', 'class="inputbox" size="5"', 'value', 'text', $userRank);
	$database->setQuery("SELECT * FROM #__fb_groups");
	$allgroups = $database->loadObjectList();
	foreach($allgroups as $group){
		$usergroups[] = mosHTML::makeOption($group->id, $group->title);
	}
	$selectGroup = mosHTML::selectList($usergroups, 'newgroup', 'class="inputbox" size="8"', 'value', 'text', $userGroup);

	$yesno[] = mosHTML::makeOption('flat', _COM_A_FLAT);
	$yesno[] = mosHTML::makeOption('threaded', _COM_A_THREADED);
	$selectPref = mosHTML::selectList($yesno, 'newview', 'class="inputbox" size="2"', 'value', 'text', $prefview);
	$yesnoMod[] = mosHTML::makeOption('1', _ANN_YES);
	$yesnoMod[] = mosHTML::makeOption('0', _ANN_NO);
	$selectMod = mosHTML::selectList($yesnoMod, 'moderator', 'class="inputbox" size="2"', 'value', 'text', $moderator);
	$yesnoOrder[] = mosHTML::makeOption('0', _USER_ORDER_ASC);
	$yesnoOrder[] = mosHTML::makeOption('1', _USER_ORDER_DESC);
	$selectOrder = mosHTML::selectList($yesnoOrder, 'neworder', 'class="inputbox" size="2"', 'value', 'text', $ordering);
	$database->setQuery("select thread from #__fb_subscriptions where userid=$uid[0]");
	$subslist = $database->loadObjectList();
	$database->setQuery("select catid from #__fb_moderation where userid=" . $uid[0]);
	$_modCats = $database->loadResultArray();
	foreach($_modCats as $_v){
		$__modCats[] = mosHTML::makeOption($_v);
	}
	$modCats = FB_GetAvailableModCats($__modCats);
	HTML_SIMPLEBOARD::editUserProfile($user, $subslist, $selectRank, $selectGroup, $selectPref, $selectMod, $selectOrder, $uid[0], $modCats);
}

function saveUserProfile($option){
	$database = FBJConfig::database();
	$newview = mosGetParam($_POST, 'newview');
	$newrank = mosGetParam($_POST, 'newrank');
	$newgroup = mosGetParam($_POST, 'newgroup');
	$signature = mosGetParam($_POST, 'message');
	$deleteSig = mosGetParam($_POST, 'deleteSig');
	$moderator = mosGetParam($_POST, 'moderator');
	$uid = mosGetParam($_POST, 'uid');
	$avatar = mosGetParam($_POST, 'avatar');
	$deleteAvatar = mosGetParam($_POST, 'deleteAvatar');
	$neworder = mosGetParam($_POST, 'neworder');
	$modCatids = mosGetParam($_POST, 'catid', array());
	$sql = "UPDATE #__fb_users set view='$newview',moderator='$moderator',ordering='$neworder',rank='$newrank', group_id=$newgroup";
	if($deleteSig == 1){
		$sql .= ",signature=''";
	}
	if($deleteAvatar == 1){
		$sql .= ",avatar=''";
	}
	$sql .= " where userid=$uid";
	$database->setQuery($sql);
	if(!$database->query()){
		echo "<script> alert('" . $database->getErrorMsg() . "'); index2.php?option=$option&task=showprofiles; </script>\n";
		exit();
	} else{
		$database->setQuery("delete from #__fb_moderation where userid=$uid");
		$database->query();
		if($moderator == 1){
			if(count($modCatids) > 0){
				foreach($modCatids as $c){
					$database->setQuery("INSERT INTO #__fb_moderation set catid='$c', userid='$uid'");
					if(!$database->query()){
						echo $database->getErrorMsg();
					}
				}
			}
		}
		mosRedirect("index2.php?option=com_fireboard&task=showprofiles");
	}
}

//===============================
// Prune Forum functions
//===============================
function pruneforum($database, $option){
	$forums_list = array();
	$database->setQuery("SELECT a.id as value, a.name as text" . "\nFROM #__fb_categories AS a" . "\nWHERE a.parent != '0'" . "\nAND a.locked != '1'" . "\nORDER BY parent, ordering");
	$forums_list = $database->loadObjectList();
	$forumList['forum'] = mosHTML::selectList($forums_list, 'prune_forum', 'class="inputbox" size="4"', 'value', 'text', '');
	HTML_SIMPLEBOARD::pruneforum($option, $forumList);
}

function doprune($database, $option){
	$catid = intval(mosGetParam($_POST, 'prune_forum', -1));
	$deleted = 0;
	if($catid == -1){
		echo "<script> alert('" . _FB_CHOOSEFORUMTOPRUNE . "'); window.history.go(-1); </script>\n";
		exit();
	}
	$prune_days = intval(mosGetParam($_POST, 'prune_days', 0));
	$database->setQuery("SELECT DISTINCT a.thread AS thread, max(a.time) AS lastpost, c.locked AS locked " . "\n FROM #__fb_messages AS a" . "\n JOIN #__fb_categories AS b ON a.catid=b.id " . "\n JOIN #__fb_messages   AS c ON a.thread=c.thread" . "\n where a.catid=$catid " . "\n and b.locked != 1 " . "\n and a.locked != 1 " . "\n and c.locked != 1 " . "\n and c.parent = 0 " . "\n and c.ordering != 1 " . "\n group by thread");
	$threadlist = $database->loadObjectList();
	$prune_date = FBTools::fbGetInternalTime() - ($prune_days * 86400);
	if(count($threadlist) > 0){
		foreach($threadlist as $tl){
			if($tl->lastpost < $prune_date){
				$database->setQuery("SELECT id from #__fb_messages WHERE thread=$tl->thread");
				$idlist = $database->loadObjectList();
				if(count($idlist) > 0){
					foreach($idlist as $id){
						$database->setQuery("DELETE FROM #__fb_messages WHERE id=$id->id");
						if(!$database->query()){
							echo "<script> alert('" . _FB_DELMSGERROR . " " . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
							exit();
						}
						$database->setQuery("DELETE FROM #__fb_messages_text WHERE mesid=$id->id");
						if(!$database->query()){
							echo "<script> alert('" . _FB_DELMSGERROR1 . " " . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
						}
						$database->setQuery("SELECT filelocation FROM #__fb_attachments WHERE mesid=$id->id");
						$fileList = $database->loadObjectList();
						if(count($fileList) > 0){
							foreach($fileList as $fl){
								unlink($fl->filelocation);
							}
							$database->setQuery("DELETE FROM #__fb_attachments WHERE mesid=$id->id");
							$database->query();
						}
						$deleted++;
					}
				}
			}
			$database->setQuery("DELETE FROM #__fb_subscriptions WHERE thread=$tl->thread");
			if(!$database->query()){
				echo "<script> alert('" . _FB_CLEARSUBSFAIL . " " . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
				exit();
			}
		}
	}
	mosRedirect("index2.php?option=$option&task=pruneforum", "" . _FB_FORUMPRUNEDFOR . " " . $prune_days . " " . _FB_PRUNEDAYS . "; " . _FB_PRUNEDELETED . "" . $deleted . " " . _FB_PRUNETHREADS . "");
}

//===============================
// Sync users
//===============================
function syncusers($database, $option){
	HTML_SIMPLEBOARD::syncusers($option);
}

function douserssync($database, $option){
	$database->setQuery("SELECT a.userid from #__fb_users as a left join #__users as b on a.userid=b.id where b.username is null");
	$idlistR = $database->loadObjectList();
	$allIDsR = array();
	$cidsR = count($idlistR);
	if($cidsR > 0){
		foreach($idlistR as $idR){
			$allIDsR[] = $idR->userid;
		}

		$idsR = implode(',', $allIDsR);
	}
	$database->setQuery("SELECT a.id from #__users as a left join #__fb_users as b on b.userid=a.id where b.userid is null");
	$idlistA = $database->loadObjectList();
	$allIDsA = array();
	$cidsA = count($idlistA);
	if($cidsA > 0){
		foreach($idlistA as $idA){
			$allIDsA[] = $idA->id;
		}
	}
	if($cidsR or $cidsA){
		if($cidsR){
			$database->setQuery("DELETE FROM #__fb_users WHERE userid in ($idsR)");
			if(!$database->query()){
				echo "<script> alert('" . _FB_ERRORSYNCUSERS . " " . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
				exit();
			}
		}
		if($cidsA){
			for($j = 0, $m = count($allIDsA); $j < $m; $j++){
				$database->setQuery("INSERT INTO #__fb_users (userid) " . "\nVALUES ($allIDsA[$j])");

				if(!$database->query()){
					echo "<script> alert('" . _FB_ERRORADDUSERS . " " . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
					exit();
				}
			}
		}
		mosRedirect("index2.php?option=$option&task=pruneusers", "" . _FB_USERSSYNCDELETED . "" . $cidsA . " " . _FB_SYNCUSERPROFILES . "");
	} else{
		$cids = 0;
		mosRedirect("index2.php?option=$option&task=pruneusers", _FB_NOPROFILESFORSYNC);
	}
}

//===============================
// Upgrade tables to this version
//===============================
function upgradeTables($option){
	$fbConfig = FBJConfig::getInstance();
	$v = $fbConfig->version;
	mosRedirect("index2.php?option=com_fireboard", "" . _FB_TABLESUPGRADED . " $v.");
}

//===============================
// Load Sample Data
//===============================
function loadSample($database, $option){
	$query = "INSERT INTO `#__fb_categories` " . "\n (`id`, `parent`, `name`, `cat_emoticon`, `locked`, `alert_admin`, `moderated`, `moderators`, `pub_access`, `pub_recurse`, `admin_access`, `admin_recurse`, `ordering`, `future2`, `published`, `checked_out`, `checked_out_time`, `review`, `hits`, `description`, `id_last_msg`, `time_last_msg`, `numTopics`, `numPosts`)"
		. "\n VALUES (1, 0, 'Тестовый раздел (Уровень 1 категории)', 0, 0, 0, 1, NULL, 0, 1, 0, 1, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 'Описание для 1-го уровня категории.', 0, 0, 0, 0),"
		. "\n (2, 1, 'Уровень 2 категории', 0, 0, 0, 1, NULL, 0, 1, 0, 1, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 'Level 2 Category description.', 0, 0, 0, 0),"
		. "\n (3, 2, 'Уровень 3 категории A', 0, 0, 0, 1, NULL, 0, 1, 0, 1, 3, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '', 0, 0, 0, 0),"
		. "\n (4, 2, 'Уровень 3 категории B', 0, 0, 0, 1, NULL, 0, 1, 0, 1, 2, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '', 0, 0, 0, 0),"
		. "\n (5, 2, 'Уровень 3 категории C', 0, 0, 0, 1, NULL, 0, 1, 0, 1, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, '', 0, 0, 0, 0),"
		. "\n (6, 1, 'Тестовый закрытый форум', 0, 1, 0, 1, NULL, 0, 1, 0, 1, 2, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 'Только Модераторы и Админситраторы могу создавать новые темы или отвечать в этом форуме.', 0, 0, 0, 0),"
		. "\n (7, 1, 'Sample Review On Forum', 0, 0, 0, 1, NULL, 0, 1, 0, 1, 3, 0, 1, 0, '0000-00-00 00:00:00', 1, 0, 'Posts to be reviewed by Moderators prior to publishing them in this forum. This is useful in a Moderated forum only! If you set this without any Moderators specified, the Site Admin is solely responsible for approving/deleting submitted posts as these will be kept ''on hold''!', 0, 0, 0, 0)";
	$database->setQuery($query);
	if(!$database->query()){
		echo "<script> alert('" . $database->getErrorMsg() . " " . _FB_SAMPLWARN1 . "'); window.history.go(-1); </script>\n";
		exit();
	}
	$query = "INSERT INTO `#__fb_messages` " . "\n VALUES (1, 0, 1, 2, 'bestofjoomla', 0, 'anonymous@forum.here', 'Sample Post', 1178882702, '127.0.0.1', 0, 0, 0, 0, 1, 0, 0, 0, 0)";
	$database->setQuery($query);
	if(!$database->query()){
		echo "<script> alert('" . $database->getErrorMsg() . " " . _FB_SAMPLWARN1 . "'); window.history.go(-1); </script>\n";
		exit();
	}
	$query = "INSERT INTO `#__fb_messages_text` " . "\n VALUES (1, 'Fireboard is fully integrated forum solution for joomla, no bridges, no hacking core files: It can be installed just like any other component with only a few clicks.\r\n\r\nThe administration backend is fully integrated, native ACL implemented, and it has all the capabilities one would have come to expect from a mature, full-fledged forum solution!')";
	$database->setQuery($query);
	if(!$database->query()){
		echo "<script> alert('" . $database->getErrorMsg() . " " . _FB_SAMPLWARN1 . "'); window.history.go(-1); </script>\n";
		exit();
	}
	mosRedirect("index2.php?option=$option", _FB_SAMPLESUCCESS);
}

//===============================
// Remove Sample Data
//===============================
function removeSample($database, $option){
	$database->setQuery("DELETE FROM #__fb_categories WHERE id BETWEEN 1 AND 7");
	$database->query();
	$database->setQuery("DELETE FROM #__fb_messages WHERE id = 1");
	$database->query();
	$database->setQuery("DELETE FROM #__fb_messages_text WHERE id = 1");
	$database->query();
	mosRedirect("index2.php?option=$option", _FB_SAMPLEREMOVED);
}

//===============================
// Uploaded Images browser
//===============================
function browseUploaded($database, $option, $type){
	if($type){
		$dir = @opendir(FB_ABSUPLOADEDPATH . '/images');
		$uploaded_path = FB_ABSUPLOADEDPATH . '/images';
		$liveuploaded_path = FB_LIVEUPLOADEDPATH . '/images/';
	} else{
		$dir = @opendir(FB_ABSUPLOADEDPATH . '/files');
		$uploaded_path = FB_ABSUPLOADEDPATH . '/files';
		$liveuploaded_path = FB_LIVEUPLOADEDPATH . '/files/';
	}
	$uploaded = array();
	$uploaded_col_count = 0;
	while($file = @readdir($dir)){
		if($file != '.' && $file != '..' && is_file($uploaded_path . '/' . $file) && !is_link($uploaded_path . '/' . $file)){
			$uploaded[$uploaded_col_count] = $file;
			$uploaded_name[$uploaded_col_count] = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $file)));
			$uploaded_col_count++;
		}
	}
	@closedir($dir);
	@ksort($uploaded);
	@reset($uploaded);
	HTML_SIMPLEBOARD::browseUploaded($option, $uploaded, $uploaded_path, $liveuploaded_path, $type);
}

function replaceImage($database, $option, $imageName, $OxP){
	unlink(FB_ABSUPLOADEDPATH . '/images/' . $imageName);
	if($OxP == "1"){
		$filename = explode("\.", $imageName);
		$fileName = $filename[0];
		$fileExt = $filename[1];
		copy(FB_ABSUPLOADEDPATH . '/dummy.' . $fileExt, FB_ABSUPLOADEDPATH . '/images/' . $imageName);
	} else{
		$database->setQuery("DELETE FROM #__fb_attachments where filelocation='" . FB_ABSUPLOADEDPATH . "/images/" . $imageName . "'");
		$database->query();
	}
	mosRedirect("index2.php?option=$option&task=browseImages", _FB_IMGDELETED);
}

function deleteFile($database, $option, $fileName){
	unlink(FB_ABSUPLOADEDPATH . '/files/' . $fileName);
	$database->setQuery("DELETE FROM #__fb_attachments where filelocation='" . FB_ABSUPLOADEDPATH . "/files/" . $fileName . "'");
	$database->query();
	mosRedirect("index2.php?option=$option&task=browseFiles", _FB_FILEDELETED);
}

//===============================
// Generic Functions
//===============================
#########  category functions #########
function catTreeRecurse($id, $indent = "&nbsp;&nbsp;&nbsp;", $list, &$children, $maxlevel = 9999, $level = 0, $seperator = " >> "){
	if(@$children[$id] && $level <= $maxlevel){
		foreach($children[$id] as $v){
			$id = $v->id;
			$txt = $v->name;
			$pt = $v->parent;
			$list[$id] = $v;
			$list[$id]->treename = "$indent$txt";
			$list[$id]->children = count(@$children[$id]);
			$list = catTreeRecurse($id, "$indent$txt$seperator", $list, $children, $maxlevel, $level + 1);
		}
	}
	return $list;
}

function showCategories($cat, $cname, $extras = "", $levellimit = "4"){
	$database = FBJConfig::database();
	$database->setQuery("select id ,parent,name from
          #__fb_categories" . "\nORDER BY name");
	$mitems = $database->loadObjectList();
	$children = array();
	foreach($mitems as $v){
		$pt = $v->parent;
		$list = @$children[$pt] ? $children[$pt] : array();
		array_push($list, $v);
		$children[$pt] = $list;
	}
	$list = catTreeRecurse(0, '', array(), $children);
	$mitems = array();
	$mitems[] = mosHTML::makeOption('0', _FB_NOPARENT);
	$this_treename = '';
	foreach($list as $item){
		if($this_treename){
			if($item->id != $mitems && strpos($item->treename, $this_treename) === false){
				$mitems[] = mosHTML::makeOption($item->id, $item->treename);
			}
		} else{
			if($item->id != $mitems){
				$mitems[] = mosHTML::makeOption($item->id, $item->treename);
			} else{
				$this_treename = "$item->treename/";
			}
		}
	}
	$parlist = selectList2($mitems, $cname, 'class="inputbox"  ' . $extras, 'value', 'text', $cat);
	return $parlist;
}

#######################################
## multiple select list
function selectList2(&$arr, $tag_name, $tag_attribs, $key, $text, $selected){
	reset($arr);
	$html = "\n<select name=\"$tag_name\" ".$tag_attribs .">";
	for($i = 0, $n = count($arr); $i < $n; $i++){
		$k = $arr[$i]->$key;
		$t = $arr[$i]->$text;
		$id = @$arr[$i]->id;
		$extra = '';
		$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
		if(is_array($selected)){
			foreach($selected as $obj){
				$k2 = $obj;
				if($k == $k2){
					$extra .= " selected=\"selected\"";
					break;
				}
			}
		} else{
			$extra .= ($k == $selected ? " selected=\"selected\"" : '');
		}
		$html .= "\n\t<option value=\"" . $k . "\"$extra>" . $t . "</option>";
	}
	$html .= "\n</select>\n";
	return $html;
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
							$tmpstr = _FB_COPY_FILE;
							$tmpstr = str_replace('%src%', $srcfile, $tmpstr);
							$tmpstr = str_replace('%dst%', $dstfile, $tmpstr);
							echo $tmpstr;
						}
						if(copy($srcfile, $dstfile)){
							touch($dstfile, filemtime($srcfile));
							$num++;
							if($verbose){
								echo _FB_COPY_OK;
							}
						} else{
							echo "" . _FB_DIRCOPERR . " '$srcfile' " . _FB_DIRCOPERR1 . "";
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

//===============================
//   smiley functions
//===============================
/** @noinspection PhpInconsistentReturnPointsInspection */
function showsmilies($option){
	$database = FBJConfig::database();
	$limit = intval(mosGetParam($_POST, 'limit', 10));
	$limitstart = intval(mosGetParam($_POST, 'limitstart', 0));
	$database->setQuery("SELECT * FROM #__fb_smileys LIMIT $limitstart,$limit");
	$smileytmp = $database->loadObjectList();
	if($database->getErrorNum()){
		echo $database->stderr();
		return false;
	}
	$database->setQuery("SELECT COUNT(*) FROM #__fb_smileys");
	$total = $database->loadResult();
	$smileypath = smileypath();
	if($limit > $total){
		$limitstart = 0;
	}
	require_once ("includes/pageNavigation.php");
	$pageNavSP = new mosPageNav($total, $limitstart, $limit);
	HTML_SIMPLEBOARD::showsmilies($option, $smileytmp, $pageNavSP, $smileypath);
}

function editsmiley($option, $id){
	$mosConfig_lang = FBJConfig::getCfg('lang');
	$database = FBJConfig::database();
	$database->setQuery("SELECT * FROM #__fb_smileys WHERE id = $id");
	$smileytmp = $database->loadAssocList();
	$smileycfg = $smileytmp[0];
	$smiley_images = collect_smilies();
	$smileypath = smileypath();
	$smileypath = $smileypath['live'] . '/';
	$filename_list = "";
	for($i = 0; $i < count($smiley_images); $i++){
		if($smiley_images[$i] == $smileycfg['location']){
			$smiley_selected = "selected=\"selected\"";
			$smiley_edit_img = $smileypath . $smiley_images[$i];
		} else{
			$smiley_selected = "";
		}
		$filename_list .= '<option value="' . $smiley_images[$i] . '"' . $smiley_selected . '>' . $smiley_images[$i] . '</option>' . "\n";
	}
	HTML_SIMPLEBOARD::editsmiley($option, $mosConfig_lang, $smiley_edit_img, $filename_list, $smileypath, $smileycfg);
}

function newsmiley($option){
	$smiley_images = collect_smilies();
	$smileypath = smileypath();
	$smileypath = $smileypath['live'] . '/';
	$filename_list = "";
	for($i = 0; $i < count($smiley_images); $i++){
		$filename_list .= '<option value="' . $smiley_images[$i] . '">' . $smiley_images[$i] . '</option>' . "\n";
	}
	HTML_SIMPLEBOARD::newsmiley($option, $filename_list, $smileypath);
}

function savesmiley($option, $id = NULL){
	$database = FBJConfig::database();
	$smiley_code = mosGetParam($_POST, 'smiley_code');
	$smiley_location = mosGetParam($_POST, 'smiley_url');
	$smiley_emoticonbar = (mosGetParam($_POST, 'smiley_emoticonbar')) ? mosGetParam($_POST, 'smiley_emoticonbar') : 0;
	if(empty($smiley_code) || empty($smiley_location)){
		$task = ($id == NULL) ? 'newsmiley' : 'editsmiley&id=' . $id;
		mosRedirect("index2.php?option=$option&task=" . $task, _FB_MISSING_PARAMETER);
		exit();
	}
	$database->setQuery("SELECT * FROM #__fb_smileys");
	$smilies = $database->loadAssocList();
	foreach($smilies as $value){
		if(in_array($smiley_code, $value) && !($value['id'] == $id)){
			$task = ($id == NULL) ? 'newsmiley' : 'editsmiley&id=' . $id;
			mosRedirect("index2.php?option=$option&task=" . $task, _FB_CODE_ALLREADY_EXITS);
			exit();
		}
	}
	if($id == NULL){
		$database->setQuery("INSERT INTO #__fb_smileys SET code = '$smiley_code', location = '$smiley_location', emoticonbar = '$smiley_emoticonbar'");
	} else{
		$database->setQuery("UPDATE #__fb_smileys SET code = '$smiley_code', location = '$smiley_location', emoticonbar = '$smiley_emoticonbar' WHERE id = $id");
	}
	if(!$database->query()){
		$task = ($id == NULL) ? 'newsmiley' : 'editsmiley&id=' . $id;
		mosRedirect("index2.php?option=$option&task=" . $task, $database->getErrorMsg());
		exit();
	} else{
		mosRedirect("index2.php?option=$option&task=showsmilies", _FB_SMILEY_SAVED);
	}
}

function deletesmiley($option, $id){
	$database = FBJConfig::database();
	$database->setQuery("DELETE FROM #__fb_smileys WHERE id = '$id'");
	$database->query();
	mosRedirect("index2.php?option=$option&task=showsmilies", _FB_SMILEY_DELETED);
}

function smileypath(){
	$mosConfig_lang = FBJConfig::getCfg('lang');
	$mainframe = FBJConfig::mainframe();
	$fbConfig = FBJConfig::getInstance();
	if(is_dir($mainframe->getCfg('absolute_path') . '/components/com_fireboard/template/' . $fbConfig->template . '/images/' . $mosConfig_lang . '/emoticons')){
		$smiley_live_path = $mainframe->getCfg('live_site') . '/components/com_fireboard/template/' . $fbConfig->template . '/images/' . $mosConfig_lang . '/emoticons';
		$smiley_abs_path = $mainframe->getCfg('absolute_path') . '/components/com_fireboard/template/' . $fbConfig->template . '/images/' . $mosConfig_lang . '/emoticons';
	} else{
		$smiley_live_path = $mainframe->getCfg('live_site') . '/components/com_fireboard/template/default/images/' . $mosConfig_lang . '/emoticons';
		$smiley_abs_path = $mainframe->getCfg('absolute_path') . '/components/com_fireboard/template/default/images/' . $mosConfig_lang . '/emoticons';
	}
	$smileypath['live'] = $smiley_live_path;
	$smileypath['abs'] = $smiley_abs_path;
	return $smileypath;
}

function collect_smilies(){
	$smileypath = smileypath();
	$dir = @opendir($smileypath['abs']);
	while($file = @readdir($dir)){
		if(!@is_dir($smiley_abs_path . '/' . $file)){
			$img_size = @getimagesize($smileypath['abs'] . '/' . $file);
			if($img_size[0] && $img_size[1]){
				$smiley_images[] = $file;
			}
		}
	}
	@closedir($dir);
	return $smiley_images;
}

function showRanks($option, $order){
	$database = FBJConfig::database();
	$limit = intval(mosGetParam($_POST, 'limit', 10));
	$limitstart = intval(mosGetParam($_POST, 'limitstart', 0));
	$database->setQuery("SELECT * FROM #__fb_ranks LIMIT $limitstart,$limit");
	$ranks = $database->loadObjectList();
	$database->setQuery("SELECT COUNT(*) FROM #__fb_ranks");
	$total = $database->loadResult();
	$rankpath = rankpath();
	if($limit > $total){
		$limitstart = 0;
	}
	require_once("includes/pageNavigation.php");
	$pageNavSP = new mosPageNav($total, $limitstart, $limit);
	HTML_SIMPLEBOARD::showRanks($option, $ranks, $pageNavSP, $rankpath);
}

function rankpath(){
	$mosConfig_lang = FBJConfig::getCfg('lang');
	$mainframe = FBJConfig::mainframe();
	$fbConfig = FBJConfig::getInstance();
	if(is_dir($mainframe->getCfg('absolute_path') . '/components/com_fireboard/template/' . $fbConfig->template . '/images/' . $mosConfig_lang . '/ranks')){
		$rank_live_path = $mainframe->getCfg('live_site') . '/components/com_fireboard/template/' . $fbConfig->template . '/images/' . $mosConfig_lang . '/ranks';
		$rank_abs_path = $mainframe->getCfg('absolute_path') . '/components/com_fireboard/template/' . $fbConfig->template . '/images/' . $mosConfig_lang . '/ranks';
	} else{
		$rank_live_path = $mainframe->getCfg('live_site') . '/components/com_fireboard/template/default/images/' . $mosConfig_lang . '/ranks';
		$rank_abs_path = $mainframe->getCfg('absolute_path') . '/components/com_fireboard/template/default/images/' . $mosConfig_lang . '/ranks';
	}
	$rankpath['live'] = $rank_live_path;
	$rankpath['abs'] = $rank_abs_path;
	return $rankpath;
}

function collectRanks(){
	$rankpath = rankpath();
	$dir = @opendir($rankpath['abs']);
	while($file = @readdir($dir)){
		if(!@is_dir($rank_abs_path . '/' . $file)){
			$img_size = @getimagesize($rankpath['abs'] . '/' . $file);
			if($img_size[0] && $img_size[1]){
				$rank_images[] = $file;
			}
		}
	}
	@closedir($dir);
	return $rank_images;
}

function newRank($option){
	$rank_images = collectRanks();
	$rankpath = rankpath();
	$rankpath = $rankpath['live'] . '/';
	$filename_list = "";
	foreach($rank_images as $id => $row){
		$filename_list .= '<option value="' . $rank_images[$id] . '">' . $rank_images[$id] . '</option>' . "\n";
	}
	HTML_SIMPLEBOARD::newRank($option, $filename_list, $rankpath);
}

function deleteRank($option, $id){
	$database = FBJConfig::database();
	$database->setQuery("DELETE FROM #__fb_ranks WHERE rank_id = '".$id."'");
	$database->query();
	mosRedirect("index2.php?option=$option&task=ranks", _FB_RANK_DELETED);
}

function saveRank($option, $id = NULL){
	$database = FBJConfig::database();
	$rank_title = mosGetParam($_POST, 'rank_title');
	$rank_image = mosGetParam($_POST, 'rank_image');
	$rank_special = mosGetParam($_POST, 'rank_special');
	$rank_min = mosGetParam($_POST, 'rank_min');
	if(empty($rank_title) || empty($rank_image)){
		$task = ($id == NULL) ? 'newRank' : 'editRank&id=' . $id;
		mosRedirect("index2.php?option=$option&task=" . $task, _FB_MISSING_PARAMETER);
		exit();
	}
	$database->setQuery("SELECT * FROM #__fb_ranks");
	$ranks = $database->loadAssocList();
	foreach($ranks as $value){
		if(in_array($rank_title, $value) && !($value['rank_id'] == $id)){
			$task = ($id == NULL) ? 'newRank' : 'editRank&id=' . $id;
			mosRedirect("index2.php?option=$option&task=" . $task, _FB_RANK_ALLREADY_EXITS);
			exit();
		}
	}
	if($id == NULL){
		$database->setQuery("INSERT INTO #__fb_ranks SET rank_title = '$rank_title', rank_image = '$rank_image', rank_special = '$rank_special', rank_min = '$rank_min'");
	} else{
		$database->setQuery("UPDATE #__fb_ranks SET rank_title = '$rank_title', rank_image = '$rank_image', rank_special = '$rank_special', rank_min = '$rank_min' WHERE rank_id = $id");
	}
	if(!$database->query()){
		$task = ($id == NULL) ? 'newRank' : 'editRank&id=' . $id;
		mosRedirect("index2.php?option=$option&task=" . $task, $database->getErrorMsg());
		exit();
	} else{
		mosRedirect("index2.php?option=$option&task=ranks", _FB_RANK_SAVED);
	}
}

function editRank($option, $id){
	$database = FBJConfig::database();
	$database->setQuery("SELECT * FROM #__fb_ranks WHERE rank_id = '$id'");
	$ranks = $database->loadObjectList();
	$rank_images = collectRanks();
	$path = rankpath();
	$path = $path['live'] . '/';
	$edit_img = $filename_list = '';
	foreach($ranks as $row){
		foreach($rank_images as $img){
			$image = $path . $img;
			if($img == $row->rank_image){
				$selected = ' selected="selected"';
				$edit_img = $img;
			} else{
				$selected = '';
			}
			if(strlen($img) > 255){
				continue;
			}
			$filename_list .= '<option value="' . htmlspecialchars($img) . '"' . $selected . '>' . $img . '</option>';
		}
	}
	HTML_SIMPLEBOARD::editRank($option, $edit_img, $filename_list, $path, $row);
}

function FB_GetAvailableModCats($catids){
	$list = JJ_categoryArray(1);
	$this_treename = '';
	$catid = 0;
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
	$parent = mosHTML::selectList($options, 'catid[]', 'class="inputbox fbs"  multiple="multiple"   id="FB_AvailableForums" ', 'value', 'text', $catids);
	return $parent;
}

function FB_gdVersion(){
	if(!extension_loaded('gd')){
		/** @noinspection PhpInconsistentReturnPointsInspection */
		return;
	}
	$phpver = substr(phpversion(), 0, 3);
	if($phpver < 4.3) return -1;
	if(function_exists('gd_info')){
		$ver_info = gd_info();
		preg_match('/\d/', $ver_info['GD Version'], $match);
		$gd_ver = $match[0];
		return $match[0];
	} else{
		/** @noinspection PhpInconsistentReturnPointsInspection */
		return;
	}
}

//////////////////////////////////////////// FB 1.9
function reupgrade(){
	$mainframe = FBJConfig::mainframe();
	$database = FBJConfig::database();
	$database->setQuery("ALTER TABLE #__fb_messages ADD KEY `ip` (`ip`);");
	$database->query();
	$output = '';
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_messages ADD KEY `userid` (`userid`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_messages ADD KEY `time` (`time`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_messages ADD KEY `locked` (`locked`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_messages ADD KEY `hold_time` (`hold`, `time`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_attachments ADD KEY `mesid` (`mesid`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE `#__fb_categories` CHANGE `moderated` `moderated` TINYINT( 4 ) NOT NULL DEFAULT '1';");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE `#__fb_categories` ADD COLUMN `id_last_msg` int(10) NOT NULL DEFAULT '0';");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$aaa = $database->setQuery("ALTER TABLE `#__fb_categories` ADD COLUMN `numTopics` mediumint(8) NOT NULL DEFAULT '0';");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE `#__fb_categories` ADD COLUMN `numPosts` mediumint(8) NOT NULL DEFAULT '0';");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE `#__fb_categories` ADD COLUMN `time_last_msg` int(11) DEFAULT NULL;");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_categories ADD PRIMARY KEY (`id`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$aaa = $database->setQuery("ALTER TABLE `#__fb_categories` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT;");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_categories ADD KEY `parent` (`parent`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_categories ADD KEY `published_pubaccess_id` (`published`,`pub_access`,`id`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_categories ADD KEY `msg_id` (`id_last_msg`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_messages_text ADD PRIMARY KEY (`mesid`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_moderation ADD PRIMARY KEY (`catid`,`userid`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_sessions ADD PRIMARY KEY (`userid`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_smileys ADD PRIMARY KEY (`id`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE `#__fb_smileys` CHANGE `id` `id` INT( 4 ) NOT NULL AUTO_INCREMENT;");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_subscriptions ADD KEY `thread` (`thread`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_subscriptions ADD KEY `userid` (`userid`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_users ADD PRIMARY KEY (`userid`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_users ADD `GTALK` varchar(50) default NULL, ADD `websitename` varchar(50) default NULL, ADD `websiteurl` varchar(50) default NULL, ADD `rank` tinyint(4) NOT NULL default '0', ADD `hideEmail` tinyint(1) NOT NULL default '1', ADD `showOnline` tinyint(1) NOT NULL default '1', ADD `ban` tinyint(1) NOT NULL default '0'");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("ALTER TABLE #__fb_users ADD KEY `group_id` (`group_id`);");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("UPDATE #__fb_users  SET `rank`=8 WHERE `moderator`=1 AND `rank`=0;");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("alter table `#__fb_categories` add column `headerdesc` text NOT NULL  after `description`, COMMENT='';");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("alter table `#__fb_categories` add column `class_sfx` varchar(20) NOT NULL after `headerdesc`, COMMENT='';");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	dircopy(JPATH_BASE . "/components/com_fireboard/uploaded/files", JPATH_BASE . "/images/fbfiles/files", false);
	dircopy(JPATH_BASE . "/components/com_fireboard/uploaded/images", JPATH_BASE . "/images/fbfiles/images", false);
	dircopy(JPATH_BASE . "/components/com_fireboard/avatars", JPATH_BASE . "/images/fbfiles/avatars", false);
	$database->setQuery("update #__fb_attachments set filelocation = replace(filelocation,'" . $mainframe->getCfg("absolute_path") . "/components/com_fireboard/uploaded','/images/fbfiles');");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("CREATE TABLE `#__fb_polls` (`pollid` int(11) NOT NULL AUTO_INCREMENT, `threadid` VARCHAR( 11 ) DEFAULT '0' NOT NULL, `avtorid` int(11) NOT NULL default '0', `vopros` text, `closed` INT( 1 ) NOT NULL DEFAULT '0', KEY `pollid` (`pollid`))");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("CREATE TABLE `#__fb_pollsotvet` (`poll_id` int(11) DEFAULT '0' NOT NULL, `pollotvet` text, KEY `poll_id` (`poll_id`))");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	$database->setQuery("CREATE TABLE `#__fb_pollsresults` (`answerid` int(11) NOT NULL AUTO_INCREMENT, `threadid` VARCHAR( 11 ) DEFAULT '0' NOT NULL, `answeruserid` int(11) DEFAULT '0' NOT NULL, `answer` INT( 1 ) NOT NULL, KEY `answerid` (`answerid`))");
	$database->query();
	if($database->getErrorNum()){
		$output .= "<div style=\"color:#bb0000; font-weight:bold; font-size:12px\">";
		$output .= $database->getErrorMsg() . "</div>";
	} else{
		$output .= '<div style="color:#bb0000; font-weight:bold; font-size:12px">Успешно!</div>';
	}
	echo $output;
	die;
}

function showGroups($option){
	$database = FBJConfig::database();
	$database->setQuery("SELECT * FROM #__fb_groups");
	$groups = $database->loadObjectList();
	HTML_SIMPLEBOARD::showGroups($option, $groups);
}

function banuser($banid){
	$database = FBJConfig::database();
	$banid = intval(mosGetParam($_REQUEST, 'banid', 0));
	if($banid){
		$database->setQuery("SELECT ban FROM #__fb_users WHERE userid=" . $banid);
		$ban = $database->loadResult();
		if($ban){
			$database->setQuery("UPDATE #__fb_users SET ban=0 WHERE userid=$banid");
			$aaa = $database->loadResult();
			if($database->getErrorNum()){
				$msg = $database->getErrorMsg();
			} else{
				$msg = _AFB_BAN_REMOVED . ': ' . $banid;
			}
		} else{
			$database->setQuery("UPDATE #__fb_users SET ban=1 WHERE userid=$banid");
			$aaa = $database->loadResult();
			if($database->getErrorNum()){
				$msg = $database->getErrorMsg();
			} else{
				$msg = _AFB_BAN_ADDED . ': ' . $banid;
			}
		}
	} else{
		$msg = _AFB_NOTUSER;
	}
	mosRedirect("index2.php?option=com_fireboard&task=showprofiles", $msg);
}

function resetPuzzle(){
	$database = FBJConfig::database();
	$database->setQuery("DELETE FROM #__fb_puzzle");
	$database->query();
	mosRedirect("index2.php?option=com_fireboard&task=showconfig", _AFB_PUZZ_RESETED);
}

?>