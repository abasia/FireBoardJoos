<?php
/**
 * @version $Id: fb_category_list_bottom.php 462 2007-12-10 00:05:53Z fxstein $
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
?>
<!-- Cat List Bottom -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
	<div class="<?php echo $boardclass; ?>_bt_cvr2">
		<div class="<?php echo $boardclass; ?>_bt_cvr3">
			<div class="<?php echo $boardclass; ?>_bt_cvr4">
				<div class="<?php echo $boardclass; ?>_bt_cvr5">
					<table class="fb_blocktable" width="100%" id="fb_bottomarea" border="0" cellspacing="0" cellpadding="0">
						<thead>
						<tr>
							<th class="th-left fbs" align="left">
								<?php
								if($my->id != 0){
									?>
									<form action="<?php echo $mainframe->getCfg("live_site") . "/index2.php";?>" name="markAllForumsRead" method="post">
										<input type="hidden" name="markaction" value="allread"/>
										<input type="hidden" name="Itemid" value="<?php echo FB_FB_ITEMID?>"/>
										<input type="hidden" name="option" value="com_fireboard"/>
										<input type="hidden" name="no_html" value="1"/>

										<input type="submit" class="button<?php echo $boardclass;?> fbs" value="<?php echo _GEN_MARK_ALL_FORUMS_READ;?>"/>
									</form>
									<?php
								}
								?>
							</th>
							<th class="th-right fbs" align="right">
								<?php
								if($fbConfig->enableForumJump) require_once (JB_ABSSOURCESPATH . 'fb_forumjump.php');
								?>
							</th>
						</tr>
						</thead>
						<tbody id="fb-bottomarea_tbody">
						<tr class="<?php echo $boardclass;?>sectiontableentry1">
							<td class="td-1 fbs">
								<?php
								echo $fbIcons->unreadforum_s ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->unreadforum_s . '" border="0" alt="' . _GEN_FORUM_NEWPOST . '" title="' . _GEN_FORUM_NEWPOST . '"/>' : $fbConfig->newChar;
								echo '- ' . _GEN_FORUM_NEWPOST . '';
								?>
								<br/>
								<?php
								echo $fbIcons->readforum_s ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->readforum_s . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '"/>' : $fbConfig->newChar;
								echo ' - ' . _GEN_FORUM_NOTNEW . '';
								?>
							</td>
							<td class="td-2 fbs" align="left">
								<?php
								if($lockedForum == 1){
									echo $fbIcons->forumlocked ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->forumlocked . '" border="0" alt="' . _GEN_LOCKED_FORUM . '" title="' . _GEN_LOCKED_FORUM . '" /> - ' . _GEN_LOCKED_FORUM . '' : '  <img src="' . JB_URLEMOTIONSPATH . 'lock.gif" border="0"  alt="' . _GEN_LOCKED_FORUM . '" /> - ' . _GEN_LOCKED_FORUM . '';
								}
								?>
								<br/>
								<?php
								if($moderatedForum == 1){
									echo $fbIcons->forummoderated ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->forummoderated . '" border="0" alt="' . _GEN_MODERATED . '" title="' . _GEN_MODERATED . '" /> - ' . _GEN_MODERATED . '' : '  <img src="' . JB_URLEMOTIONSPATH . 'review.gif" border="0"  alt="' . _GEN_MODERATED . '" /> - ' . _GEN_MODERATED . '';
								}
								?>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>