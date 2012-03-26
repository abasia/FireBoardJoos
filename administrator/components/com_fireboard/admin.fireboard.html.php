<?php
/**
 * @version $Id: admin.fireboard.html.php 462 2007-12-10 00:05:53Z fxstein $
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
class HTML_SIMPLEBOARD{
	function showFbHeader(){
		error_reporting(E_ERROR);
		?>
	<style>
		#fbadmin {
			text-align: left;
		}

		#fbheader {
			clear: both;
		}

		#fbmenu {
			margin-top: 15px;
			border-top: 1px solid #ccc;
			width: 99%;
		}

		#fbmenu a {
			display: block;
			font-size: 11px;
			border-left: 1px solid #ccc;
			border-bottom: 1px solid #ccc;
			border-right: 1px solid #ccc;
		}

		.fbmainmenu {
			background: #FBFBFB;
			padding: 5px;
		}

		.fbactivemenu {
			background-color: #fff;
			padding: 5px;
		}

		.fbsubmenu {
			background-color: #fff;
			padding: 5px 5px 5px 25px;
		}

		.fbright {
			border: 1px solid #ccc;
			background: #fff;
			padding: 5px;
		}

		.fbfooter {
			font-size: 10px;
			padding: 5px;
			background: #FBFBFB;
			border: 1px solid #CCC;
			text-align: center;
		}

		.fbfunctitle {
			font-size: 16px;
			text-align: left;
			padding: 5px;
			background: #FBFBFB;
			border: 1px solid #CCC;
			font-weight: bold;
			margin-bottom: 10px;
			clear: both;
		}

		.fbfuncsubtitle {
			font-size: 14px;
			text-align: left;
			padding: 5px;
			border-bottom: 3px solid #7F9DB9;
			font-weight: bold;
			color: #7F9DB9;
			margin: 10px 0 10px 0;
		}

		.fbrow0 td {
			padding: 8px 5px;
			text-align: left;
			border-bottom: 1px dotted #ccc;
		}

		.fbrow1 td {
			padding: 8px 5px;
			text-align: left;
			border-bottom: 1px dotted #ccc;
		}

		td.fbtdtitle {
			font-weight: bold;
			padding-left: 10px;
			color: #666;
		}

		#fbcongifcover fieldset {
			border: 1px solid #CFDCEB;
		}

		#fbcongifcover fieldset legend {
			color: #666;
		}

			/*facebox*/
		#facebox .b {
			background: url(<?php echo JPATH_SITE; ?>/components/com_fireboard/template/default/images/b.png);
		}

		#facebox .tl {
			background: url(<?php echo JPATH_SITE;?>/components/com_fireboard/template/default/images/tl.png);
		}

		#facebox .tr {
			background: url(<?php echo JPATH_SITE;?>/components/com_fireboard/template/default/images/tr.png);
		}

		#facebox .bl {
			background: url(<?php echo JPATH_SITE;?>/components/com_fireboard/template/default/images/bl.png);
		}

		#facebox .br {
			background: url(<?php echo JPATH_SITE; ?>/components/com_fireboard/template/default/images/br.png);
		}

		#facebox {
			position: absolute;
			width: 100%;
			top: 0;
			left: 0;
			z-index: 100;
			text-align: left;
		}

		#facebox .popup {
			position: relative;
		}

		#facebox table {
			margin: auto;
			border-collapse: collapse;
		}

		#facebox .body {
			padding: 10px;
			background: #fff;
			width: 370px;
		}

		#facebox .loading {
			text-align: center;
		}

		#facebox .image {
			text-align: center;
		}

		#facebox img {
			border: 0;
		}

		#facebox .footer {
			border-top: 1px solid #DDDDDD;
			padding-top: 5px;
			margin-top: 10px;
			text-align: right;
		}

		#facebox .tl, #facebox .tr, #facebox .bl, #facebox .br {
			height: 10px;
			width: 10px;
			overflow: hidden;
			padding: 0;
		}
	</style>
	<script type="text/javascript"
			src="<?php echo JPATH_SITE; ?>/components/com_fireboard/template/default/js/jquery-latest.pack.js"></script>
	<script type="text/javascript"
			src="<?php echo JPATH_SITE; ?>/components/com_fireboard/facebox/facebox.js"></script>
	<script type="text/javascript"
			src="<?php echo JPATH_SITE; ?>/components/com_fireboard/template/default/js/ipe.js"></script>
	<script>
		var $j = jQuery.noConflict();
		$j(document).ready(function () {
			$j("#toggler_left").click(function () {
				$j(".togg1").slideToggle("slow");
			});
			$j("#toggler_stat").click(function () {
				$j(".fbstatscover").slideToggle("slow");
			});
			$j(".fbstatscover").hide();
///////////////////////////////////////////////////
			$j("#exp_all").click(function () {
				$j(".togg_basic").show();
				$j(".togg_frontend").show();
				$j(".togg_myuser").show();
				$j(".togg_max").show();
				$j(".togg_security").show();
				$j(".togg_avatars").show();
				$j(".togg_uploads").show();
				$j(".togg_files").show();
				$j(".togg_ranking").show();
				$j(".togg_integration").show();
				$j(".togg_plugins").show();
				$j(".togg_resent").show();
				$j(".togg_stats").show();
			});
			$j("#hide_all").click(function () {
				$j(".togg_basic").hide();
				$j(".togg_frontend").hide();
				$j(".togg_myuser").hide();
				$j(".togg_max").hide();
				$j(".togg_security").hide();
				$j(".togg_avatars").hide();
				$j(".togg_uploads").hide();
				$j(".togg_files").hide();
				$j(".togg_ranking").hide();
				$j(".togg_integration").hide();
				$j(".togg_plugins").hide();
				$j(".togg_resent").hide();
				$j(".togg_stats").hide();
			});

			$j("#basics").click(function () {
				$j(".togg_basic").slideToggle("slow");
			});
			$j(".togg_basic").hide();

			$j("#frontend").click(function () {
				$j(".togg_frontend").slideToggle("slow");
			});
			$j(".togg_frontend").hide();

			$j("#myuser").click(function () {
				$j(".togg_myuser").slideToggle("slow");
			});
			$j(".togg_myuser").hide();

			$j("#max").click(function () {
				$j(".togg_max").slideToggle("slow");
			});
			$j(".togg_max").hide();

			$j("#security").click(function () {
				$j(".togg_security").slideToggle("slow");
			});
			$j(".togg_security").hide();

			$j("#avatars").click(function () {
				$j(".togg_avatars").slideToggle("slow");
			});
			$j(".togg_avatars").hide();

			$j("#uploads").click(function () {
				$j(".togg_uploads").slideToggle("slow");
			});
			$j(".togg_uploads").hide();

			$j("#files").click(function () {
				$j(".togg_files").slideToggle("slow");
			});
			$j(".togg_files").hide();

			$j("#ranking").click(function () {
				$j(".togg_ranking").slideToggle("slow");
			});
			$j(".togg_ranking").hide();

			$j("#integration").click(function () {
				$j(".togg_integration").slideToggle("slow");
			});
			$j(".togg_integration").hide();

			$j("#plugins").click(function () {
				$j(".togg_plugins").slideToggle("slow");
			});
			$j(".togg_plugins").hide();

			$j("#resent").click(function () {
				$j(".togg_resent").slideToggle("slow");
			});
			$j(".togg_resent").hide();

			$j("#stats").click(function () {
				$j(".togg_stats").slideToggle("slow");
			});
			$j(".togg_stats").hide();
			////////////////////////////////////////
			$j('a[rel*=facebox]').facebox();
		});
	</script>
