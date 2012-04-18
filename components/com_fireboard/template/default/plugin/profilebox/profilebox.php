<?php
/**
 * @version $Id: profilebox.php 527 2007-12-20 01:00:31Z miro_dietiker $
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
$mosConfig_absolute_path = FBJConfig::getCfg('absolute_path');
$mosConfig_live_site = FBJConfig::getCfg('live_site');

$sql = "SELECT su.*, u.*, u.avatar AS suavatar, su.avatar AS fbavatar
		FROM #__fb_users AS su
		LEFT JOIN #__users AS u on u.id=su.userid
		WHERE su.userid=". $my->id;
$database->setQuery($sql);
$database->loadObject($_user);

$prefview = $_user->view;
$username = $_user->name;
$moderator = $_user->moderator;
$jr_username = $_user->username;
$jr_avatar = '';

if($fbConfig->avatar_src == "joostina"){
	$avatar = $_user->suavatar;
	if($avatar != ""){
		if(!file_exists(JPATH_SITE . '/images/avatars/' . $avatar)){
			$jr_avatar = '<img src="' . JPATH_SITE . '/images/avatars/' . $avatar . '" alt="" />';
		} else{
			$jr_avatar = '<img src="' . JPATH_SITE . '/images/avatars/none.jpg" alt="" />';
		}
		$jr_profilelink = '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=show') . '" >' . _PROFILEBOX_MYPROFILE . '</a>';
	}else{
		$jr_avatar = '<img src="' . JPATH_SITE . '/images/avatars/none.jpg" alt="" />';
		$jr_profilelink = '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=show') . '" >' . _PROFILEBOX_MYPROFILE . '</a>';
	}
}else{
	$avatar = $_user->fbavatar;
	if($avatar != ""){
		if(!file_exists(FB_ABSUPLOADEDPATH . '/avatars/s_' . $avatar)){
			$jr_avatar = '<img src="' . FB_LIVEUPLOADEDPATH . '/avatars/' . $avatar . '" alt="" />';
		} else{
			$jr_avatar = '<img src="' . FB_LIVEUPLOADEDPATH . '/avatars/nophoto.jpg" alt="" />';
		}
		$jr_profilelink = '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=show') . '" >' . _PROFILEBOX_MYPROFILE . '</a>';
	} else{
		$jr_avatar = '<img src="' . FB_LIVEUPLOADEDPATH . '/avatars/nophoto.jpg" alt="" />';
		$jr_profilelink = '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=show') . '" >' . _PROFILEBOX_MYPROFILE . '</a>';
	}
}
$jr_myposts = '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showauthor&amp;task=showmsg&amp;auth=' . $my->id . '') . '" >' . _PROFILEBOX_SHOW_MYPOSTS . '</a>';
$jr_latestpost = sefRelToAbs(JB_LIVEURLREL . '&amp;func=latest');
$j15 = FBTools::isJoomla15();
if($fbConfig->cb_profile){
	$loginlink = sefRelToAbs('index.php');
	$logoutlink = sefRelToAbs('index.php?option=logout');
	$registerlink = sefRelToAbs('index.php?option=com_comprofiler&amp;task=registers');
	$lostpasslink = sefRelToAbs('index.php?option=com_comprofiler&amp;task=lostPassword');
	if($j15){
		$loginlink = sefRelToAbs('index.php?option=com_user&amp;view=login');
		$logoutlink = sefRelToAbs('index.php?option=com_user&amp;view=login');
	}
} else{
	$loginlink = sefRelToAbs('index.php?option=com_login&amp;Itemid=' . $Itemid);
	$logoutlink = sefRelToAbs('index.php?option=logout');
	$registerlink = sefRelToAbs('index.php?option=com_users&amp;task=register&amp;Itemid=' . $Itemid);
	$lostpasslink = sefRelToAbs('index.php?option=com_users&amp;task=lostPassword&amp;Itemid=' . $Itemid);
	if($j15){
		$loginlink = sefRelToAbs('index.php?option=com_user&amp;view=login');
		$logoutlink = sefRelToAbs('index.php?option=com_user&amp;view=login');
		$registerlink = sefRelToAbs('index.php?option=com_user&amp;task=register&amp;Itemid=' . $Itemid);
		$lostpasslink = sefRelToAbs('index.php?option=com_user&amp;view=reset&amp;Itemid=' . $Itemid);
	}
}
if($my->id){
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fb_profilebox">
        <tbody id="topprofilebox_tbody">
            <tr class="<?php echo $boardclass;?>sectiontableentry1">
                <td class="td-1 fbm" align="left" width="1%" style="width:1%; vertical-align:middle;" valign="middle">
					<div style="padding:1px; border:1px solid #ccc; vertical-align:middle;" align="center">
						<?php echo $jr_avatar; ?>
					</div>
				</td>
	<td valign="top" class="td-2  fbm fb_profileboxcnt" align="left">
		<?php echo _PROFILEBOX_WELCOME; ?>, <b><?php echo $jr_username; ?></b>
		<br/>
		<a href="<?php echo $jr_latestpost; ?>">
			<?php echo _PROFILEBOX_SHOW_LATEST_POSTS; ?> </a> |
		<?php echo $jr_profilelink; ?>
		<?php
		if(!file_exists(JB_JABSPATH . '/modules/mod_alogin.php')){
			?>
			| <a href="<?php echo $logoutlink;?>"><?php echo _PROFILEBOX_LOGOUT; ?></a>&nbsp;
			<?php
		}
		$user_fields = @explode(',', $fbConfig->AnnModId);
		if(in_array($my->id, $user_fields) || $my->usertype == 'Administrator' || $my->usertype == 'Super Administrator'){
			$is_editor = true;
		} else{
			$is_editor = false;
		}
		if($is_editor){
			$annlink = sefReltoAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=show' . FB_FB_ITEMID_SUFFIX);?>
			| <a href="<?php echo $annlink;?>"><?php echo _ANN_ANNOUNCEMENTS;?></a>
			<?php
		}?>
	</td>
	<?php
} else{
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fb_profilebox">
		<tbody id="topprofilebox_tbody">
			<tr class="<?php echo $boardclass;?>sectiontableentry1">
				<td valign="top" class="td-1  fbm fb_profileboxcnt" align="left" width="35%">
					<?php echo _PROFILEBOX_WELCOME; ?>, <b><?php echo _PROFILEBOX_GUEST; ?></b>
					<br/><?php echo _PROFILEBOX_PLEASE; ?>
					<?php
					if(!file_exists(JB_JABSPATH . '/modules/mod_alogin.php')){
						?>
						<a href="<?php echo $loginlink;?>"><?php echo _PROFILEBOX_LOGIN; ?></a>
						<?php echo _PROFILEBOX_OR; ?>
						<a href="<?php echo $registerlink;?>"><?php echo _PROFILEBOX_REGISTER; ?></a>
						&nbsp;&nbsp;
						<a href="<?php echo $lostpasslink;?>"><?php echo _PROFILEBOX_LOST_PASSWORD; ?></a>
						<?php
					} else{
						echo _AFB_ALOGIN;
					}?>
				</td>
	<?php
}
////////////////////////// for ALL /////////////////////////////////////////////
?>
	<td align="left" width="20%">
		<?php
		if(mosCountModules('fb_top')){
			?>
			<?php
			mosLoadModules('fb_top', -2);
			?>
			<?php
		}?>
	</td>
	<td align="left" valign="middle" style="vertical-align:middle;" width="30%">
		<?php
		if($fbConfig->note && file_exists(JB_ABSPATH . '/template/default/plugin/note/note.php')){
			?>
			<?php
			include (JB_ABSPATH . '/template/default/plugin/note/note.php');
			?>
			<?php
		}?>
	</td>
			</tr>
		</tbody>
	</table>
	<?php
global $func; //TODO:GoDr удалить глобальную
if(mosCountModules('fb_1') && !$func){
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td width="100%">
			<?php
			mosLoadModules('fb_1', -2);
			?>
		</td>
	</tr>
	</tbody>
</table>
<?php
}
?>