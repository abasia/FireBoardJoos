<?php
/**
* @version $Id: message.php 481 2007-12-13 08:21:14Z fxstein $
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
$my = FBJConfig::my();
$database = FBJConfig::database();
$fbConfig = FBJConfig::getInstance();
unset($user);
$database->setQuery("SELECT email, name from #__users WHERE `id`={$my->id}");
$database->loadObject($user);
?>
<table width = "100%" border = "0" cellspacing = "0" cellpadding = "0">
    <caption>
        <a name = "<?php echo $msg_id;?>"/>
    </caption>
    <tbody>
        <tr class = "fb_sth">
            <th colspan = "2" class = "view-th <?php echo $boardclass; ?>sectiontableheader">
               <a name="#<?php echo $msg_id;?>" href="<?php echo htmlspecialchars(sefRelToAbs("index.php?".$_SERVER["QUERY_STRING"]))?>#<?php echo $msg_id; ?>" id="<?php echo htmlspecialchars(sefRelToAbs("index.php?".$_SERVER["QUERY_STRING"]))?>#<?php echo $msg_id; ?>">#<?php echo $msg_id; ?></a>
            </th>
        </tr>
        <tr>
              <td class = "fb-msgview-left">
                <div class = "fb-msgview-l-cover">
                    <span class = "view-username"><a href = "<?php echo $msg_prflink ; ?>"><?php echo $msg_username; ?></a></span>
                    <br/>
                    <a href = "<?php echo $msg_prflink ; ?>"><?php echo $msg_avatar; ?></a>
				<?php
                $gr_title = getFBGroupName($lists["userid"]);
                if ($gr_title->id > 1)
                {?>
                 <div class="view-group_<?php echo $gr_title->id;?>">
				 </div>
                <?php
				}
				else
				{
					echo '<span>'.$gr_title->title.'</span><br/>';
				}
				if ($msg_personal) { ?>
                   <div class = "viewcover" style="font-size:10px; color:#CC0000;">
	                   <?php echo $msg_personal; ?>
    	           </div>
                <?php  }
                    if ($msg_userrank) {
						echo '<div class = "viewcover" style="font-size:10px;">';
                        echo $msg_userrank;
						echo '</div>';
                    }
                    if ($msg_userrankimg) {
						echo '<div class = "viewcover">';
                        echo $msg_userrankimg;
						echo '</div>';
                    }
                    if ($msg_posts) {
                        echo $msg_posts;
                    }
                    if ($useGraph) {
                        $myGraph->BarGraphHoriz();
                    }
                   echo '<br/>'.$msg_online;
                    if ($msg_pms) {
                        echo '&nbsp;'.$msg_pms;
                    }
                    if ($msg_profile) {
                        echo '&nbsp;'.$msg_profile;
                    }
                    ?>
                    <br />
 					<?php
                    if ($msg_icq) {
                        echo $msg_icq;
                    }
                    if ($msg_gender) {
                        echo $msg_gender;
                    }
                    if ($msg_skype) {
                        echo $msg_skype;
                    }
                    if ($msg_website) {
                        echo $msg_website;
                    }
                    if ($msg_gtalk) {
                        echo $msg_gtalk;
                    }
                    if ($msg_yim) {
                        echo $msg_yim;
                    }
                    if ($msg_msn) {
                        echo $msg_msn;
                    }
                    if ($msg_aim) {
                        echo $msg_aim;
                    }
                    if ($msg_location) {
                        echo $msg_location;
                    }
                    if ($msg_birthdate) {
                        echo $msg_birthdate;
                    }
                    ?>
                </div>
				<?php
				if ($msg_foto)
				{?>
				<div align="center">
					<?php echo '<a href="javascript:void(0);" onclick=\'$j("#album").load("'.$mosConfig_live_site.'/components/com_fireboard/template/default/plugin/foto/show.php", {userid:'.$msg_foto.'}); $j("#foto_destroy").show();\' title="'._AFB_FOTOALBUM_DESC.'">'.
						_AFB_FOTOALBUM.'</a>';?>
				</div>
				<?php
				}?>
            </td>
            <td class = "fb-msgview-right">
                <table width = "100%" border = "0" cellspacing = "0" cellpadding = "0">
                    <tr>
                        <td align = "left">
                            <?php
                            $msg_time_since = _FB_TIME_SINCE;
                            $msg_time_since = str_replace('%time%', time_since($fmessage->time , FBTools::fbGetInternalTime()), $msg_time_since);
                            ?>
                            <span class = "msgtitle"><?php echo $msg_subject; ?></span><span class = "msgdate" title="<?php echo $msg_date; ?>"><?php echo $msg_time_since; ?></span>
                        </td>
                        <td align = "right">
                            <span class = "msgkarma">
                            <?php
                            if ($msg_karma) {
                                echo $msg_karma . '&nbsp;&nbsp;' . $msg_karmaplus . ' ' . $msg_karmaminus;
                            }
                            else {
                                echo '&nbsp;';
                            }
                            ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "2" valign = "top">
                            <div class = "msgtext"><?php echo $msg_text; ?></div>
                            <?php
                            if (!$msg_closed)
                            {
                            ?>
                                <div id = "sc<?php echo $msg_id; ?>" class = "switchcontent">
                                    <?php
                                    if ($fbConfig->username) {
                                        $authorName = $my->username;
                                    }
                                    else {
                                        $authorName = $user->name;
                                    }
                                    $table = array_flip(get_html_translation_table(HTML_ENTITIES,ENT_NOQUOTES));
                                    $resubject = htmlspecialchars(strtr($msg_subject, $table));
                                    $resubject = strtolower(substr($resubject, 0, strlen(_POST_RE))) == strtolower(_POST_RE) ? stripslashes($resubject) : _POST_RE . stripslashes($resubject);
                                    ?>
                            <form action = "<?php echo sefRelToAbs(JB_LIVEURLREL. '&amp;func=post'); ?>" method = "post" name = "postform" enctype = "multipart/form-data">
                                <input type = "hidden" name = "parentid" value = "<?php echo $msg_id;?>"/>
                                <input type = "hidden" name = "catid" value = "<?php echo $catid;?>"/>
                                <input type = "hidden" name = "action" value = "post"/>
                                <input type = "hidden" name = "contentURL" value = "empty"/>
                                <input type = "hidden" name = "fb_authorname" size = "35" class = "inputbox" maxlength = "35" value = "<?php echo $authorName;?>"/>
                                <input type = "hidden" name = "email" size = "35" class = "inputbox" maxlength = "35" value = "<?php echo $user->email;?>"/>
                                <input type = "hidden" name = "subject" size = "35" class = "inputbox" maxlength = "<?php echo $fbConfig->maxSubject;?>" value = "<?php echo $resubject;?>"/>
                                <textarea class = "inputbox" name = "message" id = "message" style = "height: 100px; width: 100%; overflow:auto;"></textarea>
                                                                 <?php
								// Begin captcha . Thanks Adeptus 
								if ($fbConfig->captcha == 1 && $my->id < 1) { ?>
								<?php echo _FB_CAPDESC.'&nbsp;'?>
								<input name="txtNumber" type="text" id="txtNumber" value="" style="vertical-align:middle" size="10">&nbsp;
								<img src="<?php echo JB_DIRECTURL ;?>/template/default/plugin/captcha/randomImage.php" alt="" /><br />
								<?php
								}
								?>
                                <input type = "submit" class = "fb_qm_btn" name = "submit" value = "<?php echo _GEN_CONTINUE;?>"/>
                                <input type = "button" class = "fb_qm_btn fb_qm_cncl_btn" id = "cancel__<?php echo $msg_id; ?>" name = "cancel" value = "<?php echo _FB_CANCEL;?>"/>
                                <small><em><?php echo _FB_QMESSAGE_NOTE?></em></small>
                            </form>
                                </div>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
		<?php
		////////////////////////mfu
		if(file_exists($mosConfig_absolute_path.'/components/com_fireboard/template/default/plugin/mfu/mfu.php') && $fbConfig->mfu == '1')
		{
			Error_Reporting(E_ERROR);
			$mydir = $mosConfig_absolute_path.'/images/fbfiles/files/'.$msg_id;
			$mydirrel = $mosConfig_live_site.'/images/fbfiles/files/'.$msg_id;
			$images = array('jpg','gif','bmp','png','tif');
			$myfiles = array();
			if ($handle = opendir($mydir))
			{
				while (false !== ($file = readdir($handle)))
				{
					if ($file != "." && $file != "..")
					{
						$myfiles[] = $file;
					}
				}
				closedir($handle);
			}
			if(count($myfiles) != 0)
			{
				$att_id = mt_rand();?>
		<tr>
			<td class = "fb-msgview-left-c">&nbsp;
			</td>
			<td>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td class="att_td" onclick="$j('div#<?php echo $att_id;?>').slideToggle();">
							<?php echo _AFB_MFU_MYFILES_MSG;?>
						</td>
					</tr>
					<tr>
			            <td class = "fb-msgview-right-c">
							<div class="fb_files" id="<?php echo $att_id;?>" style="display:none">
							<?php
								foreach($myfiles as $myfile)
								{
									$myext = strtolower(substr($myfile,-3));
									if(in_array($myext,$images))
									{
										$size = getimagesize($mydir.'/'.$myfile);
										$max = $size[0];
										if($fbConfig->mfu_max_img == 0 OR $fbConfig->mfu_max_img == NULL OR $fbConfig->mfu_max_img == '') $fbConfig->mfu_max_img = 100;
										if($max > $fbConfig->mfu_max_img) $max = $fbConfig->mfu_max_img;
							?>
										<a href="<?php echo $mydirrel.'/'.$myfile;?>" rel="fancybox" title="">
											<img src="<?php echo $mydirrel.'/'.$myfile;?>" width="<?php echo $max;?>" alt="" style="margin:5px; border:1px solid #555; vertical-align:top">
										</a>
									<?php
									}
								}
								echo '<hr/>';
								foreach($myfiles as $myfile)
								{
									$myext = strtolower(substr($myfile,-3));
									if(!in_array($myext,$images))
									{
										if($fbConfig->attach_guests != 0 OR $my->id)
										{
											$size = filesize($mydir.'/'.$myfile);
											$size = number_format($size/1048576, 3, '.', '');
											if ($size < 0.001) $size = 0.001;
									?>
											<a href="<?php echo $mydirrel.'/'.$myfile;?>" title="">
												<?php echo $myfile;?>
											</a> <span class="mfu_size">[<?php echo $size._AFB_MFU_S;?>]</span><br/>
									<?php
										}
									}
								}?>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
			<?php
			}
		}
		///////////////////////////mfu
		?>
		<tr>
            <td class = "fb-msgview-left-c">&nbsp;
            </td>
            <td class = "fb-msgview-right-c" >  
                         <div class="fb_smalltext" >   
                   <?php 
                            if ($fbConfig->reportmsg && $my->id > 0)
							{
                            	$link = sefRelToAbs('index.php?option=com_fireboard&amp;func=report&amp;Itemid='.FB_FB_ITEMID.'&amp;msg_id='.$msg_id.'&amp;catid='.$catid);
                            ?>                              
                            	<a  href="<?php echo $link;?>" title="#<?php echo $msg_id;?>">
									<?php echo _FB_REPORT;?>
								</a>&nbsp;
                            <?php
							}
                            echo $fbIcons->msgip ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->msgip . '" border="0" alt="'. _FB_REPORT_LOGGED.'" />' . '' : '  <img src="' . JB_URLEMOTIONSPATH . 'ip.gif" border="0"   alt="'. _FB_REPORT_LOGGED.'" />'; ?><span class="fb_smalltext"><?php echo _FB_REPORT_LOGGED;?></span>
                            <?php if($msg_ip) echo ''.$msg_ip_link.''.$msg_ip.'</a>'; else echo '&nbsp;';?>
                            </div>
       </td>
        </tr> 
<?php
if ($fmessage->modified_by) {
  ?>
        <tr>
            <td class = "fb-msgview-left-c">&nbsp;
            </td>
            <td class = "fb-msgview-right-c" >                  
                    <div class="fb_message_editMarkUp_cover">
                    <span class="fb_message_editMarkUp" ><?php echo _FB_EDITING_LASTEDIT;?>: <?php echo date(_DATETIME, $fmessage->modified_time);?> <?php echo _FB_BY; ?> <?php echo FBTools::whoisID($fmessage->modified_by)?>.
                    <?php
                    if ($fmessage->modified_reason) {
                    echo _FB_REASON.": ".$fmessage->modified_reason;
                    }
                        ?></span>
                    </div>
       </td>
        </tr>
<?php
}
if ($msg_signature) {
  ?>
        <tr>
            <td class = "fb-msgview-left-c">&nbsp;
            </td>
            <td class = "fb-msgview-right-c" >                  
				   <div class="msgsignature" >
					<?php   echo $msg_signature; ?>
				</div>
			</td>
        </tr>
<?php
}?>
        <tr>
            <td class = "fb-msgview-left-b">&nbsp;
            </td>
            <td class = "fb-msgview-right-b" align = "right">
                <span id = "fb_qr_sc__<?php echo $msg_id;?>" class = "fb_qr_fire" style = "cursor:pointer">
                <?php
                //we should only show the Quick Reply section to registered users. otherwise we are missing too much information!!
                if ($my->id > 0 && !$msg_closed)
                {
                echo
                    $fbIcons->quickmsg
                        ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->quickmsg . '" border="0" alt="' . _FB_QUICKMSG . '" />' . '' : '  <img src="' . JB_URLEMOTIONSPATH . 'quickmsg.gif" border="0"   alt="' . _FB_QUICKMSG . '" />'; ?>
                <?php
                }
                ?>
                </span>
                <?php
                if ($fbIcons->reply)
                {
                    if ($msg_closed == "")
                    {
                        echo $msg_reply;
                        echo " " . $msg_quote;
                        if ($msg_delete) {
                            echo " " . $msg_delete;
                        }
                        if ($msg_move) {
                            echo " " . $msg_move;
                        }
                        if ($msg_edit) {
                            echo " " . $msg_edit;
                        }
                        if ($msg_sticky) {
                            echo " " . $msg_sticky;
                        }
                        if ($msg_lock) {
                            echo " " . $msg_lock;
                        }
                    }
                    else {
                        echo $msg_closed;
                    }
                }
                else
                {
                    if ($msg_closed == "")
                    {
                        echo $msg_reply;
                ?>
                        |
                <?php
                echo $msg_quote;
                if ($msg_delete) {
                    echo " | " . $msg_delete;
                }
                if ($msg_move) {
                    echo " | " . $msg_move;
                }
                if ($msg_edit) {
                    echo " | " . $msg_edit;
                }
                if ($msg_sticky) {
                    echo " | " . $msg_sticky;
                }

                if ($msg_lock) {
                    echo "| " . $msg_lock;
                }
                    }
                    else {
                        echo $msg_closed;
                    }
                }
                ?>
            </td>
        </tr>
    </tbody>
</table>
<!-- Begin: Message Module Positions -->
<?php
if (mosCountModules('fb_msg_t'))
{
?>
    <div class = "fb_msg_t">
        <?php
        mosLoadModules('fb_msg_t', -2);
        ?>
    </div>
<?php
}
if (mosCountModules('fb_msg_1'))
{
    if ($mmm == 1)
    {
?>
            <div class = "fb_msg_1">
                <?php
                mosLoadModules('fb_msg_1', -2);
                ?>
            </div>
<?php
    }
}
if (mosCountModules('fb_msg_2'))
{
    if ($mmm == 2)
    {
?>
            <div class = "fb_msg_2">
                <?php
                mosLoadModules('fb_msg_2', -2);
                ?>
            </div>
<?php
    }
}
if (mosCountModules('fb_msg_b'))
{
?>
    <div class = "fb_msg_b">
        <?php
        mosLoadModules('fb_msg_b', -2);
        ?>
    </div>
<?php
}
?>