<?php
/**
* Fireboard Component
* @package Fireboard
*
* @Russian edition by Adeptus (C) 2007
*
**/
// Dont allow direct linking
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');       
$database->setQuery("SELECT avtorid FROM #__fb_polls WHERE threadid=$thread");
$avtorid=$database->loadResult();
if ($avtorid == $my->id OR FBTools::isModOrAdmin())
{
	$is_editor=true;
}
else
{
	$is_editor=false;
}
	$database->setQuery("SELECT moderator FROM #__fb_users WHERE userid=$my->id");
	$moder = $database->loadResult();
	$database->setQuery("SELECT vopros FROM #__fb_polls WHERE threadid=$thread");
	$vopros=$database->loadResult();
	$database->setQuery("SELECT closed FROM #__fb_polls WHERE threadid=$thread");
	$closed=$database->loadResult();
	$database->setQuery("SELECT pollid FROM #__fb_polls WHERE threadid=$thread");
	$pollid=$database->loadResult();
	$database->setQuery("SELECT pollotvet FROM #__fb_pollsotvet WHERE poll_id=$thread");
	$otvets=$database->loadObjectlist();
	$formlink = sefRelToAbs('index.php?option=com_fireboard&amp;func=view&amp;Itemid='.$Itemid.'&amp;catid='.$catid.'&amp;id='.$id).'#'.$id;
	$aj = $mosConfig_live_site.'/components/com_fireboard/template/default/js/';
?>
<div id="allpoll">
	<form action = "<?php echo $formlink; ?>" method = "post" name = "pollform">
    <table class = "fb_blocktable" id = "fb_announcement" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
        <thead>
            <tr>
                <th align="left" colspan="2">
                    <div class = "fb_title_cover fbm">
                        <span class = "fb_title fbl"><?php echo _FB_TOPIC_POLL; ?></span>
                    </div>
                    <img id = "BoxSwitch_announcements__announcements_tbody" class = "hideshow" src = "<?php echo JB_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
                </th>
            </tr>
        </thead>
    <tbody id = "announcements_tbody">
	<?php
	if ($is_editor OR $moder) {
	?>
		<script type="text/javascript">
			function removePoll(id){
				var txt = '<?php echo _AFB_REMPOLL;?><input type="hidden" id="thread" name="thread" value="'+ id +'" />';
				$.prompt(txt,{
					buttons:{<?php echo _ANN_DELETE;?>:true, <?php echo _GEN_CANCEL;?>:false},
					callback: function(v,m){
						if(v)
						{
							$.post("<?php echo $aj;?>removepoll.php", { thread: id },
							function(data){
								$.prompt('<?php echo _FB_BULKMSG_DELETED;?>');
								document.getElementById('allpoll').innerHTML='<div></div>';
								document.location.reload(true);
							});
						}
					}
				});
			}
			function closePoll(id){
				var txt = '<?php echo _AFB_CLOSEPOLL;?><input type="hidden" id="thread" name="thread" value="'+ id +'" />';
				$.prompt(txt,{
					buttons:{<?php echo _AFB_POLLCLOSE;?>:true, <?php echo _GEN_CANCEL;?>:false},
					callback: function(v,m){
						if(v)
						{
							$.post("<?php echo $aj;?>closepoll.php", { thread: id },
							function(data){
								$.prompt('<?php echo _FB_POLL_CLOSED;?>');
								document.location.reload(true);
							});
						}
					}
				});
			}
			function openPoll(id){
				var txt = '<?php echo _AFB_OPENPOLL;?><input type="hidden" id="thread" name="thread" value="'+ id +'" />';
				$.prompt(txt,{
					buttons:{<?php echo _AFB_POLLOPEN;?>:true, <?php echo _GEN_CANCEL;?>:false},
					callback: function(v,m){
						if(v)
						{
							$.post("<?php echo $aj;?>openpoll.php", { thread: id },
							function(data){
								$.prompt('<?php echo _AFB_POLLOPENED;?>');
								document.location.reload(true);
							});
						}
					}
				});
			}
		</script>
	<tr class = "fb_sth">
		<th class = "th-1 <?php echo $boardclass ;?>sectiontableheader fbm" align="left" colspan="3">
			<?php
			if ($is_editor)
			{?>
			<a href = "javascript:void(0);" onclick="removePoll(<?php echo $thread;?>);"><?php echo _ANN_DELETE; ?></a> |
			<?php
			}
			if ($closed)
			{?>
			<a href = "javascript:void(0);" onclick="openPoll(<?php echo $thread;?>);"><?php echo _AFB_POLLOPEN; ?> </a> | 
			<?php
			}
			if (!$closed)
			{?>
			<a href = "javascript:void(0);" onclick="closePoll(<?php echo $thread;?>);"><?php echo _AFB_POLLCLOSE; ?> </a> | 
			<?php
			}?>
		</th>
	</tr>
	<?php
    }
	?>
    <tr class="<?php echo $boardclass ;?>sectiontableentry2">
      <td class="td-1 fbm" width="20%">
		<?php
			echo '<strong>'._FB_POLL_QUESTION.':</strong>';
		?>
		</td>
      <td class="td-1 fbm" width="80%">
		<?php
			echo '<strong>'.$vopros.'</strong>';
		?>
		</td>
    </tr>
    <tr  class="<?php echo $boardclass ;?>sectiontableentry2">
		<td class="td-1 fbm" width="20%" valign="top">
			<?php	echo _FB_POLL_VARS; ?>
		</td>
		<td class="td-1 fbm" width="80%">
			<table width="100%">
	        <input type = "hidden" name = "threadid" value = "<?php echo $thread;?>"/>
			<input type = "hidden" name = "catid" value = "<?php echo $catid;?>"/>
			<input type = "hidden" name = "action" value = "poll"/>
			<input type = "hidden" name = "do" value = "answer"/>
			<input type = "hidden" name = "checkedrow" value = "rownumber"/>
	<?php
	for ($i=0; $i<5; $i++)
	{
		$otv = $otvets[$i]->pollotvet;
		$nnn = $i+1;
		if ($otv !='' && $otv != NULL)
		{?>
			<tr><td width="80%">&nbsp;
			<input type="radio" id="otvet" name="otvet" value="<?php echo $nnn;?>" />
			<?php echo '&nbsp;&nbsp;'.$otv;?>
			</td></tr>
		<?php 
		}
	}
	?>
		</table>
		</td>
	</tr>
	<tr>
		<td width="20%" class="td-1 fbm" style="border-left:1px solid #CCC;"></td>
		<td width="80%" style="border-right:1px solid #CCC; padding:3px;">
		<?php
		if ($alredypoll == 0 && !$closed)
		{
		?>
		&nbsp;<input type = "submit" class = "button" name = "submit" value = "<?php echo _FB_POLLSEND;?>" />
		<?php 
		}
		else
		{
		echo '&nbsp;<strong>'._FB_ALREDY_POLL.'</strong>';
		}
		?>
		</td>
	</tr>
  </tbody>
</table>
</form>
</div>