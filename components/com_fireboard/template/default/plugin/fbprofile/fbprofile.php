<?php
/**
 * @version $Id: fbprofile.php 518 2007-12-19 01:27:58Z miro_dietiker $
 * Fireboard Component
 * @package Fireboard
 * @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.bestofjoomla.com
 *
 * Russian edition by Adeptus (c) 2007
 *
 **/
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
$fbConfig = FBJConfig::getInstance();
if($my->id){
	require_once(JB_ABSSOURCESPATH . 'fb_auth.php');
	require_once(JB_ABSSOURCESPATH . 'fb_statsbar.php');
	$task = mosGetParam($_GET, 'task', "");
	switch($task){
		case "showprf":
			$userid = mosGetParam($_GET, 'userid', null);
			showprf((int)$userid);
			break;
	}
} else{
	echo '<h3>' . _COM_A_REGISTERED_ONLY . '</h3>';
}
function showprf($userid){
	$database = FBJConfig::database();
	$acl = gacl::getInstance();
	$my = FBJConfig::my();
	$fbIcons = FBJIcons::getInstance();
	$fbConfig = FBJConfig::getInstance();

	$database->setQuery('UPDATE #__fb_users SET uhits=uhits+1 WHERE userid=' . $userid);
	$database->query();
	unset($userinfo);
	$database->setQuery("SELECT  a.*, b.* FROM #__fb_users as a" . "\n LEFT JOIN #__users as b on b.id=a.userid" . "\n where a.userid=$userid");
	$database->loadObject($userinfo);
	$msg_userhits = $userinfo->uhits;
	$fb_username = "";
	if($fbConfig->username){
		$fb_queryName = "username";
	} else{
		$fb_queryName = "name";
	}
	$fb_username = $userinfo->{$fb_queryName};
	if($fb_username == "" || $fbConfig->changename){
		$fb_username = $fmessage->name;
	}
	$msg_id = $fmessage->id;
	$lists["userid"] = $userid;
	$msg_username = ($fmessage->email != "" && $my->id > 0 && $fbConfig->showemail == '1') ? "<a href=\"mailto:" . stripslashes($fmessage->email) . "\">" . stripslashes($fb_username) . "</a>" : stripslashes($fb_username);
	if($fbConfig->allowAvatar){
		$Avatarname = $userinfo->username;
		if($fbConfig->avatar_src == "joostina"){
			$msg_avatar = '<span class="fb_avatar"><img src="' . MyPMSTools::getAvatarLinkWithID($userid, "b") . '" alt="" /></span>';
		}else{
			$avatar = $userinfo->avatar;
			if($avatar != ''){
				if(!file_exists(FB_ABSUPLOADEDPATH . '/avatars/l_' . $avatar)){
					$msg_avatar = '<span class="fb_avatar"><img border="0" src="' . FB_LIVEUPLOADEDPATH . '/avatars/' . $avatar . '"  alt="" /></span>';
				} else{
					$msg_avatar = '<span class="fb_avatar"><img border="0" src="' . FB_LIVEUPLOADEDPATH . '/avatars/l_' . $avatar . '"  alt="" /></span>';
				}
			} else{
				$msg_avatar = '<span class="fb_avatar"><img  border="0" src="' . FB_LIVEUPLOADEDPATH . '/avatars/nophoto.jpg"  alt="" /></span>';
			}
		}
	}
	if($fbConfig->showstats){
		$ugid = $userinfo->gid;
		$uIsMod = 0;
		$uIsAdm = 0;
		if($ugid > 0){
			$agrp = strtolower($acl->get_group_name($ugid, 'ARO'));
		}
		if($ugid == 0){
			$msg_usertype = _VIEW_VISITOR;
		} else{
			if(strtolower($agrp) == "administrator" || strtolower($agrp) == "superadministrator" || strtolower($agrp) == "super administrator"){
				$msg_usertype = _VIEW_ADMIN;
				$uIsAdm = 1;
			} elseif($uIsMod){
				$msg_usertype = _VIEW_MODERATOR;
			} else{
				$msg_usertype = _VIEW_USER;
			}
		}
		$database->setQuery("SELECT max(posts) from #__fb_users");
		$maxPosts = $database->loadResult();
		$numPosts = (int)$userinfo->posts;
		if($fbConfig->showranking){
			if($userinfo->rank == '0') $userinfo->rank = 1;
			if($userinfo->rank != '0'){
				$database->setQuery("SELECT * FROM #__fb_ranks WHERE rank_id = '$userinfo->rank'");
				$getRank = $database->loadObjectList();
				$rank = $getRank[0];
				$rText = $rank->rank_title;
				$rImg = JB_URLRANKSPATH . $rank->rank_image;
			}
			if($userinfo->rank == '1'){
				$database->setQuery("SELECT * FROM #__fb_ranks WHERE ((rank_min <= $numPosts) AND (rank_special = 0))  ORDER BY rank_min DESC LIMIT 1");
				$getRank = $database->loadObjectList();
				$rank = $getRank[0];
				$rText = $rank->rank_title;
				$rImg = JB_URLRANKSPATH . $rank->rank_image;
			}
			if($uIsMod){
				$rText = _RANK_MODERATOR;
				$rImg = JB_URLRANKSPATH . 'rankmod.gif';
			}
			if($uIsAdm){
				$rText = _RANK_ADMINISTRATOR;
				$rImg = JB_URLRANKSPATH . 'rankadmin.gif';
			}
			if($fbConfig->rankimages) $msg_userrankimg = '<img src="' . $rImg . '" alt="" />';
			$msg_userrank = $rText;
			$useGraph = 0;
			if(!$fbConfig->postStats){
				$msg_posts = '<div class="viewcover">' . "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr>" . "<strong>" . _POSTS . " $numPosts" . "</strong>" . "</td></tr>" . "</table></div>";
				$useGraph = 0;
			} else{
				$myGraph = new phpGraph;
				$myGraph->AddValue(_POSTS, $numPosts);
				$myGraph->SetRowSortMode(0);
				$myGraph->SetBarImg(JB_URLGRAPHPATH . "col" . $fbConfig->statsColor . "m.png");
				$myGraph->SetBarImg2(JB_URLEMOTIONSPATH . "graph.gif");
				$myGraph->SetMaxVal($maxPosts);
				$myGraph->SetShowCountsMode(2);
				$myGraph->SetBarWidth(4);
				$myGraph->SetBorderColor("#333333");
				$myGraph->SetBarBorderWidth(0);
				$myGraph->SetGraphWidth(120);
				$useGraph = 1;
			}
		}
	}
	if($fbConfig->showkarma && $userid != '0'){
		$karmaPoints = $userinfo->karma;
		$karmaPoints = (int)$karmaPoints;
		$msg_karma = "<strong>" . _KARMA . ":</strong> $karmaPoints";
		if($my->id != '0' && $my->id != $userid){
			$msg_karmaminus = "<a href=\"" . sefRelToAbs(JB_LIVEURLREL . '&amp;func=karma&amp;do=decrease&amp;userid=' . $userid . '&amp;pid=' . $fmessage->id . '&amp;catid=' . $catid . '') . "\"><img src=\"";
			if($fbIcons->karmaminus){
				$msg_karmaminus .= JB_URLICONSPATH . "" . $fbIcons->karmaminus;
			} else{
				$msg_karmaminus .= JB_URLEMOTIONSPATH . "karmaminus.gif";
			}
			$msg_karmaminus .= "\" alt=\"Karma-\" border=\"0\" title=\"" . _KARMA_SMITE . "\" align=\"middle\" /></a>";
			$msg_karmaplus = "<a href=\"" . sefRelToAbs(JB_LIVEURLREL . '&amp;func=karma&amp;do=increase&amp;userid=' . $userid . '&amp;pid=' . $fmessage->id . '&amp;catid=' . $catid . '') . "\"><img src=\"";

			if($fbIcons->karmaplus){
				$msg_karmaplus .= JB_URLICONSPATH . "" . $fbIcons->karmaplus;
			} else{
				$msg_karmaplus .= JB_URLEMOTIONSPATH . "karmaplus.gif";
			}
			$msg_karmaplus .= "\" alt=\"Karma+\" border=\"0\" title=\"" . _KARMA_APPLAUD . "\" align=\"middle\" /></a>";
		}
	}
	if($fbConfig->pm_component == "uddeim" && $userid && $my->id){
		$PMSName = $userinfo->username;
		$msg_pms = "<a href=\"" . sefRelToAbs('index.php?option=com_uddeim&amp;task=new&recip=' . $userid) . "\"><img src=\"";
		if($fbIcons->pms){
			$msg_pms .= JB_URLICONSPATH . '' . $fbIcons->pms;
		} else{
			$msg_pms .= JB_URLEMOTIONSPATH . "sendpm.gif";
		}
		$msg_pms .= "\" alt=\"" . _VIEW_PMS . "\" border=\"0\" title=\"" . _VIEW_PMS . "\" /></a>";
	}
	if($fbConfig->pm_component == "pms" && $userid && $my->id){
		$PMSName = $userinfo->username;
		$msg_pms = "<a href=\"" . sefRelToAbs('index.php?option=com_pms&amp;page=new&amp;id=' . $PMSName . '&title=' . $fmessage->subject) . "\"><img src=\"";
		if($fbIcons->pms){
			$msg_pms .= JB_URLICONSPATH . "" . $fbIcons->pms;
		} else{
			$msg_pms .= JB_URLEMOTIONSPATH . "sendpm.gif";
		}
		$msg_pms .= "\" alt=\"" . _VIEW_PMS . "\" border=\"0\" title=\"" . _VIEW_PMS . "\" /></a>";
	}
	if($userid > 0){
		$sql = "SELECT count(userid) FROM #__session WHERE userid=" . $userid;
		$database->setQuery($sql);
		$isonline = $database->loadResult();
		if($isonline && $userinfo->showOnline == 1){
			$msg_online .= $fbIcons->onlineicon ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->onlineicon . '" border="0" alt="' . _MODLIST_ONLINE . '" />' : '  <img src="' . JB_URLEMOTIONSPATH . 'onlineicon.gif" border="0"  alt="' . _MODLIST_ONLINE . '" />';
		} else{
			$msg_online .= $fbIcons->offlineicon ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->offlineicon . '" border="0" alt="' . _MODLIST_OFFLINE . '" />' : '  <img src="' . JB_URLEMOTIONSPATH . 'offlineicon.gif" border="0"  alt="' . _MODLIST_OFFLINE . '" />';
		}
	}

	if($fbConfig->cb_profile && $userid > 0){
		$msg_profile = "<a href=\"" . sefRelToAbs('index.php?option=com_comprofiler&amp;task=userProfile&amp;user=' . $userid . '&amp;Itemid=1') . "\"><img src=\"";
		if($fbIcons->userprofile){
			$msg_profile .= JB_URLICONSPATH . "" . $fbIcons->userprofile;
		} else{
			$msg_profile .= JB_JLIVEURL . "/components/com_comprofiler/images/profiles.gif";
		}
		$msg_profile .= "\" alt=\"" . _VIEW_PROFILE . "\" border=\"0\" title=\"" . _VIEW_PROFILE . "\" /></a>";
	}
	$jr_username = $user->name;
	if($fbConfig->joomlaStyle < 1){
		$boardclass = "fb_";
	}
	?>
<table class="fb_profile_cover" width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="<?php echo $boardclass; ?>profile-left" align="center" valign="top" width="25%">
			<!-- Fireboard Profile -->
			<?php
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/fbprofile/userinfos.php')){
				include(JB_ABSTMPLTPATH . '/plugin/fbprofile/userinfos.php');
			} else{
				include(JB_ABSPATH . '/template/default/plugin/fbprofile/userinfos.php');
			}
			?>
			<!-- /Fireboard Profile -->
		</td>
		<td class="<?php echo $boardclass; ?>profile-right" valign="top" width="74%">
			<!-- User Messages -->
			<?php
			if(file_exists(JB_ABSTMPLTPATH . '/smile.class.php')){
				include (JB_ABSTMPLTPATH . '/smile.class.php');
			} else{
				include (JB_ABSPATH . '/template/default/smile.class.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/fbprofile/summary.php')){
				include(JB_ABSTMPLTPATH . '/plugin/fbprofile/summary.php');
			} else{
				include(JB_ABSPATH . '/template/default/plugin/fbprofile/summary.php');
			}
			if(file_exists(JB_ABSTMPLTPATH . '/plugin/fbprofile/forummsg.php')){
				include(JB_ABSTMPLTPATH . '/plugin/fbprofile/forummsg.php');
			} else{
				include(JB_ABSPATH . '/template/default/plugin/fbprofile/forummsg.php');
			}
			?>
		</td>
	</tr>
</table>
<?php
}

?>
<!-- Begin: Forum Jump -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
	<div class="<?php echo $boardclass; ?>_bt_cvr2">
		<div class="<?php echo $boardclass; ?>_bt_cvr3">
			<div class="<?php echo $boardclass; ?>_bt_cvr4">
				<div class="<?php echo $boardclass; ?>_bt_cvr5">
					<table class="fb_blocktable" id="fb_bottomarea" border="0" cellspacing="0" cellpadding="0"
						   width="100%">
						<thead>
						<tr>
							<th class="th-right">
								<?php
								if($fbConfig->enableForumJump) require_once(JB_ABSSOURCESPATH . 'fb_forumjump.php');
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