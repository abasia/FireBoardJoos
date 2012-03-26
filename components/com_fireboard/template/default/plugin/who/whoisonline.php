<?php
/**
* @version $Id: whoisonline.php 462 2007-12-10 00:05:53Z fxstein $
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
global $fbConfig, $my;
if ($fbConfig['showWhoisOnline'] > 0)
{
    $whoislink = sefRelToAbs('index.php?option=com_fireboard&amp;func=who');
    $query
        = "SELECT w.userip, w.time, w.what, u.username, u.id, k.moderator, k.showOnline "
        . "\n FROM #__fb_whoisonline AS w"
        . "\n LEFT JOIN #__users AS u ON u.id=w.userid "
        . "\n LEFT JOIN #__fb_users AS k ON k.userid=w.userid "
        . "\n INNER JOIN #__session AS s "
	. "\n  ON s.guest=0 AND s.userid=w.userid "
        . "\n WHERE w.userid!=0 "
        . "\n GROUP BY u.id "
        . "\n  ORDER BY w.time DESC";
    $database->setQuery($query);
    $users = $database->loadObjectList();
    $totaluser = count($users);
    $query = "SELECT COUNT(*) FROM #__fb_whoisonline WHERE user = 0";
    $database->setQuery($query);
    $totalguests = $database->loadResult();
?>
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
    <table class = "fb_blocktable" id ="fb_whoisonline"  border = "0" cellspacing = "0" cellpadding = "0" width="100%">
        <thead>
            <tr>
                <th align="left">
                    <div class = "fb_title_cover fbm">
                        <a class = "fb_title fbxl" href = "<?php echo $whoislink;?>">
						<?php echo _WHO_ONLINE_NOW; ?>               
                        <b><?php echo $totaluser; ?></b> 
						<?php if($totaluser==1) { echo _WHO_ONLINE_MEMBER; } else { echo _WHO_ONLINE_MEMBERS; } ?>
						<?php echo _WHO_AND; ?> 
                        <b><?php echo $totalguests; ?></b> 
						<?php if($totaluser==1) { echo _WHO_ONLINE_GUEST; } else { echo _WHO_ONLINE_GUESTS; } ?>
                        </a>
                    </div>
                    <img id = "BoxSwitch_whoisonline__whoisonline_tbody" class = "hideshow" src = "<?php echo JB_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
                </th>
            </tr>
        </thead>
        <tbody id = "whoisonline_tbody">
            <tr class = "<?php echo $boardclass ;?>sectiontableentry1">
                <td class = "td-1 fbm" align="left">
                    <?php
                    foreach ($users as $user)
                    {
                        $grp = getFBGroupName($user->id);
                        $time = date("H:i:s", $user->time);
                  		if ( $user->showOnline > 0 ){ ?>
                            <a class="fb_group<?php echo $grp->id;?>" href = "<?php echo sefRelToAbs(FB_PROFILE_LINK_SUFFIX.''.$user->id) ;?>" title = "<?php echo $time;?>"><?php echo $user->username; ?></a>&nbsp;
                		  <?php
						}
                    }
                    if ( $my->gid > 1 ){ 
					 ?> 
                    <br /><span class="fbs"><b><?php echo _FB_HIDDEN_USERS; ?>: </b></span> 
                    <?php 
					} 
                    foreach ($users as $user)
                    {
                        $grp = getFBGroupName($user->id);
                        $time = date("H:i:s", $user->time);
                  		if ( $user->showOnline < 1 && $my->gid > 1 ){ ?>
							<a class="fb_group<?php echo $grp->id;?>" href = "<?php echo sefRelToAbs(FB_PROFILE_LINK_SUFFIX.''.$user->id) ;?>" title = "<?php echo $time;?>"><?php echo $user->username; ?></a>&nbsp;
                		  <?php   }
                    }
                    $database->setQuery("select id, title from #__fb_groups");
                    $gr_row = $database->loadObjectList();
                    if (count($gr_row) > 1) {
					?>
                    <div class="fbgrouplist  fbs">
                    <?php
                    foreach ($gr_row as $gr)
                    {
                    ?>
                        &nbsp;<span class="fb_group<?php echo $gr->id;?>">[<?php echo $gr->title; ?>]</span>
                    <?php
                    } ?>
                    </div>
                    <?php
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
<?php
}
?>