<div id="fbadmin">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr>
    	<td width="170" valign="top">
			<!-- Begin: AdminLeft -->
			<div id="fbheader">
				<form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
					<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="100%" align="center" style="border-left:1px solid #DDDDDD;border-right:1px solid #DDDDDD;border-top:1px solid #DDDDDD;">
							<br/>
							<img
								src="<?php echo JPATH_SITE; ?>/administrator/components/com_fireboard/images/logowm.gif"
								alt="<?php echo _AFB_DONATE;?>" title="<?php echo _AFB_DONATE;?>"/>
							<br/>
							<strong><?php echo _AFB_DONATE;?></strong>
						</td>
					</tr>
					<tr>
						<td width="100%" align="center" style="border-left:1px solid #DDDDDD;border-right:1px solid #DDDDDD;">
							<input name="LMI_PAYMENT_AMOUNT" type="text" size="3" value="10">
							<input type="hidden" name="LMI_PAYMENT_DESC" value="Благодарность Автору">
							<input type="hidden" name="LMI_PAYMENT_NO" value="1">
							<input type="hidden" name="LMI_SIM_MODE" value="0">
							<input type="hidden" name="LMI_SUCCESS_URL" value="http://adeptsite.info/">
							<input type="hidden" name="LMI_SUCCESS_METHOD" value="2">
							<input type="hidden" name="LMI_FAIL_URL" value="http://adeptsite.info/">
							<input type="hidden" name="LMI_FAIL_METHOD" value="2">
							<select name="LMI_PAYEE_PURSE" style="min-width:30px;">
								<option value="Z336955269328">WMZ</option>
								<option value="E103233136042">WME</option>
								<option value="R270500581273">WMR</option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="100%" align="center"
							style="border-left:1px solid #DDDDDD;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;">
							<br>
							<input type="submit" class="button" value="<?php echo _GEN_CONTINUE;?>"><br/><br/>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<!-- Begin : Fireboard Left Menu -->
		<div id="fbmenu" class="togg1">
			<?php $stask = mosGetParam($_REQUEST, "task", null);    ?>
			<a class="fbmainmenu" href="index2.php?option=com_fireboard"><?php echo _FB_CP; ?></a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&task=showconfig"><?php echo _COM_C_FBCONFIG; ?></a>
			<?php if($stask == 'showconfig'){
			; ?>
			<!--<a class="fbsubmenu" href = "#basics"><?php echo _COM_A_BASICS; ?></a>
                <a class="fbsubmenu" href = "#frontend"><?php echo _COM_A_FRONTEND; ?></a>
                <a class="fbsubmenu" href = "#security"><?php echo _COM_A_SECURITY; ?></a>
                <a class="fbsubmenu" href = "#avatars"><?php echo _COM_A_AVATARS; ?></a>
                <a class="fbsubmenu" href = "#uploads"><?php echo _COM_A_UPLOADS; ?></a>
                <a class="fbsubmenu" href = "#ranking"><?php echo _COM_A_RANKING; ?></a>
                <a class="fbsubmenu" href = "#integration"><?php echo _COM_A_INTEGRATION; ?></a>
                <a class="fbsubmenu" href = "#plugins"><?php echo _FB_ADMIN_CONFIG_PLUGINS; ?></a>-->
			<?php } ?>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&task=showAdministration"><?php echo _COM_C_FORUM; ?></a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&task=showprofiles"><?php echo _COM_C_USER; ?></a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&task=browseFiles"><?php echo _COM_C_FILES; ?> </a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&task=browseImages"><?php echo _COM_C_IMAGES; ?></a>
			<a class="fbmainmenu" href="index2.php?option=com_fireboard&task=showCss"><?php echo _COM_C_CSS; ?></a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&task=pruneforum"><?php echo _COM_C_PRUNETAB; ?></a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&task=syncusers"><?php echo _FB_SYNC_USERS; ?></a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&task=showsmilies"><?php echo _FB_EMOTICONS_EDIT_SMILIES;?></a>
			<a class="fbmainmenu" href="index2.php?option=com_fireboard&task=ranks"><?php echo _FB_RANKS_MANAGE; ?></a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&task=groups"><?php echo _AFB_GROUPS_MANAGE; ?></a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&amp;task=recount"><?php echo _FB_RECOUNTFORUMS; ?></a>
			<a class="fbmainmenu"
			   href="index2.php?option=com_fireboard&amp;task=loadSample"><?php echo _COM_C_LOADSAMPLE; ?></a>
			<a class="fbmainmenu" href="index2.php?option=com_fireboard&amp;task=removeSample"
			   onclick="return confirm('<?php echo _FB_CONFIRM_REMOVESAMPLEDATA?>');"><?php echo _COM_C_REMOVESAMPLE; ?></a>
		</div>
		<!-- Finish : Fireboard Left Menu -->
	</td>
    <td valign="top" class="fbright">
    <!-- Begin: AdminRight -->
		<?php
	}

	function showFbFooter(){
		?>
		<!-- Finish: AdminRight -->
    </td>
  </tr>
  <tr>
	  <td></td>
	  <td>
	  </td>
  </tr>
</table>
</div><!-- Close div.fbadmin -->
	<!-- Footer -->
	<div class="fbfooter">
		&copy; Форм <a href="http://www.bestofjoomla.com" target="_blank">Fireboard</a> |
		<strong><?php echo _AFB_RE;?><a href="http://adeptsite.info" target="_blank" title="<?php echo _AFB_SITE;?>">Adeptus</a></strong>&nbsp;ver.2.0
	</div>
	<!-- /Footer -->
	<?php
	}

	function controlPanel(){
		$mainframe = mosMainFrame::getInstance();
		?>
	<div class="fbfunctitle" style="vertical-align:middle;">
		<img src="<?php echo JPATH_SITE;?>/administrator/components/com_fireboard/images/logo_smallest.gif"
			 alt="" title=""/>
		<?php echo _FB_CP; ?>
		<span style="font-size:11px; font-weight:normal;">
			<a id="toggler_left" title="<?php echo _AFB_TOGG_LEFT;?>" style="cursor:pointer;">
				<?php echo _AFB_TOGGLER;?>
			</a>
			&nbsp;
			<a id="toggler_stat" title="<?php echo _AFB_TOGG_STAT;?>" style="cursor:pointer;">
				<?php echo _AFB_TOGGLER1;?>
			</a>
			</span>
	</div>
	<?php
		$path = JPATH_BASE . "/administrator/components/com_fireboard/fb_cpanel.php";
		if(file_exists($path)){
			require $path;
		} else{
			echo '<br />mcap==: ' . $mainframe->getCfg('absolute_path') . ' .... help!!';
			mosLoadAdminModules('cpanel', 1);
		}
	}

	function showAdministration($rows, $pageNav, $option){
		?>
	<div class="fbfunctitle">
		<?php echo _FB_ADMIN; ?>
	</div>
	<form action="index2.php" method="post" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>
				<td align="right">
					<?php echo _COM_A_DISPLAY; ?><?php echo $pageNav->writeLimitBox(); ?>
				</td>
			</tr>
		</table>

		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
			<tr>
				<th width="20">
					#
				</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);"/>
				</th>
				<th class="title">
					<?php echo _FB_CATFOR; ?>
				</th>
				<th>
					<small><?php echo _FB_LOCKED; ?></small>
				</th>
				<th>
					<small><?php echo _FB_MODERATED; ?></small>
				</th>
				<th>
					<small><?php echo _FB_REVIEW; ?></small>
				</th>

				<th>
					<small><?php echo _FB_PUBLISHED; ?></small>
				</th>
				<th>
					<small><?php echo _FB_PUBLICACCESS; ?></small>
				</th>
				<th>
					<small><?php echo _AFB_PRIVATE; ?></small>
				</th>
				<th>
					<small><?php echo _FB_CHECKEDOUT; ?></small>
				</th>
				<th colspan="2">
					<small><?php echo _FB_REORDER; ?></small>
				</th>
			</tr>
			<?php
			$k = 0;
			for($i = 0, $n = count($rows); $i < $n; $i++){
				$row = $rows[$i];
				if($row->parent == 0){
					?>
                        <tr bgcolor="#D4D4D4">
                <?php
				} else{
					?>
                        <tr class="row<?php echo $k; ?>">
                <?php
				}
				?>
				<td width="20" align="right"><?php echo $i + $pageNav->limitstart + 1; ?>
				</td>
				<td width="20">
					<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>"
						   onClick="isChecked(this.checked);">
				</td>

				<td width="70%">
					<a href="#edit" onclick="return listItemTask('cb<?php echo $i; ?>','edit')">
						<?php
						echo ($row->treename);
						?>
					</a>
				</td>
				<td align="center">
					<?php
					echo (!$row->category ? "&nbsp;" : ($row->locked == 1 ? "<img src=\"images/tick.png\">" : "<img src=\"images/publish_x.png\">"));
					?>
				</td>
				<td align="center"><?php echo ($row->moderated == 1 ? "<img src=\"images/tick.png\">" : "<img src=\"images/publish_x.png\">"); ?>
				</td>
				<td align="center">
					<?php
					echo (!$row->category ? "&nbsp;" : ($row->review == 1 ? "<img src=\"images/tick.png\">" : "<img src=\"images/publish_x.png\">"));
					?>
				</td>
				<?php
				$task = $row->published ? 'unpublish' : 'publish';
				$img = $row->published ? 'publish_g.png' : 'publish_x.png';
				if($row->pub_access == 0){
					$groupname = _FB_EVERYBODY;
				} else if($row->pub_access == -1){
					$groupname = _FB_ALLREGISTERED;
				} else{
					$groupname = $row->groupname == "" ? "&nbsp;" : $row->groupname;
				}
				//$adm_groupname = $row->admingroup == "" ? "&nbsp;" : $row->admingroup;
				?>
				<td width="10%" align="center">
					<a href="javascript: void(0);"
					   onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt=""/></a>
				</td>
				<td width="" align="center"><?php echo $groupname; ?>
				</td>
				<td width=""
					align="center"><?php echo ($row->admin_recurse > 1 ? "<img src=\"images/tick.png\">" : "<img src=\"images/publish_x.png\">");?>
				</td>
				<td width="15%" align="center">
					<?php echo $row->editor; ?>&nbsp;
				</td>
				<td>
					<?php
					if($i > 0 || ($i + $pageNav->limitstart > 0)){
						?>
						<a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderup')"> <img
							src="images/uparrow.png" width="12" height="12" border="0" alt="<?php echo _FB_MOVEUP; ?>">
						</a>
						<?php
					}
					?>
				</td>
				<td>
					<?php
					if($i < $n - 1 || $i + $pageNav->limitstart < $pageNav->total - 1){
						?>
						<a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdown')"> <img
							src="images/downarrow.png" width="12" height="12" border="0"
							alt="<?php echo _FB_MOVEDOWN; ?>"> </a>
						<?php
					}
					?>
				</td>
				<?php
				$k = 1 - $k;
			}
			?>
		</tr>
			<tr>
				<th align="center" colspan="12"> <?php echo $pageNav->writePagesLinks(); ?>
				</th>
			</tr>
			<tr>
				<td align="center" colspan="12"> <?php echo $pageNav->writePagesCounter(); ?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="task" value="showAdministration">
		<input type="hidden" name="boxchecked" value="0">
	</form>
	<?php
	}

	function editForum(&$row, $categoryList, $moderatorList, $lists, $accessLists, $option){
		$tabs = new mosTabs(3);
		?>
	<style>
		.hideable {
			position: relative;
			visibility: hidden;
		}
	</style>
	<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform(pressbutton);
				return;
			}
			try {
				document.adminForm.onsubmit();
			}
			catch (e) {
			}
			if (form.name.value == "") {
				alert("<?php echo _FB_ERROR1; ?>");
			}
			else {
				submitform(pressbutton);
			}
		}
	</script>
	<div class="fbfunctitle"><?php echo $row->id ? _FB_EDIT : _FB_ADD; ?> <?php echo _FB_CATFOR; ?></div>
	<form action="index2.php" method="POST" name="adminForm">
		<div class="fbfuncsubtitle"><?php echo _FB_BASICSFORUM; ?></div>
		<fieldset>
			<legend> <?php echo _FB_BASICSFORUMINFO; ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%">
				<tr>
					<td width="200" valign="top"><?php echo _FB_PARENT; ?>
					</td>
					<td>
						<?php echo $categoryList; ?><br/>
						<br/><?php echo _FB_PARENTDESC; ?>
					</td>
				</tr>
				<tr>
					<td width="200"><?php echo _FB_NAMEADD; ?>
					</td>
					<td>
						<input class="inputbox" type="text" name="name" size="25" maxlength="100"
							   value="<?php echo $row->name; ?>">
					</td>
				</tr>
				<tr>
					<td valign="top"><?php echo _FB_DESCRIPTIONADD; ?>
					</td>
					<td>
						<textarea class="inputbox" cols="50" rows="3" name="description" id="description"
								  style="width:500px"><?php echo $row->description; ?></textarea>
					</td>
				</tr>
				<tr>
					<td valign="top"><?php echo _FB_HEADERADD; ?>
					</td>
					<td>
						<textarea class="inputbox" cols="50" rows="3" name="headerdesc" id="headerdesc"
								  style="width:500px"><?php echo $row->headerdesc; ?></textarea>
					</td>
				</tr>
			</table>
		</fieldset>
		<div class="fbfuncsubtitle"><?php echo _FB_ADVANCEDDESC; ?></div>
		<fieldset>
			<legend> <?php echo _FB_ADVANCEDDESCINFO; ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%">
				<tr>
					<td><?php echo _FB_LOCKED1; ?>
					</td>
					<td> <?php echo $lists['forumLocked']; ?>
					</td>
					<td>
						<?php echo _FB_LOCKEDDESC; ?>
					</td>
				</tr>
				<tr>
					<td nowrap="nowrap" valign="top"><?php echo _FB_PUBACC; ?>
					</td>
					<td valign="top"> <?php echo $accessLists['pub_access']; ?>
					</td>
					<td><?php echo _FB_PUBACCDESC; ?>
					</td>
				</tr>
				<!--<tr>
                    <td nowrap = "nowrap" valign = "top"><?php echo _FB_CGROUPS; ?>
                    </td>
                    <td valign = "top"> <?php echo $lists['pub_recurse']; ?>
                    </td>
                    <td valign = "top"><?php echo _FB_CGROUPSDESC; ?>
                    </td>
                </tr>
                <tr>
                    <td valign = "top"><?php echo _FB_ADMINLEVEL; ?>
                    </td>
                    <td valign = "top"> <?php echo $accessLists['admin_access']; ?>
                    </td>
                    <td valign = "top"><?php echo _FB_ADMINLEVELDESC; ?>
                    </td>
                </tr>-->
				<tr>
					<td nowrap="nowrap" valign="top"><?php echo _AFB_PRIVATE; ?>
					</td>
					<td valign="top"> <?php echo $lists['admin_recurse']; ?>
					</td>
					<td valign="top"><?php echo _FB_CGROUPS1DESC; ?>
					</td>
				</tr>
				<tr>
					<td nowrap="nowrap" valign="top"><?php echo _FB_REV; ?>
					</td>
					<td valign="top"> <?php echo $lists['forumReview']; ?>
					</td>
					<td valign="top"><?php echo _FB_REVDESC; ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<!--<fieldset>
           <legend> <?php echo _FB_ADVANCEDDISPINFO; ?></legend>
            <table cellpadding = "4" cellspacing = "0" border = "0" width = "100%">
                <tr>
                    <td><?php echo _FB_CLASS_SFX; ?>
                    </td>
                    <td>
                        <input class = "inputbox" type = "text" name = "class_sfx" size = "20" maxlength = "20" value = "<?php echo $row->class_sfx; ?>">
                    </td>
                    <td>
						<?php echo _FB_CLASS_SFXDESC; ?>
                    </td>
                </tr>
            </table>
           </fieldset>-->
		<div class="fbfuncsubtitle"><?php echo _FB_MODNEWDESC; ?></div>
		<fieldset>
			<legend> <?php echo _FB_MODHEADER; ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%">
				<tr>
					<td nowrap="nowrap" valign="top"><?php echo _FB_MOD; ?>
					</td>
					<td valign="top"> <?php echo $lists['forumModerated']; ?>
					</td>
					<td valign="top"><?php echo _FB_MODDESC; ?>
					</td>
				</tr>
			</table>
			<?php
			if($row->moderated){
				?>
				<div class="fbfuncsubtitle"><?php echo _FB_MODSASSIGNED; ?></div>
				<table class="adminlist" border="0" cellspacing="0" cellpadding="3" width="100%">
					<tr>
						<th width="20">#</th>
						<th width="20">
							<input type="checkbox" name="toggle" value=""
								   onclick="checkAll(<?php echo count($moderatorList); ?>);"/>
						</th>
						<th><?php echo _USRL_NAME; ?></th>
						<th><?php echo _USRL_USERNAME; ?></th>
						<th><?php echo _USRL_EMAIL; ?></th>
						<th><?php echo _FB_PUBLISHED; ?></th>
					</tr>
					<?php
					if(count($moderatorList) == 0){
						echo "<tr><td colspan=\"5\">" . _FB_NOMODS . "</td></tr>";
					} else{
						$k = 1;
						$i = 0;
						foreach($moderatorList as $ml){
							$k = 1 - $k;
							?>
							<tr class="row<?php echo $k;?>">
								<td width="20"><?php echo $i + 1; ?>
								</td>
								<td width="20">
									<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]"
										   value="<?php echo $ml->id; ?>" onClick="isChecked(this.checked);">
								</td>
								<td><?php echo $ml->name; ?>
								</td>
								<td><?php echo $ml->username; ?>
								</td>
								<td><?php echo $ml->email; ?>
								</td>
								<td align="center">
									<img src="images/tick.png">
								</td>
							</tr>
							<?php
							$i++;
						}
					}
					?>
				</table>
				<?php
			}
			?>
		</fieldset>
		<input type="hidden" name="id" value="<?php echo $row->id; ?>"> <input type="hidden" name="option"
																			   value="<?php echo $option; ?>"> <input
		type="hidden" name="task" value="showAdministration">
		<?php
		if($row->ordering != 0){
			echo '<input type="hidden" name="ordering" value="' . $row->ordering . '">';
		}
		?>
	</form>
	<?php
	}

	function showConfig(&$fbConfig, &$lists, $option){
		$tabs = new mosTabs(2);
		?>
	<div id="fbcongifcover">
	<div class="fbfunctitle">
		<?php echo _COM_A_CONFIG ?>
		<span style="font-size:11px; font-weight:normal;">
				<a name="exp_all" id="exp_all" style="cursor:pointer;"><?php echo _AFB_EXP;?></a>
				&nbsp;
				<a name="hide_all" id="hide_all" style="cursor:pointer;"><?php echo _AFB_COLL;?></a>
				&nbsp;
				<a id="toggler_left" title="<?php echo _AFB_TOGG_LEFT;?>" style="cursor:pointer;">
					<?php echo _AFB_TOGGLER;?>
				</a>
			</span>
	</div>
	<form action="index2.php" method="post" name="adminForm">
	<a name="basics" id="basics" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _COM_A_BASICS ?>
	</a>

	<div class="togg_basic">
		<fieldset>
			<legend><?php echo _COM_A_BASIC_SETTINGS ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_BOARD_TITLE ?>
					</td>
					<td align="left" valign="top" width="25%">
						<input type="text" name="cfg_board_title" value="<?php echo $fbConfig['board_title']; ?>"/>
						<input type="hidden" name="cfg_re" value="0"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_BOARD_TITLE_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_EMAIL ?>
					</td>

					<td align="left" valign="top">
						<input type="text" name="cfg_email" value="<?php echo $fbConfig['email']; ?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_EMAIL_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_BOARD_OFFLINE ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['board_offline']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_BOARD_OFFLINE_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_BOARD_OFSET ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_board_ofset" value="<?php echo $fbConfig['board_ofset']; ?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_BOARD_OFSET_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_BOARD_OFFLINE_MES ?>
					</td>
					<td align="left" valign="top" colspan="2">
						<textarea name="cfg_offline_message" rows="3"
								  cols="50"><?php echo $fbConfig['offline_message']; ?></textarea>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_VIEW_TYPE ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['default_view']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_VIEW_TYPE_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_RSS ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['enableRSS']; ?>
					</td>
					<td align="left" valign="top">
						<img
							src="<?php echo JPATH_SITE;?>/images/M_images/rss.png"/> <?php echo _COM_A_RSS_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_PDF ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['enablePDF']; ?>
					</td>
					<td align="left" valign="top">
						<img
							src="<?php echo JPATH_SITE;?>/images/M_images/pdf_button.png"/> <?php echo _COM_A_PDF_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_ALLOWCHAT;?>
					</td>
					<td align="left" valign="top"><?php echo $lists['chat']; ?>
					</td>
					<td align="left" valign="top">
						<?php echo _FB_ALLOWCHAT_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_ALLOWCHAT_GUEST;?>
					</td>
					<td align="left" valign="top"><?php echo $lists['chat_guests']; ?>
					</td>
					<td align="left" valign="top">
						<?php echo _FB_ALLOWCHAT_GUEST_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_ALLOWPOLLS;?>
					</td>
					<td align="left" valign="top"><?php echo $lists['polls']; ?>
					</td>
					<td align="left" valign="top">
						<?php echo _FB_ALLOWPOLLS_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _AFB_POLL_MAX;?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_pollmax" value="<?php echo $fbConfig['pollmax']; ?>"/>
					</td>
					<td align="left" valign="top"><?php echo _AFB_POLL_MAX_DESC;?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>

	<a name="frontend" id="frontend" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _COM_A_FRONTEND ?>
	</a>

	<div class="togg_frontend">
	<fieldset>
	<legend> <?php echo _COM_A_LOOKS ?></legend>
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
	<tr align="center" valign="middle">
		<td align="left" valign="top" width="25%"><?php echo _COM_A_THREADS ?>
		</td>
		<td align="left" valign="top" width="25%">
			<input type="text" name="cfg_threads_per_page" value="<?php echo $fbConfig['threads_per_page']; ?>"/>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_THREADS_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_MESSAGES ?>
		</td>
		<td align="left" valign="top">
			<input type="text" name="cfg_messages_per_page" value="<?php echo $fbConfig['messages_per_page']; ?>"/>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_MESSAGES_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_MESSAGES_SEARCH ?>
		</td>
		<td align="left" valign="top">
			<input type="text" name="cfg_messages_per_page_search"
				   value="<?php echo $fbConfig['messages_per_page_search']; ?>"/>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_MESSAGES_DESC_SEARCH ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_HISTORY ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['showHistory']; ?>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_HISTORY_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_HISTLIM ?>
		</td>
		<td align="left" valign="top">
			<input type="text" name="cfg_historyLimit" value="<?php echo $fbConfig['historyLimit'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_HISTLIM_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_SHOWNEW ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['showNew']; ?>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_SHOWNEW_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_NEWCHAR ?>
		</td>
		<td align="left" valign="top">
			<input type="text" name="cfg_newChar" value="<?php echo $fbConfig['newChar'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_NEWCHAR_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_MAMBOT_SUPPORT ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['jmambot']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_MAMBOT_SUPPORT_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_DISEMOTICONS ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['disemoticons']; ?>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_DISEMOTICONS_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_TEMPLATE ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['template']; ?>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_TEMPLATE_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_TEMPLATE_IMAGE_PATH ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['templateimagepath']; ?>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_TEMPLATE_IMAGE_PATH_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_USE_JOOMLA_STYLE ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['joomlaStyle']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_USE_JOOMLA_STYLE_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_SHOW_ANNOUNCEMENT ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['showAnnouncement']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_SHOW_ANNOUNCEMENT_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_SHOW_AVATAR_ON_CAT ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['avatarOnCat']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_SHOW_AVATAR_ON_CAT_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_CATIMAGEPATH ?>
		</td>
		<td align="left" valign="top">
			<input type="text" name="cfg_CatImagePath" value="<?php echo $fbConfig['CatImagePath'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _FB_CATIMAGEPATH_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_SHOW_CHILD_CATEGORY_COLON ?>
		</td>
		<td align="left" valign="top">
			<input type="text" name="cfg_numchildcolumn" value="<?php echo $fbConfig['numchildcolumn'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _FB_SHOW_CHILD_CATEGORY_COLONDESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_SHOW_CHILD_CATEGORY_ON_LIST ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['showChildCatIcon']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_SHOW_CHILD_CATEGORY_ON_LIST_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_ANN_MODID ?>
		</td>
		<td align="left" valign="top">
			<input type="text" name="cfg_AnnModId" value="<?php echo $fbConfig['AnnModId'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _FB_ANN_MODID_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_TAWIDTH ?>
		</td>
		<td align="left" valign="top">
			<input type="text" name="cfg_rtewidth" value="<?php echo $fbConfig['rtewidth'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_TAWIDTH_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_TAHEIGHT ?>
		</td>
		<td align="left" valign="top">
			<input type="text" name="cfg_rteheight" value="<?php echo $fbConfig['rteheight'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_TAHEIGHT_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_RULESPAGE ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['enableRulesPage']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_RULESPAGE_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_RULESPAGE_IN_FB ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['rules_infb']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_RULESPAGE_IN_FB_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_RULESPAGE_CID ?>
		</td>
		<td align="left" valign="top"><input type="text" name="cfg_rules_cid"
											 value="<?php echo $fbConfig['rules_cid'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _FB_RULESPAGE_CID_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_RULESPAGE_LINK ?>
		</td>
		<td align="left" valign="top"><input type="text" name="cfg_rules_link"
											 value="<?php echo $fbConfig['rules_link'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _FB_RULESPAGE_LINK_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_HELPPAGE ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['enableHelpPage']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_HELPPAGE_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_HELPPAGE_IN_FB ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['help_infb']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_HELPPAGE_IN_FB_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_HELPPAGE_CID ?>
		</td>
		<td align="left" valign="top"><input type="text" name="cfg_help_cid"
											 value="<?php echo $fbConfig['help_cid'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _FB_HELPPAGE_CID_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_HELPPAGE_LINK ?>
		</td>
		<td align="left" valign="top"><input type="text" name="cfg_help_link"
											 value="<?php echo $fbConfig['help_link'];?>"/>
		</td>
		<td align="left" valign="top"><?php echo _FB_HELPPAGE_LINK_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _COM_A_FORUM_JUMP ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['enableForumJump']; ?>
		</td>
		<td align="left" valign="top"><?php echo _COM_A_FORUM_JUMP_DESC ?>
		</td>
	</tr>
	<tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _FB_COM_A_REPORT ?>
		</td>
		<td align="left" valign="top"><?php echo $lists['reportmsg']; ?>
		</td>
		<td align="left" valign="top"><?php echo _FB_COM_A_REPORT_DESC ?>
		</td>
	</tr>
	</table>
	</fieldset>
	</div>
	<a name="myuser" id="myuser" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _AFB_MYUSER; ?>
	</a>

	<div class="togg_myuser">
		<fieldset>
			<legend> <?php echo _COM_A_USERS ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_USERNAME ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['username']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_USERNAME_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_ASK_EMAIL ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['askemail']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_ASK_EMAIL_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_SHOWMAIL ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['showemail']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_SHOWMAIL_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_USERSTATS ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['showstats']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_USERSTATS_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_POSTSTATSBAR ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['postStats']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_POSTSTATSBAR_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_POSTSTATSCOLOR ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_statsColor" value="<?php echo $fbConfig['statsColor'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_POSTSTATSCOLOR_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td colspan=2>&nbsp;
					</td>
					<td align="left" valign="top">
						<table width="100%">
							<tr>
								<td>
									1: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col1m.png"
									width="15" height="4">
								</td>
								<td>
									2: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col2m.png"
									width="15" height="4">
								</td>
								<td>
									3: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col3m.png"
									width="15" height="4">
								</td>
								<td>
									4: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col4m.png"
									width="15" height="4">
								</td>
								<td>
									5: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col5m.png"
									width="15" height="4">
								</td>
								<td>
									6: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col6m.png"
									width="15" height="4">
								</td>
							</tr>
							<tr>
								<td>
									7: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col7m.png"
									width="15" height="4">
								</td>
								<td>
									8: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col8m.png"
									width="15" height="4">
								</td>
								<td>
									9: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col9m.png"
									width="15" height="4">
								</td>
								<td>
									10: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col10m.png"
									width="15" height="4">
								</td>
								<td>
									11: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col11m.png"
									width="15" height="4">
								</td>
								<td>
									12: <img
									src="<?php echo JPATH_SITE;?>/components/com_fireboard/template/<?php echo $fbConfig['template'];?>/images/english/graph/col12m.png"
									width="15" height="4">
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_KARMA ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['showkarma']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_KARMA_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_USER_EDIT ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['useredit']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_USER_EDIT_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_USER_EDIT_TIME ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_usereditTime" value="<?php echo $fbConfig['usereditTime'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_USER_EDIT_TIME_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_USER_EDIT_TIMEGRACE ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_usereditTimeGrace"
							   value="<?php echo $fbConfig['usereditTimeGrace'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_USER_EDIT_TIMEGRACE_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_USER_MARKUP ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['editMarkUp']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_USER_MARKUP_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_SUBSCRIPTIONS ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['allowsubscriptions']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_SUBSCRIPTIONS_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_SUBSCRIPTIONSCHECKED ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['subscriptionschecked']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_SUBSCRIPTIONSCHECKED_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_FAVORITES ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['allowfavorites']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_FAVORITES_DESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a name="max" id="max" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _AFB_MAX; ?>
	</a>

	<div class="togg_max">
		<fieldset>
			<legend> <?php echo _COM_A_LENGTHS ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_WRAP ?>
					</td>
					<td align="left" valign="top" width="25%">
						<input type="text" name="cfg_wrap" value="<?php echo $fbConfig['wrap'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_WRAP_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_SUBJECTLENGTH ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_maxSubject" value="<?php echo $fbConfig['maxSubject'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_SUBJECTLENGTH_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_SIGNATURE ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_maxSig" value="<?php echo $fbConfig['maxSig'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_SIGNATURE_DESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a name="security" id="security" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _COM_A_SECURITY ?>
	</a>

	<div class="togg_security">
		<fieldset>
			<legend> <?php echo _COM_A_SECURITY_SETTINGS ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_REGISTERED_ONLY ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['regonly']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_REG_ONLY_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_CHANGENAME ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['changename']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_CHANGENAME_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_PUBWRITE ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['pubwrite']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_PUBWRITE_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_FLOOD ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_floodprotection"
							   value="<?php echo $fbConfig['floodprotection'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_FLOOD_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_MODERATION ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['mailmod']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_MODERATION_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_A_MAIL_ADMIN ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['mailadmin']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_A_MAIL_ADMIN_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_CAPTCHA_ON ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['captcha']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_CAPTCHA_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_MAILFULL; ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['mailfull']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_MAILFULL_DESC; ?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a name="avatars" id="avatars" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _COM_A_AVATARS ?>
	</a>

	<div class="togg_avatars">
		<fieldset>
			<legend> <?php echo _COM_A_AVATAR_SETTINGS ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_AVATAR ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['allowAvatar']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_AVATAR_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_AVATARUPLOAD ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['allowAvatarUpload']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_AVATARUPLOAD_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_AVATARGALLERY ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['allowAvatarGallery']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_AVATARGALLERY_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_IMAGE_PROCESSOR ?>
					</td>
					<td align="left" valign="top">
						<?php echo $lists['imageProcessor']; ?>
					</td>
					<td align="left" valign="top"><?php
						$fb_gd = intval(FB_gdVersion());
						if($fb_gd > 0){
							$fbmsg = _FB_GD_INSTALLED . $fb_gd;
						} elseif($gdver == -1){
							$fbmsg = _FB_GD_NO_VERSION;
						} else{
							$fbmsg = _FB_GD_NOT_INSTALLED . '<a href="http://www.php.net/gd" target="_blank">http://www.php.net/gd</a>';
						}
						echo $fbmsg;
						?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_AVATAR_SMALL_HEIGHT ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_avatarSmallHeight"
							   value="<?php echo $fbConfig['avatarSmallHeight'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_AVATAR_SMALL_WIDTH ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_avatarSmallWidth"
							   value="<?php echo $fbConfig['avatarSmallWidth'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_AVATAR_MEDIUM_HEIGHT ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_avatarHeight" value="<?php echo $fbConfig['avatarHeight'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_AVATAR_MEDIUM_WIDTH ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_avatarWidth" value="<?php echo $fbConfig['avatarWidth'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_AVATAR_LARGE_HEIGHT ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_avatarLargeHeight"
							   value="<?php echo $fbConfig['avatarLargeHeight'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_AVATAR_LARGE_WIDTH ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_avatarLargeWidth"
							   value="<?php echo $fbConfig['avatarLargeWidth'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_AVSIZE ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_avatarSize" value="<?php echo $fbConfig['avatarSize'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_AVATAR_QUALITY ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_avatarQuality" value="<?php echo $fbConfig['avatarQuality'];?>"/> %
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a name="uploads" id="uploads" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _COM_A_UPLOADS ?>
	</a>

	<div class="togg_uploads">
		<fieldset>
			<legend> <?php echo _COM_A_IMAGE ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_IMAGEUPLOAD ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['allowImageUpload']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_IMAGEUPLOAD_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_IMAGEREGUPLOAD ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['allowImageRegUpload']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_IMAGEREGUPLOAD_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_IMGHEIGHT ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_imageHeight" value="<?php echo $fbConfig['imageHeight'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_IMGWIDTH ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_imageWidth" value="<?php echo $fbConfig['imageWidth'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_IMGSIZE ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_imageSize" value="<?php echo $fbConfig['imageSize'];?>"/>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a name="files" id="files" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _COM_A_FILE ?>
	</a>

	<div class="togg_files">
		<fieldset>
			<legend> <?php echo _COM_A_FILE ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_FILEUPLOAD;?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['allowFileUpload']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_FILEUPLOAD_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_FILEREGUPLOAD ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['allowFileRegUpload']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_FILEREGUPLOAD_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_FILEALLOWEDTYPES ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_fileTypes" value="<?php echo $fbConfig['fileTypes'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_FILEALLOWEDTYPES_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_FILESIZE ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_fileSize" value="<?php echo $fbConfig['fileSize'];?>"/>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _FB_ATTACH_ON;?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['attach_guests']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_ATTACH_ON_DESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a name="ranking" id="ranking" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _COM_A_RANKING ?>
	</a>

	<div class="togg_ranking">
		<fieldset>
			<legend><?php echo _COM_A_RANKING_SETTINGS ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_RANKING ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['showranking']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_RANKING_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_RANKINGIMAGES ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['rankimages']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_RANKINGIMAGES_DESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a name="integration" id="integration" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _COM_A_INTEGRATION ?>
	</a>

	<div class="togg_integration">
		<fieldset>
			<legend> <?php echo _COM_A_AVATAR_INTEGRATION ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_AVATAR_SRC ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['avatar_src']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_AVATAR_SRC_DESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend> <?php echo _FB_FORUMPRF_TITLE ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _FB_FORUMPRF ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['fb_profile']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_FORUMPRRDESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend> <?php echo _COM_A_PMS_TITLE ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_PMS ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['pm_component']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_PMS_DESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend> <?php echo _COM_A_COMBUILDER_TITLE ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_COMBUILDER ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['cb_profile']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_COMBUILDER_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _COM_A_COMBUILDER_PROFILE ?>
					</td>
					<td align="left" valign="top">
						<a href="index2.php?option=com_fireboard&amp;task=loadCBprofile" style="text-decoration:none;"
						   title="<?php echo _COM_A_COMBUILDER_PROFILE_DESC;?>"><?php echo _COM_A_COMBUILDER_PROFILE_CLICK ?></a>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_COMBUILDER_PROFILE_DESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend> <?php echo _COM_A_BADWORDS_TITLE ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_BADWORDS ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['badwords']; ?>
					</td>
					<td align="left" valign="top"><?php echo _COM_A_BADWORDS_DESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend> <?php echo _COM_A_MOSBOT_TITLE ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _COM_A_MOSBOT ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['discussBot']; ?>
					</td>
					<td align="left" valign="top">
						<?php echo _COM_A_MOSBOT_DESC ?>
						<br/>
						<br/>
						<a href="<?php echo JPATH_SITE;?>/administrator/components/com_fireboard/fireboard_mosbot_help.php"
						   rel="facebox">
							<?php echo _COM_A_BOT_REFERENCE;?>
						</a>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a name="plugins" id="plugins" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _FB_ADMIN_CONFIG_PLUGINS ?>
	</a>

	<div class="togg_plugins">
	<fieldset>
		<legend> <?php echo _AFB_FM_MAIN;?> </legend>
		<?php
		if(file_exists(JPATH_BASE . '/components/com_fireboard/template/default/plugin/lister/lister.php')){
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_FM;?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['fm'];?>
					</td>
					<td align="left" valign="top"><?php echo _AFB_FM_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _AFB_FM_GUESTS;?>
					</td>
					<td align="left" valign="top"><?php echo $lists['fm_guests'];?>
					</td>
					<td align="left" valign="top"><?php echo _AFB_FM_GUESTS_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _AFB_FILEMANAGER_DIR;?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_fileman_dir" value="<?php echo $fbConfig['fileman_dir'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _AFB_FILEMANAGER_DIR_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _AFB_FILEMANAGER_EXT;?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_fileman_ext" value="<?php echo $fbConfig['fileman_ext'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _AFB_FILEMANAGER_EXT_DESC;?>
					</td>
				</tr>
			</table>
			<?php
		} else{
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="100%"><?php echo _AFB_FM_NOTE;?>
					</td>
				</tr>
			</table>
			<?php
		}?>
	</fieldset>
	<fieldset>
		<legend> <?php echo _AFB_GMAP_MAIN;?> </legend>
		<?php
		if(file_exists(JPATH_BASE . '/components/com_fireboard/template/default/plugin/gmap/gmap.php')){
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_GMAP;?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['gmap'];?>
					</td>
					<td align="left" valign="top"><?php echo _AFB_GMAP_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _AFB_GMAP_KEY;?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_gmap_key" value="<?php echo $fbConfig['gmap_key'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _AFB_GMAP_KEY_DESC;?>
					</td>
				</tr>
			</table>
			<?php
		} else{
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="100%"><?php echo _AFB_GMAP_NOTE;?>
					</td>
				</tr>
			</table>
			<?php
		}?>
	</fieldset>
	<fieldset>
		<legend> <?php echo _AFB_NOTE_MAIN;?> </legend>
		<?php
		if(file_exists(JPATH_BASE . '/components/com_fireboard/template/default/plugin/note/note.php')){
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_NOTE;?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['note'];?>
					</td>
					<td align="left" valign="top"><?php echo _AFB_NOTE_DESC;?>
					</td>
				</tr>
			</table>
			<?php
		} else{
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="100%"><?php echo _AFB_NOTE_NOTE;?>
					</td>
				</tr>
			</table>
			<?php
		}?>
	</fieldset>
	<fieldset>
		<legend> <?php echo _AFB_FOTO;?> </legend>
		<?php
		if(file_exists(JPATH_BASE . '/components/com_fireboard/template/default/plugin/foto/foto.php')){
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_FOTO_ENABLE;?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['foto'];?>
					</td>
					<td align="left" valign="top"><?php echo _AFB_FOTO_ENABLE_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_FOTO_MAXFILES;?>
					</td>
					<td align="left" valign="top" width="25%">
						<input type="text" name="cfg_foto_maxfiles" value="<?php echo $fbConfig['foto_maxfiles'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _AFB_FOTO_MAXFILES_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_FOTO_GROUPS;?>
					</td>
					<td align="left" valign="top" width="25%">
						<input type="text" name="cfg_foto_groups" value="<?php echo $fbConfig['foto_groups'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _AFB_FOTO_GROUPS_DESC;?>
					</td>
				</tr>
			</table>
			<?php
		} else{
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="100%"><?php echo _AFB_FOTO_NOTE;?>
					</td>
				</tr>
			</table>
			<?php
		}?>
	</fieldset>
	<fieldset>
		<legend> <?php echo _AFB_PLGPZL;?> </legend>
		<?php
		if(file_exists(JPATH_BASE . '/components/com_fireboard/template/default/plugin/puzzle/puzzle.php')){
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_PUZZ_ENABLE;?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['puzzle'];?>
					</td>
					<td align="left" valign="top"><?php echo _AFB_PUZZ_ENABLE_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_PUZZLE_ROWS;?>
					</td>
					<td align="left" valign="top" width="25%">
						<input type="text" name="cfg_puzzle_rows" value="<?php echo $fbConfig['puzzle_rows'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _AFB_PUZZLE_ROWS_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_PUZZLE_COLS;?>
					</td>
					<td align="left" valign="top" width="25%">
						<input type="text" name="cfg_puzzle_cols" value="<?php echo $fbConfig['puzzle_cols'];?>"/>
					</td>
					<td align="left" valign="top"><?php echo _AFB_PUZZLE_COLS_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_PUZZ_NUMBERS;?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['puzzle_numbers'];?>
					</td>
					<td align="left" valign="top"><?php echo _AFB_PUZZ_NUMBERS_DESC;?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _AFB_PUZZLE_RESET;?>
					</td>
					<td align="left" valign="top" width="25%">
						<a href="index2.php?option=com_fireboard&task=puzzreset"
						   title=""><?php echo _AFB_PUZZ_RESET;?></a>
					</td>
					<td align="left" valign="top"><?php echo _AFB_PUZZLE_RESET_DESC;?>
					</td>
				</tr>
			</table>
			<?php
		} else{
			?>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="100%"><?php echo _AFB_PUZZ_NOTE;?>
					</td>
				</tr>
			</table>
			<?php
		}?>
	</fieldset>
	<fieldset>
		<legend> <?php echo _FB_ADMIN_CONFIG_USERLIST ?></legend>
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
			<tr align="center" valign="middle">
				<td align="left" valign="top" width="25%"><?php echo _FB_ADMIN_CONFIG_USERLIST_ROWS ?>
				</td>
				<td align="left" valign="top" width="25%">
					<input type="text" name="cfg_userlist_rows" value="<?php echo $fbConfig['userlist_rows'];?>"/>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_ROWS_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_USERONLINE ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_online']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_USERONLINE_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_AVATAR ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_avatar']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_USERLIST_AVATAR_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_NAME ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_name']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_name_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_USERNAME ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_username']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_USERNAME_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_GROUP ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_group']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_GROUP_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_POSTS ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_posts']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_POSTS_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_KARMA ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_karma']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_KARMA_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_EMAIL ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_email']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_EMAIL_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_USERTYPE ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_usertype']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_USERTYPE_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_JOINDATE ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_joindate']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_JOINDATE_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_LASTVISITDATE ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_lastvisitdate']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_LASTVISITDATE_DESC ?>
				</td>
			</tr>
			<tr align="center" valign="middle">
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_HITS ?>
				</td>
				<td align="left" valign="top"><?php echo $lists['userlist_userhits']; ?>
				</td>
				<td align="left" valign="top"><?php echo _FB_ADMIN_CONFIG_USERLIST_HITS_DESC ?>
				</td>
			</tr>
		</table>
	</fieldset>
	</div>
	<a name="resent" id="resent" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _FB_RECENT_POSTS ?>
	</a>

	<div class="togg_resent">
		<fieldset>
			<legend> <?php echo _FB_RECENT_POSTS ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _FB_SHOW_LATEST_MESSAGES ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['showLatest']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_SHOW_LATEST_MESSAGES_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_NUMBER_OF_LATEST_MESSAGES ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_latestCount" value="<?php echo $fbConfig['latestCount']; ?>"/>
					</td>
					<td align="left" valign="top"><?php echo _FB_NUMBER_OF_LATEST_MESSAGES_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_COUNT_PER_PAGE_LATEST_MESSAGES ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_latestCountPerPage"
							   value="<?php echo $fbConfig['latestCountPerPage']; ?>"/>
					</td>
					<td align="left" valign="top"><?php echo _FB_COUNT_PER_PAGE_LATEST_MESSAGES_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_LATEST_CATEGORY ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_latestCategory"
							   value="<?php echo $fbConfig['latestCategory']; ?>"/>
					</td>
					<td align="left" valign="top"><?php echo _FB_LATEST_CATEGORY_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_SHOW_LATEST_SINGLE_SUBJECT ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['latestSingleSubject']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_SHOW_LATEST_SINGLE_SUBJECT_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_SHOW_LATEST_REPLY_SUBJECT ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['latestReplySubject']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_SHOW_LATEST_REPLY_SUBJECT_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_LATEST_SUBJECT_LENGTH ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_latestSubjectLength"
							   value="<?php echo $fbConfig['latestSubjectLength']; ?>"/>
					</td>
					<td align="left" valign="top"><?php echo _FB_LATEST_SUBJECT_LENGTH_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_SHOW_LATEST_DATE ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['latestShowDate']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_SHOW_LATEST_DATE_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_SHOW_LATEST_HITS ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['latestShowHits']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_SHOW_LATEST_HITS_DESC ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_SHOW_AUTHOR ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_latestShowAuthor"
							   value="<?php echo $fbConfig['latestShowAuthor']; ?>" size="1"/>
					</td>
					<td align="left" valign="top"><?php echo _FB_SHOW_AUTHOR_DESC ?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a name="stats" id="stats" href="javascript:void(0);" class="fbfuncsubtitle" style="display:block;">
		<?php echo _FB_STATS ?>
	</a>

	<div class="togg_stats">
		<fieldset>
			<legend><?php echo _FB_STATS ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _FB_SHOWSTATS; ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['showStats']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_SHOWSTATSDESC; ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_SHOWWHOIS; ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['showWhoisOnline']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_SHOWWHOISDESC; ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_STATSGENERAL; ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['showGenStats']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_STATSGENERALDESC; ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_USERSTATS; ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['showPopUserStats']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_USERSTATSDESC; ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_USERNUM; ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_PopUserCount"
							   value="<?php echo $fbConfig['PopUserCount']; ?>"/>
					</td>
					<td align="left" valign="top"><?php echo _FB_USERNUM; ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_USERPOPULAR; ?>
					</td>
					<td align="left" valign="top"><?php echo $lists['showPopSubjectStats']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_USERPOPULARDESC; ?>
					</td>
				</tr>
				<tr align="center" valign="middle">
					<td align="left" valign="top"><?php echo _FB_NUMPOP; ?>
					</td>
					<td align="left" valign="top">
						<input type="text" name="cfg_PopSubjectCount"
							   value="<?php echo $fbConfig['PopSubjectCount']; ?>"/>
					</td>
					<td align="left" valign="top"><?php echo _FB_NUMPOP; ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend> <?php echo _FB_MYPROFILE_PLUGIN_SETTINGS ?></legend>
			<table cellpadding="4" cellspacing="0" border="0" width="100%" class="fbadminform">
				<tr align="center" valign="middle">
					<td align="left" valign="top" width="25%"><?php echo _FB_USERNAMECANCHANGE; ?>
					</td>
					<td align="left" valign="top" width="25%"><?php echo $lists['usernamechange']; ?>
					</td>
					<td align="left" valign="top"><?php echo _FB_USERNAMECANCHANGE_DESC; ?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<input type="hidden" name="task" value="showConfig"/>
	<input type="hidden" name="option" value="<?php echo $option; ?>"/>
	<input type="hidden" name="cfg_version" value="<?php echo $fbConfig['version']; ?>"/>
	</form>
	</div><!-- closed div#fnconfigcover -->
	<?php
	}

	function showInstructions($database, $option, $mosConfig_lang){
		?>
	<table width="100%" border="0" cellpadding="2" cellspacing="2" class="adminheading">
		<TR>
			<th class="info">
				&nbsp;<?php echo _FB_INSTRUCTIONS; ?>
			</th>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding="2" cellspacing="2" class="adminform">
		<tr>
			<th><?php echo _FB_FINFO; ?>
			</th>
		</tr>
		<tr>
			<td>
				<?php echo _FB_INFORMATION; ?>
			</td>
		</tr>
	</table>
	<?php
	}

	function showCss($file, $option){
		$file = stripslashes($file);
		$f = fopen($file, "r");
		$content = fread($f, filesize($file));
		$content = htmlspecialchars($content);
		?>
	<div class="fbfunctitle"><?php echo _FB_CSSEDITOR; ?></div>
	<form action="index2.php?" method="post" name="adminForm" class="adminForm" id="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
			<tr>
				<th colspan="4">
					<?php echo _FB_PATH; ?> <?php echo $file; ?>
				</th>
			</tr>
			<tr>
				<td>
					<textarea cols="100" rows="20" name="csscontent"><?php echo $content; ?></textarea>
				</td>
			</tr>
			<tr>
				<td class="error"><?php echo _FB_CSSERROR; ?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="file" value="<?php echo $file; ?>"/>
		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="task" value="">
		<input type="hidden" name="boxchecked" value="0">
	</form>
	<?php
	}

	function showProfiles($option, $mosConfig_lang, &$profileList, $countPL, $pageNavSP, $order, $search){
		$database = database::getInstance();
		?>
	<div class="fbfunctitle"><?php echo _FB_FUM; ?></div>
	<form action="index2.php" method="POST" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>
				<td nowrap align="left" width="1%"><?php echo _COM_A_DISPLAY; ?>
				</td>
				<td nowrap align="left" width="1%">
					<?php echo $pageNavSP->writeLimitBox(); ?>
				</td>
				<td nowrap align="right">
					<?php echo _USRL_SEARCH_BUTTON; ?>:
				</td>
				<td nowrap align="right" width="10%">
					<input type="text" name="search" value="<?php echo $search;?>" class="inputbox"
						   onChange="document.adminForm.submit();"/>
				</td>
			</tr>
			<tr>
				<td colspan="4" nowrap>
					:: <a href="index2.php?option=com_fireboard&task=profiles&order=0">
					<?php echo _FB_SORTID; ?>
				</a> ::
					<a href="index2.php?option=com_fireboard&task=profiles&order=1">
						<?php echo _FB_MOD1; ?>
					</a> ::
					<a href="index2.php?option=com_fireboard&task=profiles&order=2">
						<?php echo _FB_SORTNAME; ?>
					</a>
				</td>
			</tr>
		</table>
		<table class="adminlist" border=0 cellspacing=0 cellpadding=3 width="100%">
			<tr>
				<th algin="left" width="20px">
					<input type="checkbox" name="toggle" value=""
						   onclick="checkAll(<?php echo count($profileList); ?>);"/>
				</th>
				<th algin="left" width="10px"><?php echo _ANN_ID; ?>
				</th>
				<th algin="left"><?php echo _USRL_NAME; ?>
				</th>
				<th algin="left"><?php echo _FB_USRL_USERNAME; ?>
				</th>
				<th algin="left" width="200px"><?php echo _GEN_EMAIL; ?>
				</th>
				<th algin="left" width="200px"><?php echo _VIEW_MODERATOR; ?>
				</th>
				<th algin="left"><?php echo _AFB_RANG; ?>
				</th>
				<th algin="left" width="*"><?php echo _AFB_BAN; ?>
				</th>
				<th algin="left" width="*"><?php echo _FB_USRL_GROUP; ?>
				</th>
			</tr>
			<?php
			if($countPL > 0){
				$k = 0;
				for($i = 0, $n = count($profileList); $i < $n; $i++){
					$pl = &$profileList[$i];
					$k = 1 - $k;
					?>
					<tr class="row<?php echo $k;?>">
						<td align="center">
							<input type="checkbox" id="cb<?php echo $i;?>" name="uid[]" value="<?php echo $pl->id; ?>"
								   onClick="isChecked(this.checked);">
						</td>
						<td align="left">
							<a href="#edit"
							   onclick="return listItemTask('cb<?php echo $i; ?>','userprofile')"><?php echo $pl->userid; ?></a>
						</td>
						<td align="left">
							<a href="#edit"
							   onclick="return listItemTask('cb<?php echo $i; ?>','userprofile')"><?php echo $pl->name; ?></a>
						</td>
						<td align="left">
							<a href="#edit"
							   onclick="return listItemTask('cb<?php echo $i; ?>','userprofile')"><?php echo $pl->username; ?></a>
						</td>
						<td align="left">
							<?php echo $pl->email; ?>
						</td>
						<td align="left">
							<?php
							if($pl->moderator){
								echo _ANN_YES;
							} else{
								echo _ANN_NO;
							}
							?>
						</td>
						<td align="left">
							<?php
							$database->setQuery("SELECT rank_title FROM #__fb_ranks WHERE rank_id=" . $pl->rank);
							$myrank = $database->loadResult();
							if(!$myrank) $myrank = _ANN_NO;
							echo $myrank;
							?>
						</td>
						<td align="left">
							<?php
							if($pl->ban) $myban = _ANN_YES;
							if(!$pl->ban) $myban = _ANN_NO;
							$banlink = 'index2.php?option=com_fireboard&task=banuser&banid=' . $pl->userid;
							if($pl->userid != 62) echo '<a href="' . $banlink . '" target="_self" title="' . _AFB_BANTRIGGER . '">';
							echo $myban;
							if($pl->userid != 62) echo '</a>';?>
						</td>
						<td width="*">
							<?php
							$database->setQuery("SELECT title FROM #__fb_groups WHERE id=" . $pl->group_id);
							$mygroup = $database->loadResult();
							if(!$mygroup) $mygroup = _ANN_NO;
							echo $mygroup;
							?>
						</td>
					</tr>
					<?php
				}
			} else{
				echo "<tr><td colspan=\"8\">" . _FB_NOUSERSFOUND . "</td></tr>";
			}
			?>
			<input type="hidden" name="order" value="<?php echo "$order";?>">
			<input type="hidden" name="option" value="<?php echo $option; ?>">
			<input type="hidden" name="task" value="showprofiles">
			<input type="hidden" name="boxchecked" value="0">
			<tr>
				<th align="center" colspan="9"> <?php echo $pageNavSP->writePagesLinks(); ?>
				</th>
			</tr>
			<tr>
				<td align="center" colspan="9"> <?php echo $pageNavSP->writePagesCounter(); ?>
				</td>
			</tr>
		</table>
	</form>
	<?php
	}

	function newModerator($option, $id, $moderators, &$modIDs, $forumName, &$userList, $countUL, $pageNav){
		?>
	<form action="index2.php" method="post" name="adminForm">
		<table cellpadding="4" class="adminheading" cellspacing="0" border="0" width="100%">
			<tr>
				<th width="100%" class="user"><?php echo _FB_ADDMOD; ?> <?php echo $forumName; ?>
				</th>
				<td nowrap><?php echo _COM_A_DISPLAY; ?>
				</td>
				<td>
					<?php echo $pageNav->writeLimitBox(); ?>
				</td>
				<td>&nbsp;
				</td>
				<td>&nbsp;
				</td>
			</tr>
		</table>
		<table class="adminlist" border=0 cellspacing=0 cellpadding=3 width="100%">
			<tr>
				<th width="20">
					#
				</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($userList); ?>);"/>
				</th>
				<th><?php echo _ANN_ID; ?>
				</th>
				<th align="left"><?php echo _USRL_NAME; ?>
				</th>
				<th align="left"><?php echo _GEN_EMAIL; ?>
				</th>
				<th><?php echo _FB_PUBLISHED; ?>
				</th>
				<th>&nbsp;
				</th>
			</tr>
			<?php
			if($countUL > 0){
				$k = 0;
				for($i = 0, $n = count($userList); $i < $n; $i++){
					$pl = &$userList[$i];
					$k = 1 - $k;
					?>
					<tr class="row<?php echo $k;?>">
						<td width="20" align="right"><?php echo $i + $pageNav->limitstart + 1; ?>
						</td>
						<td width="20">
							<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $pl->id; ?>"
								   onClick="isChecked(this.checked);">
						</td>
						<td width="20">
							<a href="index2.php?option=com_fireboard&task=userprofile&do=show&user_id=<?php echo $pl->id;?>"><?php echo $pl->id; ?></a>
						</td>
						<td>
							<?php echo $pl->name; ?>&nbsp;
						</td>
						<td>
							<?php echo $pl->email; ?>&nbsp;
						</td>
						<td align="center">
							<?php
							if($moderators){
								if(in_array($pl->id, $modIDs)){
									echo "<img src=\"images/tick.png\">";
								} else{
									echo "<img src=\"images/publish_x.png\">";
								}
							} else{
								echo "<img src=\"images/publish_x.png\">";
							}
							?>
						</td>
						<td>&nbsp;

						</td>
					</tr>
					<?php
				}
			} else{
				echo "<tr><td align='left' colspan='7'>" . _FB_NOMODSAV . "</td></tr>";
			}
			?>
			<input type="hidden"
				   name="option" value="<?php echo $option; ?>"> <input type="hidden" name="id"
																		value="<?php echo $id; ?>"> <input type="hidden"
																										   name="boxchecked"
																										   value="0">
			<input type="hidden" name="task" value="newmoderator">
			<tr>
				<th align="center" colspan="7"> <?php echo $pageNav->writePagesLinks(); ?>
				</th>
			</tr>
			<tr>
				<td align="center" colspan="7"> <?php echo $pageNav->writePagesCounter(); ?>
				</td>
			</tr>
			<tr>
				<td colspan="7"><?php echo _FB_NOTEUS; ?>
				</td>
			</tr>
		</table>
	</form>
	<?php
	}

	function editUserProfile($user, $subslist, $selectRank, $selectGroup, $selectPref, $selectMod, $selectOrder, $uid, $modCats){
		global $fbConfig;
		$database = database::getInstance();

		$signature = $user->signature;
		$username = $user->name;
		$avatar = $user->avatar;
		$ordering = $user->ordering;
		$csubslist = count($subslist);
		$ban = $user->ban;
		include_once (JPATH_BASE_ADMIN . '/components/com_fireboard/bb_adm.js.php');
		?>
	<form action="index2.php" method="POST" name="adminForm">
		<table border=0 cellspacing=0 width="100%" align="center" class="adminheading">
			<tr>
				<th colspan="3" class="user">
					<?php echo _FB_PROFFOR; ?> <?php echo $username; ?>
				</th>
			</tr>
		</table>

		<table border="1" cellspacing="1" width="100%" align="center" class="adminlist">
			<tr>
				<th colspan="3" class="title"><?php echo _FB_GENPROF; ?></th>
			</tr>
			<tr>
				<td width="150" class="contentpane"><?php echo _FB_PREFVIEW; ?></td>
				<td align="left" valign="top" class="contentpane"><?php echo $selectPref; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="150" class="contentpane"><?php echo _FB_PREFOR; ?></td>
				<td align="left" valign="top" class="contentpane"><?php echo $selectOrder; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="150" class="contentpane"><?php echo _FB_USRL_GROUP; ?></td>
				<td align="left" valign="top" class="contentpane"><?php echo $selectGroup; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="150" class="contentpane"><?php echo _AFB_RANG; ?></td>
				<td align="left" valign="top" class="contentpane"><?php echo $selectRank; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="150" class="contentpane"><?php echo _AFB_BAN; ?></td>
				<td align="left" valign="top" class="contentpane">
					<?php
					if($ban) echo '<span style="color:red; font-weight:bold;">' . _ANN_YES . '</span>';
					if(!$ban) echo '<span style="color:green; font-weight:bold;">' . _ANN_NO . '</span>';
					?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="150" valign="top" class="contentpane">
					<?php echo _GEN_SIGNATURE; ?>:
					<br/><?php echo $fbConfig['maxSig']; ?>
					<input readonly type=text name=rem size=3 maxlength=3 value=""
						   class="inputbox"> <?php echo _CHARS; ?><br/>
					<?php echo _HTML_YES; ?>
				</td>
				<td align="left" valign="top" class="contentpane">
					<textarea rows="6" class="inputbox"
							  onMouseOver="textCounter(this.form.message,this.form.rem,<?php echo $fbConfig['maxSig'];?>);"
							  onClick="textCounter(this.form.message,this.form.rem,<?php echo $fbConfig['maxSig'];?>);"
							  onKeyDown="textCounter(this.form.message,this.form.rem,<?php echo $fbConfig['maxSig'];?>);"
							  onKeyUp="textCounter(this.form.message,this.form.rem,<?php echo $fbConfig['maxSig'];?>);"
							  cols="50" name="message"><?php echo $signature; ?></textarea>
					<br/>
					<input type="button" class="button" accesskey="b" name="addbbcode0" value=" B "
						   style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline('b')"/>
					<input type="button" class="button" accesskey="i" name="addbbcode2" value=" i "
						   style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline('i')"/>
					<input type="button" class="button" accesskey="u" name="addbbcode4" value=" u "
						   style="text-decoration: underline; width: 30px" onClick="bbstyle(4)"
						   onMouseOver="helpline('u')"/>
					<input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"
						   onClick="bbstyle(14)" onMouseOver="helpline('p')"/>
					<input type="button" class="button" accesskey="w" name="addbbcode16" value="URL"
						   style="text-decoration: underline; width: 40px" onClick="bbstyle(16)"
						   onMouseOver="helpline('w')"/>
					<br/><?php echo _FB_COLOR; ?>:
					<select name="addbbcode20"
							onChange="bbfontstyle('[color=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;"
							onMouseOver="helpline('s')">
						<option style="color:black;  background-color: #FAFAFA"
								value=""><?php echo _COLOUR_DEFAULT; ?></option>
						<option style="color:red;    background-color: #FAFAFA"
								value="#FF0000"><?php echo _COLOUR_RED; ?></option>
						<option style="color:blue;   background-color: #FAFAFA"
								value="#0000FF"><?php echo _COLOUR_BLUE; ?></option>
						<option style="color:green;  background-color: #FAFAFA"
								value="#008000"><?php echo _COLOUR_GREEN; ?></option>
						<option style="color:yellow; background-color: #FAFAFA"
								value="#FFFF00"><?php echo _COLOUR_YELLOW; ?></option>
						<option style="color:orange; background-color: #FAFAFA"
								value="#FF6600"><?php echo _COLOUR_ORANGE; ?></option>
					</select>
					<?php echo _SMILE_SIZE; ?>:
					<select name="addbbcode22"
							onChange="bbfontstyle('[size=' + this.form.addbbcode22.options[this.form.addbbcode22.selectedIndex].value + ']', '[/size]')"
							onMouseOver="helpline('f')">
						<option value="1"><?php echo _SIZE_VSMALL; ?></option>
						<option value="2"><?php echo _SIZE_SMALL; ?></option>
						<option value="3" selected><?php echo _SIZE_NORMAL; ?></option>
						<option value="4"><?php echo _SIZE_BIG; ?></option>
						<option value="5"><?php echo _SIZE_VBIG; ?></option>
					</select>
					<a href="javascript: bbstyle(-1)" onMouseOver="helpline('a')">
						<small><?php echo _BBCODE_CLOSA; ?></small>
					</a>
					<br/>
					<input type="text" name="helpbox" size="45" maxlength="100" style="width:400px; font-size:8px"
						   class="options" value="<?php echo _BBCODE_HINT;?>"/>
				</td>
				<?php
				if($fbConfig['allowAvatar']){
					?>
					<td class="contentpane" align="center">
						<?php echo _FB_UAVATAR; ?><br/>
						<?php
						if($avatar != ''){
							echo '<img src="' . FB_LIVEUPLOADEDPATH . '/avatars/' . $avatar . '" ><br />';
							echo '<input type="hidden" value="' . $avatar . '" name="avatar">';
						} else{
							echo "<em>" . _FB_NS . "</em><br />";
							echo '<input type="hidden" value="$avatar" name="avatar">';
						}
						?>
					</td>
					<?php
				} else{
					echo '<td><input type="hidden" value="" name="avatar"></td>';
				}
				?>
			</tr>
			<tr>
				<td colspan="2" class="contentpane">
					<?php if($signature){ ?>
					<input type="checkbox" value="1" name="deleteSig"><i><?php echo _FB_DELSIG; ?></i>
					<?php }?>
				</td>
				<?php
				if($fbConfig['allowAvatar']){
					?>
					<td class="contentpane">
						<?php if($avatar){ ?>
						<input type="checkbox" value="1" name="deleteAvatar"><i><?php echo _FB_DELAV; ?></i>
						<?php }?>
					</td>
					<?php
				} else{
					echo "<td>&nbsp;</td>";
				}
				?>
			</tr>
		</table>

		<table border=0 cellspacing=0 width="100%" align="center" class="adminform">
			<tr>
				<th colspan="2" class="title">
					<?php echo _FB_MOD_NEW; ?>
				</th>
			</tr>
			<tr>
				<td width="150" class="contentpane">
					<?php echo _FB_ISMOD; ?><br/>
					<?php
					if(FBTools::isModOrAdmin($uid)){
						echo _FB_ISADM; ?><input type="hidden" name="moderator" value="1">
						<?php
					} else{
						echo $selectMod;
					}
					?>
				</td>
				<td>
					<?php echo $modCats;?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="uid" value="<?php echo $uid;?>">
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="option" value="com_fireboard"/>
	</form>
        <table border=0 cellspacing=0 width="100%" align="center" class="adminform">
            <tr>
				<th colspan="2" class="title">
					<?php echo _FB_SUBFOR; ?> <?php echo $username; ?>
				</th>
			</tr>
		<?php
		$enum = 1;
		$k = 0;
		if($csubslist > 0){
			foreach($subslist as $subs){
				$database->setQuery("select * from #__fb_messages where id=$subs->thread");
				$subdet = $database->loadObjectList();
				foreach($subdet as $sub){
					$k = 1 - $k;
					echo "<tr class=\"row$k\">";
					echo "  <td>$enum: $sub->subject by $sub->name";
					echo "  <td>&nbsp;</td>";
					echo "</tr>";
					$enum++;
				}
			}
		} else{
			echo "<tr><td class=\"message\">" . _FB_NOSUBS . "</td></tr>";
		}
		echo "</table>";
	}

	function pruneforum($option, $forumList){
		?>
	<div class="fbfunctitle"><?php echo _COM_A_PRUNE; ?></div>
	<form action="index2.php" method="post" name="adminForm">
		<table class="adminform" cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>
				<th width="100%" colspan="2">&nbsp;
				</th>
			</tr>
			<tr>
				<td colspan="2"><?php echo _COM_A_PRUNE_DESC ?>
				</td>
			</tr>
			<tr>
				<td nowrap width="10%"><?php echo _COM_A_PRUNE_NAME ?>
				</td>
				<td nowrap><?php echo $forumList['forum'] ?>
				</td>
			</tr>
			<tr>
				<td nowrap width="10%"><?php echo _COM_A_PRUNE_NOPOSTS ?>
				</td>
				<td nowrap>
					<input type="text" name="prune_days" value="30"> <?php echo _COM_A_PRUNE_DAYS ?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="option" value="<?php echo $option; ?>"/>
	</form>
		<?php
	}

	function syncusers($option){
		?>
	<div class="fbfunctitle"><?php echo _FB_SYNC_USERS; ?></div>
	<form action="index2.php" method="post" name="adminForm">
		<table cellpadding="4" class="adminform" cellspacing="0" border="0" width="100%">
			<tr>
				<th width="100%" colspan="2">&nbsp;
				</th>
			</tr>
			<tr>
				<td colspan="2"><?php echo _FB_SYNC_USERS_DESC ?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="option" value="<?php echo $option; ?>"/>
	</form>
		<?php
	}

	function browseUploaded($option, $uploaded, $uploaded_path, $liveuploaded_path, $type){
		$database = database::getInstance();
		$mainframe = mosMainFrame::getInstance();

		$map = $mainframe->getCfg('absolute_path');
		?>
	<SCRIPT LANGUAGE="Javascript">
		<!--
		function decision(message, url) {
			if (confirm(message))
				location.href = url;
		}
		// -->
	</SCRIPT>
		<?php
		echo ' <div class="fbfunctitle">';
		echo $type ? _COM_A_IMGB_IMG_BROWSE : _COM_A_IMGB_FILE_BROWSE;
		echo '</div>';
		echo '<table class="adminform"><tr><td>';
		echo $type ? _COM_A_IMGB_TOTAL_IMG : _COM_A_IMGB_TOTAL_FILES;
		echo ': ' . count($uploaded) . '</td></tr>';
		echo '<tr><td>';
		echo $type ? _COM_A_IMGB_ENLARGE : _COM_A_IMGB_DOWNLOAD;
		echo '</td></tr><tr><td>';
		echo $type ? _COM_A_IMGB_DUMMY_DESC . '</td></tr><tr><td>' . _COM_A_IMGB_DUMMY . ':</td></tr><tr><td><img src="' . FB_LIVEUPLOADEDPATH . '/dummy.gif">' : '';
		echo '</td></tr></table>';
		echo '<table class="adminform"><tr>';
		for($i = 0; $i < count($uploaded); $i++){
			$j = $i + 1;
			$query = $type ? "SELECT mesid FROM #__fb_attachments where filelocation='" . FB_ABSUPLOADEDPATH . "/images/$uploaded[$i]'" : "SELECT mesid FROM #__fb_attachments where filelocation='" . FB_ABSUPLOADEDPATH . "/files/$uploaded[$i]'";
			$database->setQuery($query);
			$mesid = $database->loadResult();
			$database->setQuery("SELECT catid FROM #__fb_messages where id='$mesid'");
			$catid = $database->loadResult();
			echo $mesid == '' ? '<td>' : '<td>';
			//echo $liveuploaded_path;
			echo '<table style="border: 1px solid #ccc;"><tr><td height="90" width="130" align="center">';
			echo $type ? '<center><a href="' . $liveuploaded_path . $uploaded[$i] . '" rel="facebox" title="' . _COM_A_IMGB_ENLARGE . '" alt="' . _COM_A_IMGB_ENLARGE . '">
				<img src="' . $liveuploaded_path . $uploaded[$i] . '" width="80px" border="0"></a></center>' : '<center><a href="' . $liveuploaded_path . $uploaded[$i] . '" title="' . _COM_A_IMGB_DOWNLOAD . '" alt="' . _COM_A_IMGB_DOWNLOAD . '">
				<img src="/administrator/components/com_fireboard/images/fbfile.png" border="0"></a></center>';
			echo '</td></tr><tr><td align="middle">';
			echo '<br />';
			echo '<strong>' . _COM_A_IMGB_NAME . ': </strong> ' . $uploaded[$i] . '<br />';
			echo '<strong>' . _COM_A_IMGB_SIZE . ': </strong> ' . filesize($uploaded_path . '/' . $uploaded[$i]) . ' bytes<br />';
			$type ? list($width, $height) = @getimagesize($uploaded_path . '/' . $uploaded[$i]) : '';
			echo $type ? '<strong>' . _COM_A_IMGB_DIMS . ': </strong> ' . $width . 'x' . $height . '<br />' : '';
			echo $type ? '<a href="index2.php?option=' . $option . '&task=replaceImage&OxP=1&img=' . $uploaded[$i] . '">' . _COM_A_IMGB_REPLACE . '</a><br />' : '';
			echo $type ? '<a href="javascript:decision(\'' . _COM_A_IMGB_CONFIRM . '\',\'index2.php?option=' . $option . '&task=replaceImage&OxP=2&img=' . $uploaded[$i] . '\')">' . _COM_A_IMGB_REMOVE . '</a><br />' : '<a href="javascript:decision(\'' . _COM_A_IMGB_CONFIRM . '\',\'index2.php?option=' . $option . '&task=deleteFile&fileName=' . $uploaded[$i] . '\')">' . _COM_A_IMGB_REMOVE . '</a><br />';
			if($mesid != ''){
				echo '<a href="../index.php?option=' . $option . '&func=view&catid=' . $catid . '&id=' . $mesid . '#' . $mesid . '" target="_blank">' . _COM_A_IMGB_VIEW . '</a>';
			} else{
				echo _COM_A_IMGB_NO_POST;
			}
			echo '</td></tr></table>';
			echo '</td>';
			if(function_exists('fmod')){
				if(!fmod(($j), 5)){
					echo '</tr><tr align="center" valign="middle">';
				}
			} else{
				if(!FB_fmodReplace(($j), 5)){
					echo '</tr><tr align="center" valign="middle">';
				}
			}
		}
		echo '</tr></table>';
	}

	function showsmilies($option, $mosConfig_lang, &$smileytmp, $pageNavSP, $smileypath){
		?>
	<div class="fbfunctitle"><?php echo _FB_EMOTICONS; ?></div>
	<form action="index2.php" method="POST" name="adminForm">
		<table class="adminheading" cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>
				<td nowrap align="right"><?php echo _COM_A_DISPLAY; ?>
				</td>
				<td nowrap align="right" width="5%">
					<?php echo $pageNavSP->writeLimitBox(); ?>
				</td>
			</tr>
		</table>
		<table class="adminlist" border="0" cellspacing="0" cellpadding="3" width="100%">
			<tr>
				<th algin="left" width="20">
					<input type="checkbox" name="toggle" value=""
						   onclick="checkAll(<?php echo count($smileytmp); ?>);"/>
				</th>
				<th algin="right" width="10"><?php echo _ANN_ID; ?>
				</th>
				<th algin="center" width="200"><?php echo _FB_EMOTICONS_SMILEY; ?>
				</th>
				<th algin="center" width="100"><?php echo _FB_EMOTICONS_CODE; ?>
				</th>
				<th algin="right" width="200"><?php echo _FB_EMOTICONS_URL; ?>
				</th>
				<th width="*">&nbsp;
				</th>
			</tr>
			<?php
			$k = 0;
			for($i = 0, $n = count($smileytmp); $i < $n; $i++){
				$k = 1 - $k;
				$s = &$smileytmp[$i];
				?>
				<tr class="row<?php echo $k;?>">
					<td width="20">
						<input type="checkbox" id="cb<?php echo $i;?>" name="id" value="<?php echo $s->id; ?>"
							   onClick="isChecked(this.checked);"></td>
					<td width="10">
						<a href="#edit"
						   onclick="return listItemTask('cb<?php echo $i; ?>','editsmiley')"><?php echo $s->id; ?></a>
					</td>
					<td width="200">
						<a href="#edit" onclick="return listItemTask('cb<?php echo $i; ?>','editsmiley')"><img
							src="<?php echo ($smileypath['live'] . '/' . $s->location); ?>"
							alt="<?php echo $s->location; ?>" border="0"/></a>
					</td>
					<td width="100">
						<?php echo $s->code; ?>&nbsp;
					</td>
					<td width="200">
						<?php echo $s->location; ?>&nbsp;
					</td>
					<td>&nbsp;
					</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<th align="center" colspan="6"> <?php echo $pageNavSP->writePagesLinks(); ?>
				</th>
			</tr>
			<tr>
				<td align="center" colspan="6"> <?php echo $pageNavSP->writePagesCounter(); ?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>"><input type="hidden" name="task"
																				 value="showsmilies"><input
		type="hidden" name="boxchecked" value="0">
	</form>
		<?php
	}

	function editsmiley($option, $mosConfig_lang, $smiley_edit_img, $filename_list, $smileypath, $smileycfg){
		?>
	<script language="javascript" type="text/javascript">
		<!--
		function update_smiley(newimage) {
			document.smiley_image.src = "<?php echo $smileypath; ?>" + newimage;
		}
		//-->
	</script>
	<div class="fbfunctitle"><?php echo _FB_EMOTICONS_EDIT_SMILEY; ?></div>
	<form action="index2.php" method="POST" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
			<tr align="center">
				<td width="100"><?php echo _FB_EMOTICONS_CODE; ?></td>
				<td width="200"><input class="post" type="text" name="smiley_code"
									   value="<?php echo $smileycfg['code'];?>"/></td>
				<td rowspan="3" width="50"><img name="smiley_image" src="<?php echo $smiley_edit_img; ?>" border="0"
												alt=""/> &nbsp;</td>
				<td rowspan="3">&nbsp;</td>
			</tr>
			<tr align="center">
				<td width="100"><?php echo _FB_EMOTICONS_URL; ?></td>
				<td><select name="smiley_url"
							onchange="update_smiley(this.options[selectedIndex].value);"><?php echo $filename_list; ?></select>
					&nbsp; </td>
			</tr>
			<tr>
				<td width="100"><?php echo _FB_EMOTICONS_EMOTICONBAR; ?></td>
				<td><input type="checkbox" name="smiley_emoticonbar" value="1"<?php if($smileycfg['emoticonbar'] == 1){
					echo 'checked="checked"';
				} ?> /></td>
			<tr>
			<tr>
				<td colspan="2" align="center">
					<input type="hidden" name="option" value="<?php echo $option; ?>">
					<input type="hidden" name="task" value="showsmilies">
					<input type="hidden" name="boxchecked" value="0">
					<input type="hidden" name="id" value="<?php echo $smileycfg['id']; ?>">
				</td>
			</tr>
		</table>
	</form>
		<?php
	}

	function newsmiley($option, $filename_list, $smileypath){
		?>
	<script language="javascript" type="text/javascript">
		<!--
		function update_smiley(newimage) {
			document.smiley_image.src = "<?php echo $smileypath; ?>" + newimage;
		}
		//-->
	</script>
	<div class="fbfunctitle"><?php echo _FB_EMOTICONS_NEW_SMILEY; ?></div>
	<form action="index2.php" method="POST" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
			<tr align="center">
				<td width="100"><?php echo _FB_EMOTICONS_CODE; ?></td>
				<td width="200"><input class="post" type="text" name="smiley_code" value=""/></td>
				<td rowspan="3" width="50"><img name="smiley_image" src="" border="0" alt=""/> &nbsp;</td>
				<td rowspan="3">&nbsp;</td>
			</tr>
			<tr align="center">
				<td width="100"><?php echo _FB_EMOTICONS_URL; ?></td>
				<td><select name="smiley_url"
							onchange="update_smiley(this.options[selectedIndex].value);"><?php echo $filename_list; ?></select>
					&nbsp; </td>
			</tr>
			<tr>
				<td width="100"><?php echo _FB_EMOTICONS_EMOTICONBAR; ?></td>
				<td><input type="checkbox" name="smiley_emoticonbar" value="1"/></td>
			<tr>
				<td colspan="2" align="center"><input type="hidden" name="option" value="<?php echo $option; ?>"> <input
					type="hidden" name="task" value="showsmilies"> <input type="hidden" name="boxchecked" value="0">
				</td>
			</tr>
		</table>
	</form>
		<?php
	}

	function showRanks($option, $mosConfig_lang, &$ranks, $pageNavSP, $order, $rankpath){
		$mainframe = mosMainFrame::getInstance();
		?>
	<div class="fbfunctitle"><?php echo _FB_RANKS_MANAGE; ?></div>
	<div class="fbfunctitle" style="font-size:12px; font-weight:normal;"><?php echo _AFB_GROUPS_MANAGE_EDIT; ?></div>
	<form action="index2.php" method="POST" name="adminForm">
		<table class="adminheading" cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>
				<td nowrap="nowrap" align="right"><?php echo _COM_A_DISPLAY;?></td>
				<td nowrap="nowrap" align="right" width="1%"><?php echo $pageNavSP->writeLimitBox(); ?></td>
			</tr>
		</table>
		<table class="adminlist" border=0 cellspacing=0 cellpadding=3 width="100%">
			<tr>
				<th width="20" align="center">#</th>
				<th align="left"><input type="checkbox" name="toggle" value=""
										onclick="checkAll(<?php echo count($ranks); ?>);"/></th>
				<th align="left"><?php echo _FB_RANKSIMAGE;?></th>
				<th align="left" nowrap="nowrap"><?php echo _FB_RANKS;?></th>
				<th align="left" nowrap="nowrap"><?php echo _FB_RANKS_SPECIAL;?></th>
				<th algin="left" nowrap="nowrap"><?php echo _FB_RANKSMIN;?></th>
			</tr>
			<?php
			$k = 0;
			foreach($ranks as $id => $row){
				$k = 1 - $k;
				$edit = $mainframe->getCfg('live_site') . '/components/com_fireboard/template/default/js/rankname.php';
				$load = $mainframe->getCfg('live_site') . '/components/com_fireboard/template/default/js/load.gif';
				?>
				<tr class="row<?php echo $k;?>">
					<td width="20" align="center"><?php echo ($id + $pageNavSP->limitstart + 1);?></td>
					<td width="20" align="center"><input type="checkbox" id="cb<?php echo $id;?>" name="id"
														 value="<?php echo $row->rank_id; ?>"
														 onClick="isChecked(this.checked);"></td>
					<td><a href="#edit" onclick="return listItemTask('cb<?php echo $id; ?>','editRank')"><img
						src="<?php echo ($rankpath['live'] . '/' . $row->rank_image); ?>"
						alt="<?php echo $row->rank_image; ?>" border="0"/></a></td>
					<td nowrap="nowrap">
						<p class="editrank<?php echo $row->rank_id;?>" title="<?php echo _AFB_EDITINPLACE;?>">
							<?php echo $row->rank_title; ?>
						</p>
						<script type="text/javascript">
							$j(document).ready(function () {
								$j(".editrank<?php echo $row->rank_id;?>").editInPlace({
									url:"<?php echo $edit;?>",
									saving_image:"<?php echo $load;?>",
									save_button:"<input type='submit' class='inplace_save' value='ok'/>",
									cancel_button:"<input type='submit' class='inplace_cancel' value='x'/>",
									params:"ajax=yes&gid=<?php echo $row->rank_id;?>"
								});
							});
						</script>
					</td>
					<td><?php if($row->rank_special == 1){
						echo _ANN_YES;
					} else{
						echo _ANN_NO;
					} ?></td>
					<td align="left">
						<?php echo $row->rank_min; ?>
					</td>
				</tr>
				<?php }  ?>
			<input type="hidden" name="option" value="<?php echo $option; ?>">
			<input type="hidden" name="boxchecked" value="0">
			<input type="hidden" name="task" value="ranks">
			<tr>
				<th align="center" colspan="7"><?php echo $pageNavSP->writePagesLinks(); ?></th>
			</tr>
			<tr>
				<td align="center" colspan="7"><?php echo $pageNavSP->writePagesCounter(); ?></td>
			</tr>
		</table>
	</form>
		<?php
	}

	function newRank($option, $filename_list, $rankpath){
		?>
	<script language="javascript" type="text/javascript">
		<!--
		function update_rank(newimage) {
			document.rank_image.src = "<?php echo $rankpath; ?>" + newimage;
		}
		//-->
	</script>
	<div class="fbfunctitle"><?php echo _FB_NEW_RANK; ?></div>
	<form action="index2.php" method="POST" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
			<tr align="center">
				<td width="100"><?php echo _FB_RANKS; ?></td>
				<td width="200"><input class="post" type="text" name="rank_title" value=""/></td>
			</tr>
			<tr>
				<td width="100"><?php echo _FB_RANKSIMAGE; ?></td>
				<td>
					<select name="rank_image" onchange="update_rank(this.options[selectedIndex].value);"><?php echo $filename_list; ?></select>
					&nbsp; <img name="rank_image" src="" border="0" alt=""/>
				</td>
			<tr>
			<tr>
				<td width="100"><?php echo _FB_RANKSMIN; ?></td>
				<td><input class="post" type="text" name="rank_min" value="1"/></td>
			<tr>
			<tr>
				<td width="100"><?php echo _FB_RANKS_SPECIAL; ?></td>
				<td><input type="checkbox" name="rank_special" value="1"/></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="hidden" name="option" value="<?php echo $option; ?>">
					<input type="hidden" name="task" value="showRanks">
					<input type="hidden" name="boxchecked" value="0">
				</td>
			</tr>
		</table>
	</form>
		<?php
	}

	function editrank($option, $mosConfig_lang, $edit_img, $filename_list, $path, $row){
		?>
	<script language="javascript" type="text/javascript">
		<!--
		function update_rank(newimage) {
			document.rank_image.src = "<?php echo $path; ?>" + newimage;
		}
		//-->
	</script>
	<div class="fbfunctitle"><?php echo _FB_RANKS_EDIT; ?></div>
	<form action="index2.php" method="POST" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
			<tr align="center">
				<td width="100"><?php echo _FB_RANKS; ?></td>
				<td width="200"><input class="post" type="text" name="rank_title"
									   value="<?php echo $row->rank_title;?>"/></td>
			</tr>
			<tr align="center">
				<td width="100"><?php echo _FB_RANKSIMAGE; ?></td>
				<td><select name="rank_image"
							onchange="update_rank(this.options[selectedIndex].value);"><?php echo $filename_list; ?></select>
					&nbsp; <img name="rank_image" src="<?php echo $edit_img; ?>" border="0" alt=""/></td>
			</tr>
			<tr>
				<td width="100"><?php echo _FB_RANKSMIN; ?></td>
				<td><input class="post" type="text" name="rank_min" value="<?php echo $row->rank_min;?>"/></td>
			</tr>
			<tr>
				<td width="100"><?php echo _FB_RANKS_SPECIAL; ?></td>
				<td><input type="checkbox" name="rank_special" value="1"<?php if($row->rank_special == 1){
					echo 'checked="checked"';
				} ?> /></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="hidden" name="option" value="<?php echo $option; ?>"> <input
					type="hidden" name="task" value="showRanks"> <input type="hidden" name="boxchecked" value="0"><input
					type="hidden" name="id" value="<?php echo $row->rank_id; ?>"></td>
			</tr>
		</table>
	</form>
		<?php
	}

	function showGroups($option, $mosConfig_lang, $groups){
		$database = database::getInstance();
		$mainframe = mosMainFrame::getInstance();
		?>
	<div class="fbfunctitle"><?php echo _AFB_GROUPS_MANAGE; ?></div>
	<div class="fbfunctitle" style="font-size:12px; font-weight:normal;"><?php echo _AFB_GROUPS_MANAGE_EDIT; ?></div>
	<form action="index2.php" method="POST" name="adminForm">
		<table class="adminlist" border=0 cellspacing=0 cellpadding=3 width="100%">
			<tr>
				<th width="20" align="center">#</th>
				<th align="left"><?php echo _FB_GROUPSIMAGE;?></th>
				<th align="left" nowrap="nowrap"><?php echo _FB_GROUPNAME;?></th>
				<th align="left" nowrap="nowrap"><?php echo _FB_GROUP_COL;?></th>
			</tr>
			<?php
			$k = 0;
			foreach($groups as $id => $row){
				if($row->id == 1){
					$img = _AFB_NOIMG;
				} else{
					$img = '<img src="' . $mainframe->getCfg('live_site') . '/components/com_fireboard/template/default/images/' . $mainframe->getCfg('lang') . '/ranks/group_' . ($row->id) . '.gif" border="0"/>';
				}
				$database->setQuery("SELECT COUNT(*) FROM #__fb_users WHERE group_id=" . $row->id);
				$tot = $database->loadResult();
				$edit = $mainframe->getCfg('live_site') . '/components/com_fireboard/template/default/js/groups.php';
				$load = $mainframe->getCfg('live_site') . '/components/com_fireboard/template/default/js/load.gif';
				$k = 1 - $k;
				?>
				<tr class="row<?php echo $k;?>">
					<td width="20" align="center"><?php echo ($id + 1);?></td>
					<td><?php echo $img;?></td>
					<td>
						<p class="editme<?php echo $row->id;?>" title="<?php echo _AFB_EDITINPLACE;?>">
							<?php echo $row->title; ?>
						</p>
						<script type="text/javascript">
							$j(document).ready(function () {
								$j(".editme<?php echo $row->id;?>").editInPlace({
									url:"<?php echo $edit;?>",
									saving_image:"<?php echo $load;?>",
									save_button:"<input type='submit' class='inplace_save' value='ok'/>",
									cancel_button:"<input type='submit' class='inplace_cancel' value='x'/>",
									params:"ajax=yes&gid=<?php echo $row->id;?>"
								});
							});
						</script>
					</td>
					<td><?php echo $tot;?></td>
				</tr>
				<?php
			}?>
			<input type="hidden" name="option" value="<?php echo $option; ?>">
			<input type="hidden" name="boxchecked" value="0">
			<input type="hidden" name="task" value="groups">
		</table>
	</form>
	<?php
	}
}

?>