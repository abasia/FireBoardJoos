<?php
/**
* @version $Id: fb_write.html.php 513 2007-12-18 22:30:16Z danialt $
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
global $fbConfig,$mosConfig_live_site;
$htmlText = stripslashes($htmlText);
include_once(JB_ABSSOURCESPATH . 'fb_bb.js.php');
?>
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
<table class = "fb_blocktable<?php echo $objCatInfo->class_sfx; ?>" id="fb_postmessage"  border = "0" cellspacing = "0" cellpadding = "0" width="100%">
    <thead>
        <tr>
            <th colspan = "2">
                <div class = "fb_title_cover fbm">
                    <span class = "fb_title fbxl"> <?php echo _POST_MESSAGE; ?>"<?php echo $objCatInfo->name; ?>"</span>
                </div>
            </th>
        </tr>
    </thead>
    <tbody id = "fb_post_message">
        <tr class = "<?php echo $boardclass; ?>sectiontableentry2">
            <td class = "fb_leftcolumn">
                <strong><?php echo _GEN_NAME; ?></strong>:
            </td>

            <?php
            if (($fbConfig['regonly'] == "1" || $fbConfig['changename'] == '0') && $my_id != "" && !$is_moderator) {
                echo "<td><input type=\"hidden\" name=\"fb_authorname\" size=\"35\" class=\"" . $boardclass . "inputbox postinput\"  maxlength=\"35\" value=\"$authorName\" /><b>$authorName</b></td>";
            }
            else
            {
                if ($registeredUser == 1) {
                    echo "<td><input type=\"text\" name=\"fb_authorname\" size=\"35\"  class=\"" . $boardclass . "inputbox postinput\"  maxlength=\"35\" value=\"$authorName\" /></td>";
                }
                else
                {
                    echo "<td><input type=\"text\" name=\"fb_authorname\" size=\"35\"  class=\"" . $boardclass . "inputbox postinput\"  maxlength=\"35\" value=\"\" />";
                    echo "<script type=\"text/javascript\">document.postform.fb_authorname.focus();</script></td>";
                    $setFocus = 1;
                }
            }
            ?>
        </tr>

        <?php
        if ($fbConfig['askemail'])
        {
            if (($fbConfig['regonly'] == "1" || $fbConfig['changename'] == '0') && $my_id != "" && !$is_moderator) {
                echo "<tr><td class=\"fb_leftcolumn\"><strong>"
                         . _GEN_EMAIL . "*</strong>:</td><td><input type=\"hidden\" name=\"email\" size=\"35\" class=\"" . $boardclass . "inputbox postinput\" maxlength=\"35\" value=\"$my_email\" />$my_email</td></tr>";
            }
            else
            {
                if ($registeredUser == 1) {
                    echo "<tr><td class=\"fb_leftcolumn\"><strong>"
                             . _GEN_EMAIL . "*</strong>:</td><td><input type=\"text\" name=\"email\"  size=\"35\" class=\"" . $boardclass . "inputbox postinput\" maxlength=\"35\" value=\"$my_email\" /></td></tr>";
                }
                else {
                    echo "<tr><td class=\"fb_leftcolumn\"><strong>" . _GEN_EMAIL . "*</strong>:</td><td><input type=\"text\" name=\"email\" size=\"35\" class=\"" . $boardclass . "inputbox postinput\" maxlength=\"35\" value=\"\" /></td></tr>";
                }
            }
        }
        else {
            echo $registeredUser ? '<tr><td><input type="hidden" name="email" value="' . $my_email . '" /></td></tr>' : '<tr><td><input type="hidden" name="email" value="anonymous@forum.here" /></td></tr>';
        }
        ?>
        <tr class = "<?php echo $boardclass; ?>sectiontableentry1">
            <?php
            if (!$fromBot)
            {
            ?>
                <td class = "fb_leftcolumn">
                    <strong><?php echo _GEN_SUBJECT; ?></strong>:
                </td>
                <td>
                    <input type = "text" class = "<?php echo $boardclass; ?>inputbox postinput" name = "subject" size = "35" maxlength = "<?php echo $fbConfig['maxSubject'];?>" value = "<?php echo $resubject;?>"/>
                </td>
            <?php
            }
            else
            {
            ?>
                <td class = "fb_leftcolumn">
                    <strong><?php echo _GEN_SUBJECT; ?></strong>:
                </td>
                <td>
                    <input type = "hidden" class = "inputbox" name = "subject" size = "35" maxlength = "<?php echo $fbConfig['maxSubject'];?>" value = "<?php echo $resubject;?>"/><?php echo $resubject; ?>
                </td>
            <?php
            }
            if ($setFocus == 0 && $replyto == 0 && !$fromBot)
            {
                echo "<script type=\"text/javascript\">document.postform.subject.focus();</script>";
                $setFocus = 1;
            }
            ?>
        </tr>
        <tr class = "<?php echo $boardclass; ?>sectiontableentry2">
            <td class = "fb_leftcolumn">
                <strong><?php echo _GEN_TOPIC_ICON; ?></strong>:
            </td>
            <td class = "fb-topicicons">
                <?php
				$myicon = $message->topic_emoticon;
                $topicToolbar = smile::topicToolbar($myicon, $fbConfig['rtewidth']);
                echo $topicToolbar;
                ?>
            </td>
        </tr>
        <?php
        if (!$fbConfig['rte']) {
            $useRte = 0;
        }
        else {
            $useRte = 1;
        }
        $fbTextArea = smile::fbWriteTextarea('message', $htmlText, $fbConfig['rtewidth'], $fbConfig['rteheight'], $useRte, $fbConfig['disemoticons']);
        echo $fbTextArea;
        if ($setFocus == 0) {
            echo "<script type=\"text/javascript\">document.postform.message.focus();</script>";
        }
        if ($fbConfig['allowsubscriptions'] == 1)
        {
            if ($replyto == 0) {
                $fb_thread = -1;
            }
            else
            {
                $database->setQuery("select thread from #__fb_messages where id=$replyto");
                $fb_thread = $database->loadResult();
            }
            $database->setQuery("SELECT thread from #__fb_subscriptions where userid=$my_id and thread='$fb_thread'");
            $fb_subscribed = $database->loadResult();

            if ($fb_subscribed == "" || $replyto == 0) {
                $fb_cansubscribe = 1;
            }
            else {
                $fb_cansubscribe = 0;
            }
        }
?>
<!-- preview -->
        <tr class = "<?php echo $boardclass; ?>sectiontableentry2" id="previewContainer" style="display:none;">
           <td class = "fb_leftcolumn">
                <a href="javascript:void(0);" onclick="$('#previewContainer').hide();" title="<?php echo _AFB_PRW;?>"><strong><?php echo _PREVIEW; ?></strong>:</a>
            </td>
           <td>
  				<div class="previewMsg" id="previewMsg" style="overflow:auto;"></div>
            </td>
        </tr>
<!-- /preview -->
<?php
////////////////////////mfu
	if(file_exists($mosConfig_absolute_path.'/components/com_fireboard/template/default/plugin/mfu/mfu.php'))
	{
		$database->setQuery("SELECT * FROM #__fb_mfu WHERE mesid=".$message->id);
	?>
			<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/components/com_fireboard/template/default/plugin/mfu/mfu.js"></script>
			<tr class = "<?php echo $boardclass; ?>sectiontableentry1">
				<td class = "fb_leftcolumn">
					<strong><?php echo _COM_A_FILE;?></strong><br/>
					<span style="font-size:10px;">
						<?php echo _COM_A_FILEALLOWEDTYPES.':<br/>'.$fbConfig['fileTypes'];?>
					</span>
				</td>
				<td>
					<table width="99%">
						<tbody>
							<tr>
								<td colspan="2">
									<input type='file' class='button' id='first_file_element'/>
								</td>
							</tr>
								<div id="files_list" style="width:50%;"></div>
									<script type="text/javascript">
										var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 5 );
										multi_selector.addElement( document.getElementById( 'first_file_element' ) );
									</script>
						</tbody>
					</table>
				</td>
            </tr>		
	<?php
	}
	else
	{
        if (($fbConfig['allowImageUpload'] || ($fbConfig['allowImageRegUpload'] && $my->id != 0) || $is_moderator) && ($no_upload == "0" || $no_image_upload == "0"))
        {
        ?>
				<tr class = "<?php echo $boardclass; ?>sectiontableentry1">
					<td class = "fb_leftcolumn">
						<strong><?php echo _IMAGE_SELECT_FILE;?></strong>
					</td>
					<td>
						<input type = 'file' class = 'button' name = 'attachimage' onmouseover = "helpline('iu')"/>
						<input type = "button" class = "button" name = "addImagePH" value = "<?php echo _POST_ATTACH_IMAGE;?>" style = "cursor:pointer; width: 40px; text-align:center;" onclick = "javascript:emo(' [img] ');" onmouseover = "helpline('ip')"/>
					</td>
            </tr>
        <?php
        }
        if (($fbConfig['allowFileUpload'] || ($fbConfig['allowFileRegUpload'] && $my->id != 0) || $is_moderator) && ($no_upload == "0" || $no_file_upload == "0"))
        {
        ?>
            <tr class = "<?php echo $boardclass; ?>sectiontableentry2">
                <td class = "fb_leftcolumn">
                    <strong><?php echo _FILE_SELECT_FILE; ?></strong>
                </td>
                <td>
                    <input type = 'file' class = 'button' name = 'attachfile' onmouseover = "helpline('fu')" style = "cursor:pointer"/>
                    <input type = "button" class = "button" name = "addFilePH" value = "<?php echo _POST_ATTACH_FILE;?>" style = "cursor:pointer; width: 40px; text-align:center;" onclick = "javascript:emo(' [file] ');" onmouseover = "helpline('fp')"/>
                </td>
            </tr>
        <?php
        }
	}
        if ($my_id != 0 && $fbConfig['allowsubscriptions'] == 1 && $fb_cansubscribe == 1 && !$editmode)
        {
        ?>
            <tr class = "<?php echo $boardclass; ?>sectiontableentry1">
                <td class = "fb_leftcolumn">
                    <strong><?php echo _POST_SUBSCRIBE; ?></strong>:
                </td>
                <td>
                    <?php
                    if ($fbConfig['subscriptionschecked'] == 1)
                    {
                    ?>
                            <input type = "checkbox" name = "subscribeMe" value = "1" checked/>
                            <i><?php echo _POST_NOTIFIED; ?></i>
                    <?php
                    }
                    else
                    {
                    ?>
                        <input type = "checkbox" name = "subscribeMe" value = "1"/>
                        <i><?php echo _POST_NOTIFIED; ?></i>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
		if ($fbConfig['captcha'] == 1 && $my->id < 1) { ?>
        <tr class = "<?php echo $boardclass; ?>sectiontableentry1">
            <td class = "fb_leftcolumn">&nbsp;<strong><?php echo _FB_CAPDESC; ?></strong>&nbsp;</td>
            <td align="left" valign="middle" height="35px">&nbsp;<input name="txtNumber" type="text" id="txtNumber" value="" class="button" style="vertical-align:top" size="15">          
			<img src="<?php echo JB_DIRECTURL ;?>/template/default/plugin/captcha/randomImage.php" alt="" />
		 </td>
         </tr>    
        <?php
		}
		?>
        <tr>
            <td colspan = "2" style = "text-align: center;">
                <input type = "submit" class = "button" name = "submit" value = "<?php echo _GEN_CONTINUE;?>" onclick = "return submitForm()" onmouseover = "helpline('submit')"/>
                 <input name="preview" type="button" class="button"  onClick="fbGetPreview(document.postform.message.value,<?php echo FB_FB_ITEMID;?>);" value="<?php echo _PREVIEW?>" onmouseover = "helpline('preview');">
                <input type = "button" class = "button" value = "<?php echo _GEN_CANCEL;?>" onclick = "javascript:window.history.back();" onmouseover = "helpline('cancel')"/>
            </td>
        </tr>
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<input type="hidden" value="<?php echo JB_DIRECTURL . '/template/default';?>" name="templatePath"/>
</form>
</td>
</tr>
<tr>
    <td>
        <?php
        if ($fbConfig['askemail']) {
            echo $fbConfig['showemail'] == '0' ? "<em>* - " . _POST_EMAIL_NEVER . "</em>" : "<em>* - " . _POST_EMAIL_REGISTERED . "</em>";
        }
        ?>
    </td>
</tr>
<tr>
    <td style = "text-align: left;">
        <br/>
    <?php
    $no_upload = "0";
    if ($fbConfig['showHistory'] == 1) {
        listThreadHistory($replyto, $fbConfig, $database);
    }
?>