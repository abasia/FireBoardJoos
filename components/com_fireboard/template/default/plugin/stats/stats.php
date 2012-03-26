<?php
/**
* @version $Id: stats.php 462 2007-12-10 00:05:53Z fxstein $
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
global $fbConfig,$Itemid;
//$forumurl = 'index.php?option=com_fireboard';
$forumurl = sefReltoAbs(JB_LIVEURLREL);
if ($fbConfig['fb_profile'] == "cb") {
	$profilelink = sefReltoAbs('index.php?option=com_comprofiler&amp;task=userProfile&amp;user=');
	$userlist = sefReltoAbs('index.php?option=com_comprofiler&amp;task=usersList');
}
else if ($fbConfig['fb_profile'] == "clexuspm") {
	$profilelink = sefReltoAbs('index.php?option=com_mypms&amp;task=showprofile&amp;user=');
}
else {
	$userlist = sefReltoAbs('index.php?option=com_fireboard&amp;Itemid='.$Itemid.'&amp;func=userlist');
}
?>
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
        <table  class = "fb_blocktable" id ="fb_morestat " border = "0" cellspacing = "0" cellpadding = "0" width="100%">
            <thead>
                <tr>
                    <th>
                        <div class = "fb_title_cover fbm" style="font-weight:bold; font-size:13px;">
                            <?php echo _STAT_FORUMSTATS; ?>
                        </div>
                        <img id = "BoxSwitch__morestat_tbody" class = "hideshow" src = "<?php echo JB_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
                    </th>
                </tr>
            </thead>
            <tbody id = "morestat_tbody">
                <tr class = "fb_sth fbs">
                    <th class = "th-1 <?php echo $boardclass; ?>sectiontableheader" align="left" width="50%"><?php echo _STAT_GENERAL_STATS; ?>
                    </th>
                </tr>
                <tr class = "<?php echo $boardclass ;?>sectiontableentry1">
                    <td class = "td-1" align="left">
						<?php echo _STAT_TOTAL_USERS; ?>:<b>
						<?php
						if ($fbConfig['fb_profile'] == "cb")
						{?>
						<a href = "<?php echo sefReltoAbs('index.php?option=com_comprofiler&amp;task=usersList');?>"><?php echo $totalmembers; ?>
						</a></b>&nbsp;
						<?php
						}
						else
						{?>
						<a href = "<?php echo sefReltoAbs('index.php?option=com_fireboard&amp;Itemid='.$Itemid.'&amp;func=userlist');?>"><?php echo $totalmembers; ?>
						</a></b>&nbsp;
						<?php
						}
						echo _STAT_LATEST_MEMBERS; ?>:<b>
						<?php
						if ($fbConfig['fb_profile'] == "cb")
						{?>
						<a href="<?php echo sefReltoAbs('index.php?option=com_comprofiler&amp;task=userProfile&amp;user='.$lastestmemberid);?>" title="<?php echo _STAT_PROFILE_INFO.'&nbsp;'; ?><?php echo $lastestmember;?>"><?php echo $lastestmember; ?></a></b>
						<?php
						}
						else
						{?>
						<a href="<?php echo sefReltoAbs('index.php?option=com_fireboard&amp;Itemid='.$Itemid.'&amp;func=fbprofile&amp;task=showprf&amp;userid='.$lastestmemberid);?>" title="<?php echo _STAT_PROFILE_INFO.'&nbsp;'; ?><?php echo $lastestmember;?>"><?php echo $lastestmember; ?></a></b>
						<?php
						}?>
		                <br/>
						<?php echo _STAT_TOTAL_MESSAGES; ?>: <b><?php echo $totalmsgs; ?></b>&nbsp;
						<?php echo _STAT_TOTAL_SUBJECTS; ?>: <b><?php echo $totaltitles; ?></b>&nbsp;
						<?php echo _STAT_TOTAL_SECTIONS; ?>: <b><?php echo $totalcats; ?></b>&nbsp;
						<?php echo _STAT_TOTAL_CATEGORIES; ?>: <b> <?php echo $totalsections; ?></b>
						<br/>
						<?php echo _STAT_TODAY_OPEN_THREAD; ?>: <b><?php echo $todaystitle; ?></b>&nbsp;
						<?php echo _STAT_YESTERDAY_OPEN_THREAD; ?>: <b><?php echo $yesterdaystitle; ?></b>&nbsp;
						<?php echo _STAT_TODAY_TOTAL_ANSWER; ?>: <b><?php echo $todaytotal; ?></b>&nbsp;
						<?php echo _STAT_YESTERDAY_TOTAL_ANSWER; ?>: <b><?php echo $yesterdaytotal; ?></b>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
</div>
</div>
</div>
</div>
<?php
$tabclass = array
(
"sectiontableentry1",
"sectiontableentry2"
);
$k = 0;
?>
<!-- B: Pop Subject -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
<table class = "fb_blocktable " id="fb_popsubmorestat"  cellpadding = "0" cellspacing = "0" border = "0" width = "100%">
  <thead>
    <tr>
      <th colspan="3"> 
      <div class = "fb_title_cover fbm"> <span class="fb_title fbxl"> <?php echo _STAT_POPULAR; ?> <b><?php echo $fbConfig['PopSubjectCount']; ?></b> <?php echo _STAT_POPULAR_USER_KGSG; ?></span> </div>
      <img id = "BoxSwitch__<?php echo $boardclass ;?>popsubstats_tbody" class = "hideshow" src = "<?php echo JB_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
      </th>
    </tr>
  </thead>
  <tbody id = "<?php echo $boardclass ;?>popsubstats_tbody">
   <tr  class = "fb_sth" >
      <th class = "th-1 <?php echo $boardclass; ?>sectiontableheader" align="left" width="50%"> <?php echo _GEN_SUBJECT ;?></th>
      <th class = "th-2 <?php echo $boardclass; ?>sectiontableheader" width="40%">&nbsp;  </th>
      <th class = "th-3 <?php echo $boardclass; ?>sectiontableheader" align="center" width="10%"> <?php echo _FB_USRL_HITS ;?> </th>
    </tr>
 <?php foreach ($toptitles as $toptitle)
       {
	   $k = 1 - $k;
		   if ($toptitle->hits == $toptitlehits) {
		   $barwidth = 100;
		   }
		   else {
		   $barwidth = round(($toptitle->hits * 100) / $toptitlehits);
		   }
	  $link = sefReltoAbs(JB_LIVEURLREL.'&amp;func=view&amp;id='.$toptitle->id.'&amp;catid='.$toptitle->catid);
?>
    <tr class = "<?php echo ''.$boardclass.''. $tabclass[$k] . ''; ?>">
      <td class="td-1" align="left">
       <a href = "<?php echo $link;?>"><?php echo stripcslashes($toptitle->subject); ?></a>
      </td>
      <td  class="td-2">
       <img class = "jr-forum-stat-bar" src = "<?php echo JB_TMPLTMAINIMGURL.'/images/bar.gif';?>" alt = "" height = "10" width = "<?php echo $barwidth;?>%"/>
      </td>
      <td  class="td-3">
	  <?php echo $toptitle->hits; ?>
       </td>
    </tr>
<?php }   ?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<!-- B: User Messages -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
<table class = "fb_blocktable " id="fb_popusermsgmorestat"  cellpadding = "0" cellspacing = "0" border = "0" width = "100%">
  <thead>
    <tr>
      <th colspan="3"> 
      <div class = "fb_title_cover fbm"> <span class="fb_title fbxl"> <?php echo _STAT_POPULAR; ?> <b><?php echo $fbConfig['PopUserCount']; ?></b> <?php echo _STAT_POPULAR_USER_TMSG; ?></span> </div>
      <img id = "BoxSwitch__<?php echo $boardclass ;?>popusermsgstats_tbody" class = "hideshow" src = "<?php echo JB_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
      </th>
    </tr>
  </thead>
  <tbody id = "<?php echo $boardclass ;?>popusermsgstats_tbody">
   <tr  class = "fb_sth" >
      <th class = "th-1 <?php echo $boardclass; ?>sectiontableheader" align="left" width="50%"><?php echo _FB_USRL_USERNAME ;?></th>
      <th class = "th-2 <?php echo $boardclass; ?>sectiontableheader" width="40%">&nbsp;  </th>
      <th class = "th-3 <?php echo $boardclass; ?>sectiontableheader" align="center" width="10%"> <?php echo _FB_USRL_POSTS ;?></th>
    </tr>
<?php
	foreach ($topposters as $poster)
	{
	$k = 1 - $k;
	if ($poster->posts == $topmessage) {
	$barwidth = 100;
	}
	else {
	$barwidth = round(($poster->posts * 100) / $topmessage);
	}
?>
	<tr class = "<?php echo ''.$boardclass.''. $tabclass[$k] . ''; ?>">
		<td  class="td-1"  align="left">
			<a href = "<?php echo sefReltoAbs('index.php?option=com_fireboard&amp;Itemid='.$Itemid.'&amp;func=fbprofile&amp;task=showprf&amp;userid='.$poster->userid);?>" title = "<?php echo _STAT_USER_INFO.'&nbsp;'; ?><?php echo $poster->username;?>"><?php echo $poster->username; ?></a>
		</td>
		<td  class="td-2">
			<img class = "jr-forum-stat-bar" src = "<?php echo JB_TMPLTMAINIMGURL.'/images/bar.gif';?>" alt = "" height = "10" width = "<?php echo $barwidth;?>%"/>
		</td>
		<td  class="td-3">
			<?php echo $poster->posts; ?>
		</td>
	</tr>
<?php } ?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<!-- B: Pop User  -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
<table class = "fb_blocktable " id="fb_popuserhitmorestat"  cellpadding = "0" cellspacing = "0" border = "0" width = "100%">
  <thead>
    <tr>
      <th colspan="3"> 
      <div class = "fb_title_cover"> <span class="fb_title"> <?php echo _STAT_POPULAR; ?> <b><?php echo $fbConfig['PopUserCount']; ?></b> <?php echo _STAT_POPULAR_USER_GSG; ?></span> </div>
      <img id = "BoxSwitch__<?php echo $boardclass ;?>popuserhitstats_tbody" class = "hideshow" src = "<?php echo JB_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
      </th>
    </tr>
  </thead>
  <tbody id = "<?php echo $boardclass ;?>popuserhitstats_tbody">
   <tr  class = "fb_sth fbs" >
      <th class = "th-1 <?php echo $boardclass; ?>sectiontableheader"  align="left" width="50%"> <?php echo _FB_USRL_USERNAME ;?></th>
      <th class = "th-2 <?php echo $boardclass; ?>sectiontableheader" width="40%">&nbsp;  </th>
      <th class = "th-3 <?php echo $boardclass; ?>sectiontableheader" align="center" width="10%"><?php echo _FB_USRL_HITS ;?></th>
    </tr>
<?php
foreach ($topprofiles as $topprofile)
{
$k = 1 - $k;
if ($topprofile->hits == $topprofil) {
$barwidth = 100;
}
else {
$barwidth = round(($topprofile->hits * 100) / $topprofil);
}
?>
	<tr class = "<?php echo ''.$boardclass.''. $tabclass[$k] . ''; ?>">
		<td  class="td-1"  align="left">
			<a href = "<?php echo sefReltoAbs('index.php?option=com_fireboard&amp;Itemid='.$Itemid.'&amp;func=fbprofile&amp;task=showprf&amp;userid='.$topprofile->user_id);?>" title = "<?php echo _STAT_USER_INFO.'&nbsp;'; ?><?php echo $topprofile->user;?>"><?php echo $topprofile->user; ?></a>
		</td>
		<td  class="td-2">
			<img class = "jr-forum-stat-bar" src = "<?php echo JB_TMPLTMAINIMGURL.'/images/bar.gif';?>" alt = "" height = "10" width = "<?php echo $barwidth;?>%"/>
		</td>
		<td  class="td-3">
			<?php echo $topprofile->hits; ?>
		</td>
	</tr>
<?php }   ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<?php
if (file_exists(JB_ABSTMPLTPATH . '/plugin/who/whoisonline.php')) {
    include(JB_ABSTMPLTPATH . '/plugin/who/whoisonline.php');
}
else {
    include(JB_ABSPATH . '/template/default/plugin/who/whoisonline.php');
}
?>