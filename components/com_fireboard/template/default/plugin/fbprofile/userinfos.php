<?php
/**
* @version $Id: userinfos.php 481 2007-12-13 08:21:14Z fxstein $
* Fireboard Component
* @package Fireboard
* @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.bestofjoomla.com
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
<table class = "fb_blocktable " id="fb_userinfo" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
    <thead>
        <tr>
            <th>
                <div class = "fb_title_cover fbm" align="center">
                    <span class="fb_title fbxl"><?php echo _FB_USERPROFILE_PROFILE; ?></span>
                </div>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class = "<?php echo $boardclass; ?>profileinfo" align="center">
                <div class = "fb-usrprofile-misc">
                    <span class = "view-username" style="font-weight:bold;"><?php echo $msg_username; ?></span>
                    <br/><?php echo $msg_avatar; ?>
                <?php
                    $gr_title=getFBGroupName($lists["userid"]);
                    if ($gr_title->id > 1)
                    {
                ?>
                    <br/><div class="view-group_<?php echo $gr_title->id;?>"></div>
                <?php
                     }
					 else
					 {?>
					 	<div class="viewcover">
							<?php echo $gr_title->title;?>
						</div>
					 <?php
					 }
                     if ($msg_userrank)
					 {
						echo '<div class = "viewcover">';
	                    echo $msg_userrank;
						echo '</div>';
					}
                     if ($msg_userrankimg)
					 {
						echo '<div class = "viewcover">';
 						echo $msg_userrankimg;
						echo '</div>';
					}
                        ?>
						<div class="viewcover">
							<?php echo _FB_USERPROFILE_PROFILEHITS; ?>: <?php echo $msg_userhits; ?> 
						</div>
                    <?php
                        if ($msg_posts)
                            echo $msg_posts;
                        if ($useGraph)
						{
                            $myGraph->BarGraphHoriz();
							echo '<br/>';
						}
                        	echo $msg_online;
                        if ($msg_pms) echo '&nbsp;'.$msg_pms;
							echo '<br/>';
                        if ($msg_icq)
                            echo $msg_icq;
                        if ($msg_msn)
                            echo $msg_msn;
                        if ($msg_yahoo)
                            echo $msg_yahoo;
                    ?>
                </div>
                <span class = "msgkarma">
            <?php
                if ($msg_karma)
                    echo '<br/>'.$msg_karma . '&nbsp;&nbsp;' . $msg_karmaplus . ' ' . $msg_karmaminus.'<br/><br/>';
                else
                    echo '&nbsp;';
            ?></span>
            </td>
        </tr>
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>