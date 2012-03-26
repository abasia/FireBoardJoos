<?php
/**
* @version $Id: myprofile_fav.php 412 2007-10-12 07:47:11Z florut $
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
defined ('_VALID_MOS') or die('Direct Access to this location is not allowed.');
?>
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
<form action = "<?php echo sefRelToAbs(JB_LIVEURLREL.'&amp;func=myprofile&amp;do=unfavorite'); ?>" method = "post" name = "postform">
	<input type = "hidden" name = "do" value = "unfavorite"/>
	<table class = "fb_blocktable" id = "fb_forumprofile_fav" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
		<thead>
			<tr>
				<th colspan = "3">
					<div class = "fb_title_cover fbm">
						<span class = "fb_title fbxl"><?php echo _USER_FAVORITES; ?></span>
					</div>
				</th>
			</tr>
		</thead>
		<tbody id = "<?php echo $boardclass ;?>fbuserprofile_tbody">
			<tr class = "fb_sth">
				<th class = "th-1 <?php echo $boardclass ;?>sectiontableheader"><?php echo _GEN_TOPICS; ?></th>
				<th class = "th-2 <?php echo $boardclass ;?>sectiontableheader" style = "text-align:center; width:25%"><?php echo _GEN_AUTHOR; ?></th>
				<th class = "th-3 <?php echo $boardclass ;?>sectiontableheader"><?php echo _GEN_DELETE; ?></th>
			</tr>
			<?php
			$enum    = 1;
			$tabclass = array
			(
				"sectiontableentry1",
				"sectiontableentry2"
			); 
			$k       = 0;
			require ("$mosConfig_absolute_path/includes/pageNavigation.php");
			$pageNav = new mosPageNav($total, $limitstart, $limit);
			if ($cfavslist > 0)
			{
				foreach ($favslist as $favs)
				{
					$database->setQuery("select * from #__fb_messages where id=$favs->thread");
					$favdet = $database->loadObjectList();
					foreach ($favdet as $fav)
					{
						$k = 1 - $k;
						echo '<tr class="' . $boardclass . '' . $tabclass[$k] . '" >';
						echo '<td class="td-1" width="73%" align="left">' . $enum . ': <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $fav->catid . '&amp;id=' . $fav->id) . '">' . $fav->subject;
			?>
						</a>
						</td>
						<td class = "td-2" style = "text-align:center; width:25%"> <?php echo $fav->name; ?></td>
						<td class = "td-3" width = "1%">
							<input id = "cid<?php echo $enum;?>" name = "cid[]" value = "<?php echo $favs->thread; ?>"  type = "checkbox"/>
						</td>
						</tr>
			<?php
						$enum++;
					}
				}
			?>
				<tr>
					<td colspan = "3" class = "fb_profile-bottomnav" style = "text-align:right">
<?php echo _FB_USRL_DISPLAY_NR;
echo $pageNav->writeLimitBox("index.php?option=com_fireboard&amp;func=myprofile&amp;do=showfav" . FB_FB_ITEMID_SUFFIX . "");
?>
			<input type = "submit" class = "button" value = "<?php echo _GEN_DELETE;?>"/>
					</td>
				</tr>
			<?php
			}
			else
			{
				echo '<tr class="' . $boardclass . '' . $tabclass[$k] . '"><td class="td-1" colspan = "3">' . _USER_NOFAVORITES . '</td></tr>';
			}
			?>
			<tr><td colspan = "3" class = "fb_profile-bottomnav">
					<?php
					echo $pageNav->writePagesLinks("index.php?option=com_fireboard&amp;func=myprofile&amp;do=showfav" . FB_FB_ITEMID_SUFFIX);
					?>
					<br/>
<?php echo $pageNav->writePagesCounter(); ?>
				</td>
			</tr>
		</tbody>
	</table>
</form></div>
</div>
</div>
</div>
</div>