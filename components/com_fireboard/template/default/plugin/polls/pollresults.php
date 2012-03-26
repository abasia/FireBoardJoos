<?php
/**
* Fireboard Component
* @package Fireboard
*
* @Russian edition by Adeptus (C) 2007
*
**/
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
	$vopros = $database->loadResult();
	$database->setQuery("SELECT closed FROM #__fb_polls WHERE threadid=$thread");
	$closed = $database->loadResult();
	$database->setQuery("SELECT pollotvet FROM #__fb_pollsotvet WHERE poll_id=$thread");
	$otvets = $database->loadObjectlist();
	$database->setQuery("SELECT COUNT(*) FROM #__fb_pollsresults WHERE threadid=$thread AND answer='1'");
	$kol1 = $database->loadResult();
	$database->setQuery("SELECT COUNT(*) FROM #__fb_pollsresults WHERE threadid=$thread AND answer='2'");
	$kol2 = $database->loadResult();
	$database->setQuery("SELECT COUNT(*) FROM #__fb_pollsresults WHERE threadid=$thread AND answer='3'");
	$kol3 = $database->loadResult();
	$database->setQuery("SELECT COUNT(*) FROM #__fb_pollsresults WHERE threadid=$thread AND answer='4'");
	$kol4 = $database->loadResult();
	$database->setQuery("SELECT COUNT(*) FROM #__fb_pollsresults WHERE threadid=$thread AND answer='5'");
	$kol5 = $database->loadResult();
	$summ = $kol1+$kol2+$kol3+$kol4+$kol5;
	$is_user =(strtolower($my->usertype) <> '');
	$aj = $mosConfig_live_site.'/components/com_fireboard/template/default/js/';
	?>
<script type="text/javascript" src="<?php echo JB_JLIVEURL;?>/components/com_fireboard/template/default/js/prompt.js"></script>
<div id="allpoll">
<table class="fb_blocktable" id="currpoll" border="0" cellspacing="0" cellpadding="0">
  <thead>
    <tr>
      <th colspan="2">
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
    <tr>
      <td width="20%" style="padding:5px; border-bottom:1px solid #CCC;">
		<?php echo '<strong>'._FB_POLL_QUESTION.':</strong>';?>
		</td>
      <td width="80%" style="text-transform:uppercase; color:#CC0000; padding:5px; border-bottom:1px solid #CCC; border-left:1px solid #CCC;">
		<?php echo '<strong>'.$vopros.'</strong>';?>
		</td>
    </tr>
	<tr>
		<td width="20%" valign="top" style="padding:5px; border-right:1px solid #CCC; border-bottom:1px solid #CCC;">
			<?php echo _FB_POLL_RES; ?>
		</td>
		<td width="80%">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<?php
			for ($i=0; $i<5; $i++)
			{
				$otv = $otvets[$i]->pollotvet;
				$nnn = $i+1;
				if ($otv !='' && $otv != NULL)
				{
					if (!$summ)
					{
						$proc = 0;
					}
					else
					{
						$proc = 100/$summ;
					}
					if ($nnn == 1) $kol = $kol1;
					if ($nnn == 2) $kol = $kol2;
					if ($nnn == 3) $kol = $kol3;
					if ($nnn == 4) $kol = $kol4;
					if ($nnn == 5) $kol = $kol5;
					$myproc = $kol*$proc;
					$myproc = number_format($myproc, 2, ',', '');
					$len = $myproc*3;
					?>
					<tr>
						<td width="auto" style="border-bottom:1px solid #CCC; padding:5px;">
							&nbsp;&nbsp;<strong><?php echo $otv;?>&nbsp;&nbsp;</strong>
						</td>
						<td width="auto" style="color:#0000FF; padding:5px; border-bottom:1px solid #CCC; border-left:1px solid #CCC; border-right:1px solid #CCC;">
							<?php echo $kol;?>&nbsp;&nbsp;(<?php echo $myproc;?>%)
						</td>
						<td width="300px" align="left" style="padding:5px; border-bottom:1px solid #CCC;">
							<div style="width:<?php echo $len;?>px; height:20px; border:1px outset; background-color:#336699;" title="<?php echo $otv.':'.$myproc.'%';?>">&nbsp;
							</div>
						</td>
					</tr>
				<?php
				}
			}?>
			</table>
		</td>
	</tr>
	<tr>
		<td width="20%" style=" background-color:#E8FFFF"></td>
		<td width="80%" style="padding:5px; background-color:#E8FFFF">
		<?php
		if (!$closed)
		{
			echo '&nbsp;<strong>'._FB_ALREDY_POLL.'</strong>';
		}
		else
		{
			echo '&nbsp;<span style="color:#FF0000;"><strong>'._FB_POLL_CLOSED.'</strong></span>';
		}
		?>
		</form>
		</td>
	</tr>
  </tbody>
</table>
</div>