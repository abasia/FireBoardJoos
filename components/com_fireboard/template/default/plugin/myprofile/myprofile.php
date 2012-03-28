<?php
/**
 * @version $Id: myprofile.php 506 2007-12-18 08:24:42Z danialt $
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
if($my->id != "" && $my->id != 0){
	if(!$fbConfig->cb_profile){
		$juserinfo = new mosUser($database);
		$juserinfo->load($my->id);
		$userinfo = new fbUserprofile($database);
		$userinfo->load($my->id);
		if($fbConfig->avatar_src == "joostina"){
			$database->setQuery("SELECT picture FROM #__mypms_profiles WHERE userid='$my->id'");
			$avatar = $database->loadResult();
		}else{
			$avatar = $fbavatar;
		}
		$ugid = $userinfo->gid;
		$uIsMod = 0;
		$uIsAdm = 0;
		if($ugid > 0){
			$agrp = strtolower($acl->get_group_name($ugid, 'ARO'));
		}
		if($ugid == 0){
			$usr_usertype = _VIEW_VISITOR;
		} else{
			if(strtolower($agrp) == "administrator" || strtolower($agrp) == "superadministrator" || strtolower($agrp) == "super administrator"){
				$usr_usertype = _VIEW_ADMIN;
				$uIsAdm = 1;
			} elseif($uIsMod){
				$usr_usertype = _VIEW_MODERATOR;
			} else{
				$usr_usertype = _VIEW_USER;
			}
		}
		$database->setQuery("SELECT max(posts) from #__fb_users");
		$maxPosts = $database->loadResult();
		$numPosts = (int)$userinfo->posts;
		$ordering = $userinfo->ordering;
		$hideEmail = $userinfo->hideEmail;
		$showOnline = $userinfo->showOnline;
	}
	?>
<!-- B:My Profile -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="fb_myprofile_left" valign="top" width="20%">
	<!-- B:My Profile Left -->
	<?php
	if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_menu.php')){
		include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_menu.php');
	} else{
		include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_menu.php');
	}
	?>
	<!-- F:My Profile Left -->
</td>
<td class="fb_myprofile_mid" valign="top" width="5">&nbsp;
</td>
<td class="fb_myprofile_right" valign="top">
<!-- B:My Profile Right -->
	<?php
	switch($do){
		case "show":
		default:
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_summary.php')){
				include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_summary.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_summary.php');
			}
			break;
		case "foto":
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/foto/foto.php')){
				include (JB_ABSTMPLTPATH . '/plugin/foto/foto.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/foto/foto.php');
			}
			break;
		case "showmsg":
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_msg.php')){
				include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_msg.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_msg.php');
			}
			break;
		case "showavatar":
			if(!$fbConfig->cb_profile){
				if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_avatar.php')){
					include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_avatar.php');
				} else{
					include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_avatar.php');
				}
			}
			break;
		case "updateavatar":
			$rowItemid = mosGetParam($_REQUEST, 'Itemid');
			$deleteAvatar = mosGetParam($_POST, 'deleteAvatar', 0);
			$avatar = mosGetParam($_POST, 'avatar', '');
			if($deleteAvatar == 1){
				$avatar = "";
			}
			$database->setQuery("UPDATE #__fb_users set   avatar='$avatar'  where userid=$my_id");
			if(!$database->query()){
				echo _USER_PROFILE_NOT_A . " <strong><span style='color:red'>" . _USER_PROFILE_NOT_B . "</span></strong> " . _USER_PROFILE_NOT_C . ".<br /><br />";
			} else{
				echo _USER_PROFILE_UPDATED . "<br /><br />";
			}
			echo _USER_RETURN_A . '<a href="' . sefRelToAbs(JB_LIVEURLREL . "&amp;func=uploadavatar") . '">' . _USER_RETURN_B . "</a><br /><br />";
			?>
			<script type="text/javascript">
				document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=uploadavatar');?>';
			</script>
				<?php
			break;
		case "showset":
			if(!$fbConfig->cb_profile){
				if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_set.php')){
					include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_set.php');
				} else{
					include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_set.php');
				}
			}
			break;
		case "updateset":
			$rowItemid = mosGetParam($_REQUEST, 'Itemid');
			$newview = mosGetParam($_POST, 'newview', 'flat');
			$neworder = intval(mosGetParam($_POST, 'neworder', 0));
			$newhideEmail = intval(mosGetParam($_POST, 'newhideEmail', 1));
			$newshowOnline = intval(mosGetParam($_POST, 'newshowOnline', 1));
			$database->setQuery("UPDATE #__fb_users set  view='$newview', ordering='$neworder', hideEmail='$newhideEmail', showOnline='$newshowOnline'  where userid=$my_id");
			setcookie("fboard_settings[current_view]", $newview);
			if(!$database->query()){
				echo _USER_PROFILE_NOT_A . " <strong><span style='color:red'>" . _USER_PROFILE_NOT_B . "</span></strong> " . _USER_PROFILE_NOT_C . ".<br /><br />";
			} else{
				echo _USER_PROFILE_UPDATED . "<br /><br />";
			}
			echo _USER_RETURN_A . ' <a href="' . sefRelToAbs(JB_LIVEURLREL . "&amp;func=myprofile&amp;do=showset") . '">' . _USER_RETURN_B . "</a><br /><br />";
			?>
			<script language="javascript">
				document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=myprofile&do=showset');?>';
			</script>
				<?php
			break;
		case "profileinfo":
			$bd = @explode("-", $userinfo->birthdate);
			$ulists["year"] = $bd[0];
			$ulists["month"] = $bd[1];
			$ulists["day"] = $bd[2];
			$genders[] = mosHTML::makeOption("", "");
			$genders[] = mosHTML::makeOption("1", _FB_MYPROFILE_MALE);
			$genders[] = mosHTML::makeOption("2", _FB_MYPROFILE_FEMALE);
			$ulists["gender"] = mosHTML::selectList($genders, 'gender', 'class="inputbox"', 'value', 'text', $userinfo->gender);
			if(!$fbConfig->cb_profile){
				include (JB_ABSSOURCESPATH . 'fb_bb.js.php');
				if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_profile_info.php')){
					include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_profile_info.php');
				} else{
					include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_profile_info.php');
				}
			}
			break;
		case "saveprofileinfo":
			$user_id = intval(mosGetParam($_POST, 'id', 0));
			if($my->id == 0 || $user_id == 0 || $user_id != $my->id){
				mosNotAuth();
				return;
			}
			josSpoofCheck();
			$rowu = new fbUserprofile($database);
			$rowu->load((int)$user_id);
			$deleteSig = mosGetParam($_POST, 'deleteSig', 0);
			$signature = mosGetParam($_POST, 'message', null, _MOS_ALLOWRAW);
			$bday1 = mosGetParam($_POST, 'bday1', '0000');
			$bday2 = mosGetParam($_POST, 'bday2', '00');
			$bday3 = mosGetParam($_POST, 'bday3', '00');
			if(!$rowu->bind($_POST, 'moderator posts karma group_id uhits')){
				echo "<script> alert('" . $rowu->getError() . "'); window.history.go(-1); </script>\n";
				exit();
			}
			$rowu->birthdate = $bday1 . "-" . $bday2 . "-" . $bday3;
			$signature = trim(addslashes($signature));
			$rowu->signature = $signature;
			if($deleteSig == 1){
				$rowu->signature = "";
			}
			if(!$rowu->check()){
				echo "<script> alert('" . $rowu->getError() . "'); window.history.go(-1); </script>\n";
				exit();
			}
			if(!$rowu->store()){
				echo "<script> alert('" . $rowu->getError() . "'); window.history.go(-1); </script>\n";
				exit();
			}
			echo _USER_RETURN_A . ' <a href="' . sefRelToAbs(JB_LIVEURLREL . "&amp;func=myprofile&amp;do=showsig") . '">' . _USER_RETURN_B . "</a><br /><br />";
			?>
			<script language="javascript">
				document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=myprofile&do=profileinfo');?>';
			</script>
				<?php
			break;
		case "showsub":
			$pageperlistlm = 15;
			$limit = intval(trim(mosGetParam($_REQUEST, 'limit', $pageperlistlm)));
			$limitstart = intval(trim(mosGetParam($_REQUEST, 'limitstart', 0)));
			$query = "select thread from #__fb_subscriptions where userid=$my->id";
			$database->setQuery($query);
			$total = count($database->loadObjectList());
			if($total <= $limit){
				$limitstart = 0;
			}
			$database->setQuery("select thread from #__fb_subscriptions where userid=$my->id ORDER BY thread DESC LIMIT $limitstart, $limit");
			$subslist = $database->loadObjectList();
			$csubslist = count($subslist);
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_subs.php')){
				include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_subs.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_subs.php');
			}
			break;
		case "showfav":
			$pageperlistlm = 15;
			$limit = intval(trim(mosGetParam($_REQUEST, 'limit', $pageperlistlm)));
			$limitstart = intval(trim(mosGetParam($_REQUEST, 'limitstart', 0)));
			$query = "select thread from #__fb_favorites where userid=$my->id";
			$database->setQuery($query);
			$total = count($database->loadObjectList());
			if($total <= $limit){
				$limitstart = 0;
			}
			$database->setQuery("select thread from #__fb_favorites where userid=$my->id ORDER BY thread DESC LIMIT $limitstart, $limit");
			$favslist = $database->loadObjectList();
			$cfavslist = count($favslist);
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_fav.php')){
				include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_fav.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_fav.php');
			}

			break;

		case "showmod":
			if(!$is_admin){
				$database->setQuery("select #__fb_moderation.catid,#__fb_categories.name from #__fb_moderation left join #__fb_categories on #__fb_categories.id=#__fb_moderation.catid where #__fb_moderation.userid=$my->id");
				$modslist = $database->loadObjectList();
				$cmodslist = count($modslist);
			}
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_mod.php')){
				include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_mod.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_mod.php');
			}
			break;
		case "unsubscribe":
			$cid = mosGetParam($_REQUEST, "cid", array());
			@array_walk($cid, "intval");
			$cids = @implode(',', $cid);
			$database->setQuery("DELETE FROM #__fb_subscriptions WHERE  userid=$my->id  AND thread in ($cids) ");
			if(!$database->query()){
				echo _USER_UNSUBSCRIBE_A . " <strong><span style='color:red'>" . _USER_UNSUBSCRIBE_B . "</span></strong> " . _USER_UNSUBSCRIBE_C . ".<br /><br />";
			} else{
				echo _USER_UNSUBSCRIBE_YES . ".<br /><br />";
			}
			if($fbConfig->cb_profile){
				echo _USER_RETURN_A . " <a href=\"index.php?option=com_comprofiler&amp;Itemid='" . FB_CB_ITEMID . "'&amp;tab=getForumTab\">" . _USER_RETURN_B . "</a><br /><br />";
				?>
			<script language="javascript">
				document.location = 'index.php?option=com_comprofiler<?php echo FB_CB_ITEMID_SUFFIX; ?>&tab=getForumTab';
			</script>
				<?php
			} else{
				echo _USER_RETURN_A . " <a href=\"" . sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=showsub') . "\">" . _USER_RETURN_B . "</a><br /><br />";
				?>
			<script language="javascript">
				document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=myprofile&do=showsub');?>';
			</script>
				<?php
			}
			break;
		case "unsubscribeitem":
			$database->setQuery("DELETE from #__fb_subscriptions where userid=$my->id and thread=$thread");
			if(!$database->query()){
				echo _USER_UNSUBSCRIBE_A . "<strong><span style='color:red'>" . _USER_UNSUBSCRIBE_B . "</span></strong> " . _USER_UNSUBSCRIBE_C . ".<br /><br />";
			} else{
				echo _USER_UNSUBSCRIBE_YES . ".<br /><br />";
			}
			if($fbConfig->cb_profile){
				echo _USER_RETURN_A . " <a href=\"index.php?option=com_comprofiler&amp;Itemid='" . FB_CB_ITEMID . "'&amp;tab=getForumTab\">" . _USER_RETURN_B . "</a><br /><br />";
				?>
			<script language="javascript">
				document.location = 'index.php?option=com_comprofiler<?php echo FB_CB_ITEMID_SUFFIX; ?>&tab=getForumTab';
			</script>
			<a href="javascript:history.go(-1)"><?php echo _BACK;?></a>
				<?php
			} else{
				echo _USER_RETURN_A . " <a href=\"" . sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=show') . "\">" . _USER_RETURN_B . "</a><br /><br />";
				?>
			<script language="javascript">
				document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=myprofile&do=show');?>';
			</script>
			<a href="javascript:history.go(-1)"><?php echo _BACK;?></a>
				<?php
			}
			break;
		case "unfavorite":
			$cid = mosGetParam($_REQUEST, "cid", array());
			@array_walk($cid, "intval");
			$cids = @implode(',', $cid);
			$database->setQuery("DELETE from #__fb_favorites where userid=$my->id  AND thread in ($cids)");
			if(!$database->query()){
				echo _USER_UNFAVORITE_A . " <strong><span style='color:red'>" . _USER_UNFAVORITE_B . "</span></strong> " . _USER_UNFAVORITE_C . ".<br /><br />";
			} else{
				echo _USER_UNFAVORITE_YES . ".<br /><br />";
			}
			if($fbConfig->cb_profile){
				echo _USER_RETURN_A . " <a href=\"index.php?option=com_comprofiler" . FB_CB_ITEMID_SUFFIX . "&amp;tab=getForumTab\">" . _USER_RETURN_B . "</a><br /><br />";
				?>
			<script language="javascript">
				document.location = 'index.php?option=com_comprofiler".FB_CB_ITEMID_SUFFIX."&tab=getForumTab';
			</script>
				<?php
			} else{
				echo _USER_RETURN_A . " <a href=\"" . sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=showfav') . "\">" . _USER_RETURN_B . "</a><br /><br />";
				?>
			<script language="javascript">
				document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=myprofile&do=showfav');?>';
			</script>
				<?php // B: unfavoriteall
			}
			break;
		case "unfavoriteitem":
			$database->setQuery("DELETE from #__fb_favorites where userid=$my->id and thread=$thread");
			if(!$database->query()){
				echo _USER_UNFAVORITE_A . " <strong><span style='color:red'>" . _USER_UNFAVORITE_B . "</span></strong> " . _USER_UNFAVORITE_C . ".<br /><br />";
			} else{
				echo _USER_UNFAVORITE_YES . ".<br /><br />";
			}
			if($fbConfig->cb_profile){
				echo _USER_RETURN_A . " <a href=\"index.php?option=com_comprofiler" . FB_CB_ITEMID_SUFFIX . "&amp;tab=getForumTab\">" . _USER_RETURN_B . "</a><br /><br />";
				?>
			<script language="javascript">
				document.location = 'index.php?option=com_comprofiler".FB_CB_ITEMID_SUFFIX."&tab=getForumTab';
			</script>
			<a href="javascript:history.go(-1)"><?php echo _BACK;?></a>
				<?php
			} else{
				echo _USER_RETURN_A . " <a href=\"index.php?option=com_fireboard&amp;Itemid=$Itemid&amp;func=myprofile&amp;do=show\">" . _USER_RETURN_B . "</a><br /><br />";
				?>
			<a href="javascript:history.go(-1)"><?php echo _BACK;?></a>
			<script language="javascript">
				document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=myprofile&do=show');?>';
			</script>
				<?php
			}
			break;
		case "userdetails":
			require_once ($mainframe->getCfg("absolute_path") . '/components/com_users/users.class.php');
			$row = new mosUser($database);
			$row->load((int)$my->id);
			$row->orig_password = $row->password;
			$row->name = trim($row->name);
			$row->email = trim($row->email);
			$row->username = trim($row->username);
			$file = $mainframe->getPath('com_xml', 'com_users');
			$params = new mosUserParameters($row->params, $file, 'component');
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_userdetails_form.php')){
				include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_userdetails_form.php');
			} else{
				include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_userdetails_form.php');
			}
			break;
		case "usersave":
			$user_id = intval(mosGetParam($_POST, 'id', 0));
			$uid = $my->id;
			if($uid == 0 || $user_id == 0 || $user_id != $uid){
				mosNotAuth();
				return;
			}
			josSpoofCheck();
			$row = new mosUser($database);
			$row->load((int)$user_id);
			$orig_password = $row->password;
			$orig_username = $row->username;
			if(!$row->bind($_POST, 'gid usertype')){
				echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
				exit();
			}
			$row->name = trim($row->name);
			$row->email = trim($row->email);
			$row->username = trim($row->username);
			mosMakeHtmlSafe($row);
			if(isset($_POST['password']) && $_POST['password'] != ''){
				if(isset($_POST['verifyPass']) && ($_POST['verifyPass'] == $_POST['password'])){
					$row->password = trim($row->password);
					$password = md5($row->password);
					$joomlaVersion = new joomlaVersion();
					if($joomlaVersion->getShortVersion() < "1.0.13"){
						$row->password = md5($row->password);
					} else{
						$salt = mosMakePassword(16);
						$crypt = md5($row->password . $salt);
						$row->password = $crypt . ':' . $salt;
					}
				} else{
					echo "<script> alert(\"" . addslashes(_PASS_MATCH) . "\"); window.history.go(-1); </script>\n";
					exit();
				}
			} else{
				$row->password = $orig_password;
			}
			if($mosConfig_frontend_userparams == '1' || $mosConfig_frontend_userparams == 1 || $mosConfig_frontend_userparams == NULL){
				$params = mosGetParam($_POST, 'params', '');
				if(is_array($params)){
					$txt = array();
					foreach($params as $k => $v){
						$txt[] = "$k=$v";
					}
					$row->params = implode("\n", $txt);
				}
			}
			if(!$row->check()){
				echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
				exit();
			}
			if(!$row->store()){
				echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
				exit();
			}
			if($orig_username != $row->username){
				$query = "UPDATE #__session" . "\n SET username = " . $database->Quote($row->username) . "\n WHERE username = " . $database->Quote($orig_username) . "\n AND userid = " . (int)$my->id . "\n AND gid = " . (int)$my->gid . "\n AND guest = 0";
				$database->setQuery($query);
				$database->query();
			}
			mosRedirect('index.php?option=com_fireboard&amp;func=myprofile' . FB_FB_ITEMID_SUFFIX, _USER_DETAILS_SAVE);
			break;
	}
	?>
<!-- F:My Profile Right -->
</td>
</tr>
</table>
<!-- F:My Profile -->
<?php
} else{
	echo '<b>' . _COM_A_REGISTERED_ONLY . '</b><br />';
	echo _FORUM_UNAUTHORIZIED2;
}
?>
<!-- Begin: Forum Jump -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
	<div class="<?php echo $boardclass; ?>_bt_cvr2">
		<div class="<?php echo $boardclass; ?>_bt_cvr3">
			<div class="<?php echo $boardclass; ?>_bt_cvr4">
				<div class="<?php echo $boardclass; ?>_bt_cvr5">
					<table class="fb_blocktable" id="fb_bottomarea" border="0" cellspacing="0" cellpadding="0" width="100%">
						<thead>
						<tr>
							<th class="th-right">
								<?php
								if($fbConfig->enableForumJump){
									require_once (JB_ABSSOURCESPATH . 'fb_forumjump.php');
								}
								?>
							</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>