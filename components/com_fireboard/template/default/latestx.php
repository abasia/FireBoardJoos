<?php
/**
 * @version $Id: latestx.php 546 2008-01-10 07:27:52Z fxstein $
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
$ResultSet = "";
$database->setQuery("SELECT group_id FROM #__fb_users WHERE userid=$my->id");
$mygroup = $database->loadResult();
if($mygroup == 2){
	$database->setQuery("SELECT id FROM #__fb_categories");
	$allowed_forums = $database->loadObjectList();
	foreach($allowed_forums as $af){
		if($ResultSet == ""){
			$ResultSet = $af->id;
		} else{
			$ResultSet = $ResultSet . ',' . $af->id;
		}
	}
} elseif($mygroup > 0){
	$database->setQuery("SELECT id FROM #__fb_categories WHERE admin_recurse=1 OR admin_recurse=" . $mygroup);
	$allowed_forums = $database->loadObjectList();
	foreach($allowed_forums as $af){
		if($ResultSet == ""){
			$ResultSet = $af->id;
		} else{
			$ResultSet = $ResultSet . ',' . $af->id;
		}
	}
} else{
	$database->setQuery("SELECT id FROM #__fb_categories WHERE pub_access='0' AND admin_recurse=1");
	$allowed_forums = $database->loadObjectList();
	foreach($allowed_forums as $af){
		if($ResultSet == ""){
			$ResultSet = $af->id;
		} else{
			$ResultSet = $ResultSet . ',' . $af->id;
		}
	}
}
if($sel == "0"){
	$querytime = ($prevCheck - 1800);
} else{
	if("" == $sel){
		$sel = 4;
	}
	$back_time = $sel * 3600;
	$querytime = time() - $back_time;
}
$database->setQuery("SELECT a.thread, b.subject FROM #__fb_messages AS a LEFT JOIN #__fb_messages AS b ON a.thread=b.thread WHERE a.time >'$querytime' AND b.parent=0 AND a.catid IN ($ResultSet) AND a.moved != 1 AND a.hold=0 GROUP BY a.thread ORDER BY a.time DESC LIMIT 100");
$resultSet = $database->loadObjectList();
$countRS = count($resultSet);
$since = false;
if($sel == "0"){
	$lastvisit = date(_DATETIME, $querytime);
	$since = true;
}
?>
<div class="<?php echo $boardclass; ?>_bt_cvr1">
	<div class="<?php echo $boardclass; ?>_bt_cvr2">
		<div class="<?php echo $boardclass; ?>_bt_cvr3">
			<div class="<?php echo $boardclass; ?>_bt_cvr4">
				<div class="<?php echo $boardclass; ?>_bt_cvr5">
					<table class="fb_blocktable" id="fb_latestx" border="0" cellspacing="0" cellpadding="0" width="100%">
						<thead>
						<tr>
							<th colspan="4">
								<div class="fb_title_cover" style="text-align:center; display:block; width:100%;">
                    <span class="fb_title">
                    <?php
						if(!$since){
							echo _SHOW_LAST_POSTS . " $sel";
						} else{
							echo _SHOW_LAST_SINCE;
						}
						echo $lastvisit; ?> <?php echo _SHOW_HOURS; ?> (<?php echo _SHOW_POSTS; ?><?php echo $countRS; ?>)</span> <?php echo _DESCRIPTION_POSTS; ?><br/>
									<a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=latest&amp;do=show&amp;sel=4'); ?>"><?php
										echo _SHOW_4_HOURS; ?></a> | <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=latest&amp;do=show&amp;sel=8'); ?>"><?php
									echo _SHOW_8_HOURS; ?></a> | <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=latest&amp;do=show&amp;sel=12'); ?>"><?php
									echo _SHOW_12_HOURS; ?></a> | <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=latest&amp;do=show&amp;sel=24'); ?>"><?php
									echo _SHOW_24_HOURS; ?></a> | <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=latest&amp;do=show&amp;sel=48'); ?>"><?php
									echo _SHOW_48_HOURS; ?></a> | <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=latest&amp;do=show&amp;sel=168'); ?>"><?php
									echo _SHOW_WEEK; ?></a> | <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=latest&amp;do=show&amp;sel=0'); ?>"><?php echo _SHOW_LASTVISIT; ?></a>
								</div>
							</th>
						</tr>
						</thead>
						<tbody id="<?php echo $boardclass; ?>latestx_tbody">
						<tr class="fb_sth fbs">
							<th class="th-1 <?php echo $boardclass; ?>sectiontableheader" width="60%" align="left"><?php echo _LATEST_THREADFORUM; ?>
							</th>
							<th class="th-2 <?php echo $boardclass; ?>sectiontableheader" width="10%" align="center"><?php echo _LATEST_NUMBER; ?>
							</th>
							<th class="th-3 <?php echo $boardclass; ?>sectiontableheader" width="15%" align="center"><?php echo _LATEST_AUTHOR; ?>
							</th>
							<th class="th-4 <?php echo $boardclass; ?>sectiontableheader" width="15%" align="left"><?php echo _POSTED_AT; ?>
							</th>
						</tr>
						<?php
						if(0 < $countRS){
							$tabclass = array("sectiontableentry1", "sectiontableentry2");
							$k = 0;
							foreach($resultSet as $rs){
								$database->setQuery("SELECT max(time) FROM #__fb_messages where thread={$rs->thread}");
								$latestPostTime = $database->loadResult();
								unset($result);
								$database->setQuery("SELECT a.id,a.name,a.userid,a.catid,b.name as catname from #__fb_messages as a LEFT JOIN #__fb_categories as b on a.catid=b.id where a.time={$latestPostTime}");
								$database->loadObject($result);
								$latestPostId = $result->id;
								$latestPostName = $result->name;
								$latestPostUserid = $result->userid;
								$latestPostCatid = $result->catid;
								$catname = $result->catname;
								$database->setQuery("SELECT count(*) from #__fb_messages where time>'{$querytime}' and thread={$rs->thread}");
								$numberOfPosts = $database->loadResult();
								$k = 1 - $k;
								echo '<tr  class="' . $boardclass . '' . $tabclass[$k] . '" >';
								echo '<td  class="td-1"  align="left" ><a href="' . sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $latestPostCatid . '&id=' . $rs->thread) . '#' . $rs->thread . '">' . htmlspecialchars(stripslashes($rs->subject)) . '</a>' . ' <a href="' . sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $latestPostCatid . '&id=' . $latestPostId) . '#' . $latestPostId . '">';
								echo $fbIcons->latestpost ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->latestpost . '" border="0" alt="' . _SHOW_LAST . '" title="' . _SHOW_LAST . '" />' : '  <img src="' . JB_URLEMOTIONSPATH . 'icon_newest_reply.gif" border="0"   alt="' . _SHOW_LAST . '" />';
								echo '</a><br />' . _GEN_FORUM . ' : ' . $catname . '</td>';
								echo '<td  class="td-2"  align="center">' . $numberOfPosts . '</td>';
								echo "<td class=\"td-3\" align=\"center\" ><a href=\"" . sefRelToAbs(FB_PROFILE_LINK_SUFFIX . "" . $latestPostUserid) . "\">" . htmlspecialchars($latestPostName) . "</a></td>";
								echo "<td class=\"td-4\"  align=\"left\">" . date(_DATETIME, $latestPostTime) . "</td>";
								echo "</tr>";
							}
						} else{
							echo "<tr><td colspan=\"4\" align=\"left\"> " . _NO_TIMEFRAME_POSTS . " </td></tr>";
						}
						echo "</tbody></table></div></div></div></div></div>";
						?>
						<!-- Begin: Forum Jump -->
						<div class="<?php echo $boardclass; ?>_bt_cvr1">
							<div class="<?php echo $boardclass; ?>_bt_cvr2">
								<div class="<?php echo $boardclass; ?>_bt_cvr3">
									<div class="<?php echo $boardclass; ?>_bt_cvr4">
										<div class="<?php echo $boardclass; ?>_bt_cvr5">
											<table class="fb_blocktable" id="fb_bottomarea" border="0" cellspacing="0" cellpadding="0">
												<thead>
												<tr>
													<th class="th-right">
														<?php
														if($fbConfig->enableForumJump) require_once (JB_ABSSOURCESPATH . 'fb_forumjump.php');
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