<?php
/**
 * @version $Id: moderate_messages.php 462 2007-12-10 00:05:53Z fxstein $
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
global $my;
$catid = (int)$catid;
if(!$is_moderator){
	die ("You are not a moderator!!<br />This error is logged and your IP address has been sent to the SuperAdmin(s) of this site; sorry..");
}
$action = mosGetParam($_POST, 'action', 'list');
$cid = mosGetParam($_POST, 'cid', array());
switch($action){
	case _MOD_DELETE:
		switch(jbDeletePosts($database, $cid)){
			case -1:
				mosRedirect(JB_LIVEURL . 'func=review&amp;catid=' . $catid, "ERROR: The post has been deleted but the text could not be deleted\n Check the #__fb_messages_text table for mesid IN " . explode(',', $cid));
				break;
			case 0:
				mosRedirect(JB_LIVEURL . '&amp;func=review&amp;catid=' . $catid, _MODERATION_DELETE_ERROR);
				break;
			case 1:
			default:
				mosRedirect(JB_LIVEURL . '&amp;func=review&amp;catid=' . $catid, _MODERATION_DELETE_SUCCESS);
				break;
		}
		break;
	case _MOD_APPROVE:
		switch(jbApprovePosts($database, $cid)){
			case 0:
				mosRedirect(JB_LIVEURL . 'amp;func=review&amp;catid=' . $catid, _MODERATION_APPROVE_ERROR);
				break;
			default:
			case 1:
				mosRedirect(JB_LIVEURL . '&amp;func=review&amp;catid=' . $catid, _MODERATION_APPROVE_SUCCESS);
				break;
		}
		break;
	default:
	case 'list':
		echo '<p class="sectionname"><?php echo _MESSAGE_ADMINISTRATION; ?></p>';
		$database->setQuery("SELECT m.id,m.time,m.name,m.subject,m.hold,t.message FROM #__fb_messages AS m JOIN #__fb_messages_text as t ON m.id=t.mesid WHERE hold='1' AND catid=$catid ORDER BY id ASC");
		if(!$database->query()) echo $database->getErrorMsg(); // TODO
		$allMes = $database->loadObjectList();
		if(count($allMes) > 0) jbListMessages($allMes, $catid); else
			echo '<p style="text-align:center">' . _MODERATION_MESSAGES . '</p>';
		break;
}
function jbListMessages($allMes, $catid){
	global $fbConfig;
	echo '<form action="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=review') . '" name="moderation" method="post">';
	?>
<script>
	function ConfirmDelete() {
		if (confirm("<?php echo _MODERATION_DELETE_MESSAGE; ?>"))
			document.moderation.submit();
		else
			return false;
	}
</script>
<table width="100%" border=0 cellspacing=1 cellpadding=3>
	<tr class="fb_table_header">
		<th align="center">
			<b><?php echo _GEN_DATE; ?></b>
		</th>
		<th width="8%" align="center">
			<b><?php echo _GEN_AUTHOR; ?></b>
		</th>
		<th width="13%" align="center">
			<b><?php echo _GEN_SUBJECT; ?></b>
		</th>
		<th width="55%" align="center">
			<b><?php echo _GEN_MESSAGE; ?></b>
		</th>
		<th width="13%" align="center">
			<b><?php echo _GEN_ACTION; ?></b>
		</th>
	</tr>
	<?php
	$i = 1;
	$smileyList = smile::getEmoticons("");
	foreach($allMes as $message){
		$i = 1 - $i;
		echo '<tr class="fb_message' . $i . '">';
		echo '<td valign="top">' . date(_DATETIME, $message->time) . '</td>';
		echo '<td valign="top">' . $message->name . '</td>';
		echo '<td valign="top"><b>' . $message->subject . '<b></td>';
		$fb_message_txt = stripslashes($message->message);
		echo '<td valign="top">' . smile::smileReplace($fb_message_txt, 0, $fbConfig['disemoticons'], $smileyList) . '</td>';
		echo '<td valign="top"><input type="checkbox" name="cid[]" value="' . $message->id . '" /></td>';
		echo '</tr>';
	}
	?>
	<tr>
		<td colspan="5" align="center" valign="top" style="text-align:center">
			<input type="hidden" name="catid" value="<?php echo $catid; ?>"/>
			<input type="submit"
				   align="center"
				   class="button" name="action" value="<?php echo _MOD_APPROVE; ?>">
			<input type="submit" align="center" class="button" name="action" onclick="ConfirmDelete()" value="<?php echo _MOD_DELETE; ?>">
		</td>
	</tr>
	<tr bgcolor="#e2e2e2">
		<td colspan="5">&nbsp;
		</td>
	</tr>
</table>
</form>
<?php
}

function jbDeletePosts($database, $cid){
	if(count($cid) == 0) return 0;
	$ids = implode(',', $cid);
	$database->setQuery('DELETE FROM `#__fb_messages` WHERE `id` IN (' . $ids . ')');
	if($database->query()){
		$database->setQuery('DELETE FROM `#__fb_messages_text` WHERE `mesid` IN (' . $ids . ')');
		if($database->query()) return 1; else
			return -1;
	}
	return 0;
}

function jbApprovePosts($database, $cid){
	if(count($cid) == 0) return 0;
	$ret = 1;
	reset($cid);
	foreach($cid as $id){
		$id = (int)$id;
		$newQuery = "SELECT * FROM #__fb_messages WHERE id = " . $id . " LIMIT 1";
		$database->setQuery($newQuery);
		$msg = null;
		$database->loadObject($msg);
		if(!$msg){
			continue;
		}
		$database->setQuery("UPDATE `#__fb_messages` SET `hold`=0 WHERE `id`=" . $id);
		if(!$database->query()){
			$ret = 0;
		}
		FBTools::modifyCategoryStats($id, $msg->parent, $msg->time, $msg->catid);
	}
	return $ret;
}

?>