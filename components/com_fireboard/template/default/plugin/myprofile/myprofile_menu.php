<?php
/**
 * @version $Id: myprofile_menu.php 376 2007-09-27 21:05:57Z miro_dietiker $
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
$mosConfig_absolute_path = FBJConfig::getCfg('absolute_path');
$mosConfig_live_site = FBJConfig::getCfg('live_site');
$fbConfig = FBJConfig::getInstance();
?>
<div class="<?php echo $boardclass; ?>_bt_cvr1">
	<div class="<?php echo $boardclass; ?>_bt_cvr2">
		<div class="<?php echo $boardclass; ?>_bt_cvr3">
			<div class="<?php echo $boardclass; ?>_bt_cvr4">
				<div class="<?php echo $boardclass; ?>_bt_cvr5">
					<table class="fb_blocktable" id="fb_forumprofile" border="0" cellspacing="0" cellpadding="0" width="100%">
						<thead>
						<tr>
							<th>
								<div class="fb_title_cover">
									<span class="fb_title"><?php echo _USER_PROFILE; ?> <?php echo $username; ?></span>
								</div>
							</th>
						</tr>
						</thead>
						<tbody class="fb_myprofile_menu">
						<tr>
							<td class="fb_myprofile_menu_staff">
								<span class="fb_myprofile_menu_title"><?php echo _FB_MYPROFILE_PERSONAL_INFO; ?></span> <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=show'); ?>"> <?php echo _FB_MYPROFILE_SUMMARY; ?> </a>
								<a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=userdetails'); ?>"> <?php echo _FB_EDIT_TITLE; ?> </a> <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=uploadavatar'); ?>"> <?php echo _FB_MYPROFILE_MYAVATAR; ?></a>
							</td>
						</tr>
						<tr>
							<td class="fb_myprofile_menu_staff">
								<span class="fb_myprofile_menu_title"><?php echo _FB_MYPROFILE_FORUM_SETTINGS; ?></span> <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=showset'); ?>"><?php echo _FB_MYPROFILE_LOOK_AND_LAYOUT; ?></a>
								<a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=profileinfo'); ?>"><?php echo _FB_MYPROFILE_MY_PROFILE_INFO; ?></a> <a
								href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=showmsg'); ?>"><?php echo _FB_MYPROFILE_MY_POSTS; ?></a> <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=showsub'); ?>"><?php echo _FB_MYPROFILE_MY_SUBSCRIBES; ?></a>
								<a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=showfav'); ?>"><?php echo _FB_MYPROFILE_MY_FAVORITES; ?></a>
							</td>
						</tr>
						<?php
						if($fbConfig->foto && file_exists($mosConfig_absolute_path . '/components/com_fireboard/template/default//plugin/foto/foto.php')){
							$database->setQuery("SELECT group_id FROM #__fb_users WHERE userid=" . $my->id);
							$mygroup = $database->loadResult();
							$allowed_groups = explode(',', $fbConfig->foto_groups);
							if(in_array($mygroup, $allowed_groups)){
								?>
							<tr>
								<td class="fb_myprofile_menu_staff">
									<span class="fb_myprofile_menu_title"><?php echo _AFB_FOTO; ?></span> <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=myprofile&amp;do=foto'); ?>"><?php echo _AFB_FOTO_EDIT; ?></a>
								</td>
							</tr>
								<?php
							}
						}
						// UddeIM
						if($fbConfig->pm_component == 'uddeim'){
							?>
						<tr>
							<td class="fb_myprofile_menu_staff">
								<span class="fb_myprofile_menu_title"><?php echo _FB_MYPROFILE_PRIVATE_MESSAGING; ?></span>
								<a href="<?php echo sefRelToAbs('index.php?option=com_uddeim&amp;Itemid=' . FB_UIM_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_INBOX; ?> </a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_uddeim&amp;task=new&amp;Itemid=' . FB_UIM_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_NEW_MESSAGE;?></a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_uddeim&amp;task=outbox&amp;Itemid=' . FB_UIM_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_OUTBOX; ?></a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_uddeim&amp;task=trashcan&amp;Itemid=' . FB_UIM_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_TRASH;?></a>
							</td>
						</tr>
							<?php
						}
						// MISSUS
						if($fbConfig->pm_component == 'missus'){

							?>
						<tr>
							<td class="fb_myprofile_menu_staff">
								<span class="fb_myprofile_menu_title"><?php echo _FB_MYPROFILE_PRIVATE_MESSAGING; ?></span>
								<a href="<?php echo sefRelToAbs('index.php?option=com_missus&amp;func=showinbox&amp;Itemid=' . FB_MISSUS_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_INBOX; ?> </a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_missus&amp;func=newmsg&amp;Itemid=' . FB_MISSUS_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_NEW_MESSAGE; ?></a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_missus&amp;func=showsent&amp;Itemid=' . FB_MISSUS_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_OUTBOX; ?></a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_missus&amp;func=showtrash&amp;Itemid=' . FB_MISSUS_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_TRASH; ?></a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_missus&amp;func=showcontacts&amp;Itemid=' . FB_MISSUS_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_CONTACTS; ?></a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_missus&amp;func=showconfig&amp;Itemid=' . FB_MISSUS_ITEMID . ''); ?>"><?php echo _FB_MYPROFILE_SETTINGS; ?></a>
							</td>
						</tr>
							<?php
						}
						// JIM
						if($fbConfig->pm_component == 'jim'){
							?>
						<tr>
							<td class="fb_myprofile_menu_staff">
								<span class="fb_myprofile_menu_title"><?php echo _FB_MYPROFILE_PRIVATE_MESSAGING; ?></span>
								<a href="<?php echo sefRelToAbs('index.php?option=com_jim&amp;task=inbox'); ?>"><?php echo _FB_MYPROFILE_INBOX; ?> </a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_jim&amp;task=new'); ?>"><?php echo _FB_MYPROFILE_NEW_MESSAGE; ?></a>
								<a href="<?php echo sefRelToAbs('index.php?option=com_jim&amp;task=outbox'); ?>"><?php echo _FB_MYPROFILE_OUTBOX; ?></a>
							</td>
						</tr>
							<?php
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>