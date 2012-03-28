<?php
/**
 * @version $Id: post.php 511 2007-12-18 19:20:59Z danialt $
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
$fbConfig = FBJConfig::getInstance();
if($fbConfig->jmambot){
	class t{
		var $text = "";
	}
}
$catid = (int)$catid;
$pubwrite = (int)$pubwrite;
$ip = $_SERVER["REMOTE_ADDR"];
global $editmode;	//TODO:GoDr убрать глобальную
$editmode = 0;
$message = mosGetParam($_REQUEST, "message", null, _MOS_ALLOWRAW);
$resubject = mosGetParam($_REQUEST, "resubject", null);
$pollvopros = mosGetParam($_REQUEST, "poll");
$thispoll = mosGetParam($_REQUEST, "thispoll");
$ans1 = mosGetParam($_REQUEST, "pollvar1");
$ans2 = mosGetParam($_REQUEST, "pollvar2");
$ans3 = mosGetParam($_REQUEST, "pollvar3");
$ans4 = mosGetParam($_REQUEST, "pollvar4");
$ans5 = mosGetParam($_REQUEST, "pollvar5");

if($fbConfig->captcha == 1 && $my->id < 1){
	session_start();
	$number = $_POST['txtNumber'];
	if($message != NULL){
		if(md5($number) != $_SESSION['image_random_value']){
			$mess = _FB_CAPERR;
			echo "<script language='javascript' type='text/javascript'>alert('" . $mess . "')</script>";
			echo "<script language='javascript' type='text/javascript'>window.history.back()</script>";
			return;
			die();
		}
	}
}
$fbConfig->floodprotection = (int)$fbConfig->floodprotection;
if($fbConfig->floodprotection != 0){
	$database->setQuery("select max(time) from #__fb_messages where ip='{$ip}'");
	$lastPostTime = $database->loadResult();
}
if(($fbConfig->floodprotection != 0 && ((($lastPostTime + $fbConfig->floodprotection) < $systime) || $do == "edit" || $is_admin)) || $fbConfig->floodprotection == 0){
	if($my->id){
		$database->setQuery("SELECT name, username, email FROM #__users WHERE id={$my->id}");
		unset($user);
		$database->loadObject($user);
		if($user->email){
			$my_name = $fbConfig->username ? $user->username : $user->name;
			$my_email = $user->email;
			$registeredUser = 1;
		} else{
			echo _POST_ERROR . "<br />";
			echo _POST_EXIT;
			return;
		}
	}
} else{
	echo _POST_TOPIC_FLOOD1;
	echo $fbConfig->floodprotection . " " . _POST_TOPIC_FLOOD2 . "<br />";
	echo _POST_TOPIC_FLOOD3;
	return;
}
unset($objCatInfo);
$database->setQuery("SELECT * FROM #__fb_categories WHERE id={$catid}");
$database->loadObject($objCatInfo);
$catName = $objCatInfo->name;
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tr>
<td>
<?php
if(file_exists(JB_ABSTMPLTPATH . '/fb_pathway.php')){
	require_once (JB_ABSTMPLTPATH . '/fb_pathway.php');
} else{
	require_once (JB_ABSPATH . '/template/default/fb_pathway.php');
}
if($action == "post" && (hasPostPermission($database, $catid, $replyto, $my->id, $fbConfig->pubwrite, $is_moderator))){
	?>
<table border="0" cellspacing="1" cellpadding="3" width="70%" align="center" class="contentpane">
<tr>
<td>
	<?php
	$parent = (int)$parentid;
	if(empty($fb_authorname)){
		echo _POST_FORGOT_NAME;
	} else if(empty($subject)){
		echo _POST_FORGOT_SUBJECT;
	} ////////////////////// adeptus poll
	else if(empty($pollvopros) && $thispoll == 'yes'){
		echo _POST_FORGOT_POLL;
	} else if($ans1 == '' && $thispoll == 'yes'){
		echo _POST_FORGOT_ANS;
	} else if($ans2 == '' && $thispoll == 'yes'){
		echo _POLL_ONE_ANS;
	} ////////////////////// adeptus poll
	else if(empty($message)){
		echo _POST_FORGOT_MESSAGE;
	} else{
		if($parent == 0){
			$thread = $parent = 0;
		}
		$database->setQuery("SELECT id,thread,parent FROM #__fb_messages WHERE id={$parent}");
		unset($m);
		$database->loadObject($m);
		if(count($m) < 1){
			$parent = 0;
			$thread = 0;
		} else{
			$thread = $m->parent == 0 ? $m->id : $m->thread;
		}
		if($catid == 0){
			$catid = 1;
		}
		/////////////mfu
		if(file_exists($mosConfig_absolute_path . '/components/com_fireboard/template/default/plugin/mfu/mfu.php')) include_once ($mosConfig_absolute_path . '/components/com_fireboard/template/default/plugin/mfu/mfu.php');
		/////////////mfu
		if($attachfile != ''){
			$noFileUpload = 0;
			$GLOBALS['FB_rc'] = 1;
			include_once (JB_ABSSOURCESPATH . 'fb_file_upload.php');
			if($GLOBALS['FB_rc'] == 0){
				$noFileUpload = 1;
			}
		}
		if($attachimage != ''){
			$noImgUpload = 0;
			$GLOBALS['FB_rc'] = 1;
			include_once (JB_ABSSOURCESPATH . 'fb_image_upload.php');
			if($GLOBALS['FB_rc'] == 0){
				$noImgUpload = 1;
			}
		}
		$messagesubject = $subject;
		$fb_authorname = trim(addslashes($fb_authorname));
		$subject = trim(addslashes($subject));
		$message = trim(addslashes($message));
		$pollvopros = trim(htmlspecialchars(addslashes($pollvopros)));
		if($contentURL != "empty"){
			$message = $contentURL . '\n\n' . $message;
		}
		$email = trim(addslashes($email));
		$topic_emoticon = (int)$topic_emoticon;
		$topic_emoticon = $topic_emoticon > 9 ? 0 : $topic_emoticon;
		$posttime = FBTools::fbGetInternalTime();
		$holdPost = 0;
		if(!$is_moderator){
			$database->setQuery("SELECT review FROM #__fb_categories WHERE id={$catid}");
			$holdPost = $database->loadResult();
		}
		$duplicatetimewindow = $posttime - JB_SESSION_TIMEOUT;
		unset($existingPost);
		$database->setQuery("SELECT id FROM #__fb_messages JOIN #__fb_messages_text ON id=mesid WHERE userid={$my->id} AND name='$fb_authorname' AND email='$email' AND subject='$subject' AND ip='$ip' AND message='$message' AND time>='$duplicatetimewindow'");
		if(!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
		$database->loadObject($existingPost);
		$pid = $existingPost->id;
		//melalexs hack
		if($pid == ''){
			$database->setQuery("SELECT id, userid, time as time_p, modified_time as time_m FROM #__fb_messages WHERE thread=$thread ORDER BY time DESC LIMIT 1");
			$lastpost = $database->loadObjectList();
			if($lastpost[0]->userid == $my->id){
				$time_min_seconds = 43200;
				$time_p = $lastpost[0]->time_p + $time_min_seconds;
				$time_m = $lastpost[0]->time_m + $time_min_seconds;
				$time_e = FBTools::fbGetInternalTime();
				if($time_p > $time_e || $time_m > $time_e){
					$pid = $lastpost[0]->id;
					$newtime = date('d-m-Y H:i');
					$message = '\n\n\n[b][i][u]' . _POSTED_AT . ': ' . $newtime . '[/u][/i][/b]\n\n' . $message;
					$database->setQuery("UPDATE #__fb_messages_text SET message = CONCAT(message, '{$message}') WHERE mesid='$pid'");
					$dbr_nameset = $database->query();
					$database->setQuery("UPDATE #__fb_messages SET modified_by='$my->id', modified_time='$time_e', modified_reason='" . _POSTED_AT . "' WHERE id='$pid'");
					if($database->query() && $dbr_nameset){
						if($imageLocation != "" && !$noImgUpload){
							$database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$pid','$imageLocation')");
							if(!$database->query()){
								echo "<script> alert('Storing image failed: " . $database->getErrorMsg() . "'); </script>\n";
							}
						}
						if($fileLocation != "" && !$noFileUpload){
							$database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$pid','$fileLocation')");
							if(!$database->query()){
								echo "<script> alert('Storing file failed: " . $database->getErrorMsg() . "'); </script>\n";
							}
						}
					}
				}
			}
		}
		//melalexs hack
		if($pid == ''){
			$database->setQuery("INSERT INTO #__fb_messages (parent,thread,catid,name,userid,email,subject,time,ip,topic_emoticon,hold) VALUES('$parent','$thread','$catid','$fb_authorname','{$my->id}','$email','$subject','$posttime','$ip','$topic_emoticon','$holdPost')");
			if($database->query()){
				$pid = $database->insertId();
				if($holdPost == 0){
					FBTools::modifyCategoryStats($pid, $parent, $posttime, $catid);
				}
				$database->setQuery("INSERT INTO #__fb_messages_text (mesid,message) VALUES('$pid','$message')");
				$database->query();
				if($thread == 0){
					$database->setQuery("UPDATE #__fb_messages SET thread='$pid' WHERE id='$pid'");
					$database->query();
					////////////////// adeptus poll
					if($thispoll == 'yes'){
						$database->setQuery("INSERT INTO #__fb_polls (threadid,avtorid,vopros) VALUES ($pid,$my->id,'$pollvopros')");
						$database->query() or die(mysql_error());
						$i = $fbConfig->pollmax;
						if($ans1 != '' && $i != 0){
							$database->setQuery("INSERT INTO #__fb_pollsotvet (poll_id,pollotvet) VALUES ($pid,'$ans1')");
							$database->query() or die(mysql_error());
							$i = $i - 1;
						}
						if($ans2 != '' && $i != 0){
							$database->setQuery("INSERT INTO #__fb_pollsotvet (poll_id,pollotvet) VALUES ($pid,'$ans2')");
							$database->query() or die(mysql_error());
							$i = $i - 1;
						}
						if($ans3 != '' && $i != 0){
							$database->setQuery("INSERT INTO #__fb_pollsotvet (poll_id,pollotvet) VALUES ($pid,'$ans3')");
							$database->query() or die(mysql_error());
							$i = $i - 1;
						}
						if($ans4 != '' && $i != 0){
							$database->setQuery("INSERT INTO #__fb_pollsotvet (poll_id,pollotvet) VALUES ($pid,'$ans4')");
							$database->query() or die(mysql_error());
							$i = $i - 1;
						}
						if($ans5 != '' && $i != 0){
							$database->setQuery("INSERT INTO #__fb_pollsotvet (poll_id,pollotvet) VALUES ($pid,'$ans5')");
							$database->query() or die(mysql_error());
							$i = $i - 1;
						}
					}
					////////////////// adeptus poll
				}
				if($my->id){
					$database->setQuery("UPDATE #__fb_users SET posts=posts+1 WHERE userid={$my->id}");
					$database->query();
				}
				if($imageLocation != "" && !$noImgUpload){
					$database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$pid','$imageLocation')");
					if(!$database->query()){
						echo "<script> alert('Storing image failed: " . $database->getErrorMsg() . "'); </script>\n";
					}
				}
				if($fileLocation != "" && !$noFileUpload){
					$database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$pid','$fileLocation')");

					if(!$database->query()){
						echo "<script> alert('Storing file failed: " . $database->getErrorMsg() . "'); </script>\n";
					}
				}
				if($fbConfig->allowsubscriptions == 1){
					if($thread == 0){
						$querythread = $pid;
					} else{
						$querythread = $thread;
					}
					$mailmessage = smile::purify($message);
					$database->setQuery("SELECT * FROM #__fb_subscriptions AS a" . "\n LEFT JOIN #__users as u ON a.userid=u.id " . "\n WHERE a.thread= {$querythread}");
					$subsList = $database->loadObjectList();
					$messageUrl = sefRelToAbs(JB_LIVEURLREL . "&func=view&catid=$catid&id=$pid") . "#$pid";
					if(count($subsList) > 0){
						require_once (JB_ABSSOURCESPATH . 'fb_mail.php');
						foreach($subsList as $subs){
							$mailsubject = "$_COM_A_NOTIFICATION " . _GEN_SUBJECT . ": '" . stripslashes($messagesubject) . "' " . _FB_IN_FORUM . " '" . stripslashes($catName) . "'";
							$msg = "$subs->name,\n";
							$msg .= "$_COM_A_NOTIFICATION1 $board_title " . _FB_FORUM . "\n";
							$msg .= _GEN_SUBJECT . ": '" . stripslashes($messagesubject) . "' " . _FB_IN_FORUM . " '" . stripslashes($catName) . "'\n";
							$msg .= _VIEW_POSTED . ": " . stripslashes($fb_authorname) . "\n\n";
							$msg .= "$_COM_A_NOTIFICATION2\n";
							$msg .= "URL: $messageUrl\n\n";
							if($fbConfig->mailfull == 1){
								$msg .= _GEN_MESSAGE . ":\n";
								$msg .= stripslashes($mailmessage);
							}
							$msg .= "\n\n";
							$msg .= "$_COM_A_NOTIFICATION3\n";
							$msg .= "\n\n\n\n\n";
							$msg .= "** Русская редакция FireBoard **\n";
							$msg .= "** Adeptus http://www.adeptsite.info **";
							if($ip != "127.0.0.1" && $my->id != $subs->id){
								mosmail($fbConfig->email, _FB_FORUM_AT . " " . $_SERVER['SERVER_NAME'], $subs->email, $mailsubject, $msg);
							}
						}
					}
				}
				if($fbConfig->mailmod == '1' || $fbConfig->mailadmin == '1'){
					$sql = "SELECT * FROM #__users AS u";
					if($fbConfig->mailmod == 1){
						$sql .= "\n LEFT JOIN #__fb_moderation AS a";
						$sql .= "\n ON a.userid=u.id";
						$sql .= "\n  AND a.catid=$catid";
					}
					$sql .= "\n WHERE 1=1";
					$sql .= "\n AND (";
					$sql2 = '';
					if($fbConfig->mailmod == 1){
						$sql2 .= " a.userid IS NOT NULL";
					}
					if($fbConfig->mailadmin == 1){
						if(strlen($sql2)){
							$sql2 .= "\n  OR ";
						}
						$sql2 .= " u.sendEmail=1";
					}
					$sql .= "\n" . $sql2;
					$sql .= "\n)";
					$database->setQuery($sql);
					$modsList = $database->loadObjectList();
					if(count($modsList) > 0){
						require_once (JB_ABSSOURCESPATH . 'fb_mail.php');
						foreach($modsList as $mods){
							$mailsubject = "$_COM_A_NOTIFICATION " . _GEN_SUBJECT . ": '" . stripslashes($messagesubject) . "' " . _FB_IN_FORUM . " '" . stripslashes($catName) . "'";
							$msg = "$mods->name,\n";
							$msg .= "$_COM_A_NOT_MOD1 $board_title " . _FB_FORUM . "\n";
							$msg .= _GEN_SUBJECT . ": '" . stripslashes($messagesubject) . "' " . _FB_IN_FORUM . " '" . stripslashes($catName) . "'\n";
							$msg .= _VIEW_POSTED . ": " . stripslashes($fb_authorname) . "\n\n";
							$msg .= "$_COM_A_NOT_MOD2\n";
							$msg .= "URL: $messageUrl\n\n";
							if($fbConfig->mailfull == 1){
								$msg .= _GEN_MESSAGE . ":\n";
								$msg .= stripslashes($mailmessage);
							}
							$msg .= "\n\n";
							$msg .= "$_COM_A_NOTIFICATION3\n";
							$msg .= "\n\n\n\n\n";
							$msg .= "** Русская редакция FireBoard **\n";
							$msg .= "** Adeptus - http://www.adeptsite.info **";
							if($ip != "127.0.0.1" && $my->id != $mods->id){ //don't mail yourself
								mosmail($fbConfig->email, "Форум на " . $_SERVER['SERVER_NAME'], $mods->email, $mailsubject, $msg);
							}
						}
					}
				}
				if($subscribeMe == 1){
					if($thread == 0){
						$fb_thread = $pid;
					} else{
						$fb_thread = $thread;
					}
					$database->setQuery("INSERT INTO #__fb_subscriptions (thread,userid) VALUES ('$fb_thread','{$my->id}')");
					if($database->query()){
						echo _POST_SUBSCRIBED_TOPIC . "<br /><br />";
					} else{
						echo _POST_NO_SUBSCRIBED_TOPIC . "<br /><br />";
					}
				}
				if($holdPost == 1){
					echo _POST_SUCCES_REVIEW . ' <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _GEN_CONTINUE . '</a>.';
				} else{
					?>
				<script language="javascript">
					document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $pid) . '#' . $pid;?>';
				</script>
					<?php
				}
			} else{
				echo _POST_ERROR_MESSAGE;
			}
		} else{
			?>
		<script language="javascript">
			document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $pid) . '#' . $pid;?>';
		</script>
			<?php
		}
	}
	?>
</td>
</tr>
</table>
	<?php
} else if($action == "cancel"){
	?>
<script language="javascript">
	document.location = '<?php echo sefRelToAbs(str_replace('&amp;', '&', JB_LIVEURLREL) . '&func=view&catid=' . $catid . '&id=' . $pid) . '#' . $pid;?>';
</script>
	<?php
} else{
	if($do == "quote" && (hasPostPermission($database, $catid, $replyto, $my->id, $fbConfig->pubwrite, $is_moderator))){
		$parentid = 0;
		$replyto = (int)$replyto;
		if($replyto > 0){
			$database->setQuery("SELECT #__fb_messages.*,#__fb_messages_text.message FROM #__fb_messages,#__fb_messages_text WHERE id={$replyto} AND mesid={$replyto}");
			$database->query();

			if($database->getNumRows() > 0){
				unset($message);
				$database->loadObject($message);
				$quote = $message->message;
				$quote = preg_replace('/\[hide(.*?)\](.*?)\[\/hide\]/s', _AFB_HIDDEN_REPLY, $quote);
				$htmlText = "[b]" . stripslashes($message->name) . " " . _POST_WROTE . ":[/b]\n";
				$htmlText .= '[quote]' . $quote . "[/quote]\n";
				$table = array_flip(get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES));
				$resubject = htmlspecialchars(strtr($message->subject, $table));
				$resubject = strtolower(substr($resubject, 0, strlen(_POST_RE))) == strtolower(_POST_RE) ? stripslashes($resubject) : _POST_RE . stripslashes($resubject);
				$parentid = $message->id;
				$authorName = $my_name;
			}
		}
		?>
                    <form action="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=post'); ?>" method="post" name="postform" enctype="multipart/form-data">
                        <input type="hidden" name="parentid" value="<?php echo $parentid;?>"/>
	<input type="hidden" name="catid" value="<?php echo $catid;?>"/>
	<input type="hidden" name="action" value="post"/>
	<input type="hidden" name="contentURL" value="empty"/>
	<input type="hidden" name="thispoll" value="no"/>
		<?php
		$no_upload = "0";
		if(file_exists(JB_ABSTMPLTPATH . '/fb_write.html.php')){
			include (JB_ABSTMPLTPATH . '/fb_write.html.php');
		} else{
			include (JB_ABSPATH . '/template/default/fb_write.html.php');
		}
	} ///////////////// adeptus poll
	else if($do == "poll" && (hasPostPermission($database, $catid, $replyto, $my->id, $fbConfig->pubwrite, $is_moderator))){
		$authorName = $my_name;
		?>
					<form action="<?php echo sefRelToAbs(JB_LIVEURL . '&amp;func=post'); ?>" method="post" name="postform" enctype="multipart/form-data">
                    	<input type="hidden" name="parentid" value="<?php echo $parentid;?>"/>
	<input type="hidden" name="catid" value="<?php echo $catid;?>"/>
	<input type="hidden" name="action" value="post"/>
	<input type="hidden" name="contentURL" value="empty"/>
	<input type="hidden" name="thispoll" value="yes"/>
		<?php
		$no_upload = "0";
		if(file_exists(JB_ABSTMPLTPATH . '/fb_write_poll.html.php')){
			include(JB_ABSTMPLTPATH . '/fb_write_poll.html.php');
		} else{
			include(JB_ABSPATH . '/template/default/fb_write_poll.html.php');
		}
	} ///////////////// adeptus poll
	else if($do == "reply" && (hasPostPermission($database, $catid, $replyto, $my->id, $fbConfig->pubwrite, $is_moderator))){
		$parentid = 0;
		$replyto = (int)$replyto;
		$setFocus = 0;
		if($replyto > 0){
			$database->setQuery('SELECT #__fb_messages.*,#__fb_messages_text.message' . "\n" . 'FROM #__fb_messages,#__fb_messages_text' . "\n" . 'WHERE id=' . $replyto . ' AND mesid=' . $replyto);
			$database->query();
			if($database->getNumRows() > 0){
				unset($message);
				$database->loadObject($message);
				$table = array_flip(get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES));
				$resubject = htmlspecialchars(strtr($message->subject, $table));
				$resubject = strtolower(substr($resubject, 0, strlen(_POST_RE))) == strtolower(_POST_RE) ? stripslashes($resubject) : _POST_RE . stripslashes($resubject);
				$parentid = $message->id;
				$htmlText = "";
			}
		}
		$authorName = $my_name;
		?>
                    <form action="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=post'); ?>" method="post" name="postform" enctype="multipart/form-data">
                        <input type="hidden" name="parentid" value="<?php echo $parentid;?>"/>
	<input type="hidden" name="catid" value="<?php echo $catid;?>"/>
	<input type="hidden" name="action" value="post"/>
	<input type="hidden" name="contentURL" value="empty"/>
		<?php
		$no_upload = "0";
		if(file_exists(JB_ABSTMPLTPATH . '/fb_write.html.php')){
			include (JB_ABSTMPLTPATH . '/fb_write.html.php');
		} else{
			include (JB_ABSPATH . '/template/default/fb_write.html.php');
		}
	} else if($do == "newFromBot" && (hasPostPermission($database, $catid, $replyto, $my->id, $fbConfig->pubwrite, $is_moderator))){
		$parentid = 0;
		$replyto = (int)$replyto;
		$setFocus = 0;
		$resubject = base64_decode(strtr($resubject, "()", "+/"));
		$resubject = str_replace("%20", " ", $resubject);
		$resubject = preg_replace('/%32/', '&', $resubject);
		$resubject = preg_replace('/%33/', ';', $resubject);
		$resubject = preg_replace("/\'/", '&#039;', $resubject);
		$resubject = preg_replace("/\"/", '&quot;', $resubject);
		$fromBot = 1;
		$authorName = htmlspecialchars($my_name);
		$rowid = mosGetParam($_REQUEST, 'rowid', 0);
		$rowItemid = mosGetParam($_REQUEST, 'rowItemid', 0);
		if($rowItemid){
			$contentURL = sefRelToAbs('index.php?option=com_content&amp;task=view&amp;Itemid=' . $rowItemid . '&amp;id=' . $rowid);
		} else{
			$contentURL = sefRelToAbs('index.php?option=com_content&amp;task=view&amp;Itemid=1&amp;id=' . $rowid);
		}
		$contentURL = _POST_DISCUSS . ': [url=' . $contentURL . ']' . $resubject . '[/url]';
		?>
                    <form action="<?php echo sefRelToAbs(JB_LIVEURLREL . "&amp;func=post");?>" method="post" name="postform" enctype="multipart/form-data">
                        <input type="hidden" name="parentid" value="<?php echo $parentid;?>"/>
	<input type="hidden" name="catid" value="<?php echo $catid;?>"/>
	<input type="hidden" name="action" value="post"/>
	<input type="hidden" name="contentURL" value="<?php echo $contentURL;?>"/>
		<?php
		$no_upload = "0"; //only edit mode should disallow this
		if(file_exists(JB_ABSTMPLTPATH . '/fb_write.html.php')){
			include (JB_ABSTMPLTPATH . '/fb_write.html.php');
		} else{
			include (JB_ABSPATH . '/template/default/fb_write.html.php');
		}
	} else if($do == "edit"){
		$allowEdit = 0;
		$id = (int)$id;
		$database->setQuery("SELECT * FROM #__fb_messages LEFT JOIN #__fb_messages_text ON #__fb_messages.id=#__fb_messages_text.mesid WHERE #__fb_messages.id=$id");
		$message1 = $database->loadObjectList();
		$mes = $message1[0];
		$userID = $mes->userid;
		if($is_moderator){
			$allowEdit = 1;
		}

		if($fbConfig->useredit == 1 && $my->id != ""){
			if($my->id == $userID){
				if(((int)$fbConfig->usereditTime) == 0){
					$allowEdit = 1;
				} else{
					$modtime = $mes->modified_time;
					if(!$modtime){
						$modtime = $mes->time;
					}
					if(($modtime + ((int)$fbConfig->usereditTime)) >= FBTools::fbGetInternalTime()){
						$allowEdit = 1;
					}
				}
			}
		}
		if($allowEdit == 1){
			$editmode = 1;
			$htmlText = $mes->message;
			$table = array_flip(get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES));
			$resubject = htmlspecialchars(stripslashes($mes->subject));
			$authorName = htmlspecialchars($mes->name);
			?>
		<form action="<?php echo sefRelToAbs(JB_LIVEURLREL . "&amp;catid=$catid&amp;func=post"); ?>" method="post" name="postform" enctype="multipart/form-data"/>
		<input type="hidden" name="id" value="<?php echo $mes->id;?>"/>
		<input type="hidden" name="do" value="editpostnow"/>
			<?php
			$no_file_upload = 0;
			$no_image_upload = 0;
			$database->setQuery("SELECT filelocation FROM #__fb_attachments WHERE mesid='$id'");
			$attachments = $database->loadObjectList();
			if(count($attachments > 0)){
				foreach($attachments as $att){
					if(preg_match("&/fbfiles/files/&si", $att->filelocation)){
						$no_file_upload = "1";
					}
					if(preg_match("&/fbfiles/images/&si", $att->filelocation)){
						$no_image_upload = "1";
					}
				}
			} else{
				$no_upload = "0";
			}

			if(file_exists(JB_ABSTMPLTPATH . '/fb_write.html.php')){
				include (JB_ABSTMPLTPATH . '/fb_write.html.php');
			} else{
				include (JB_ABSPATH . '/template/default/fb_write.html.php');
			}
		} else{
			echo "Hacking attempt!";
		}
	} else if($do == "editpostnow"){
		$modified_reason = addslashes(mosGetParam($_POST, "modified_reason", null));
		$modified_by = $my->id;
		$modified_time = FBTools::fbGetInternalTime();
		$id = (int)$id;
		$database->setQuery("SELECT * FROM #__fb_messages LEFT JOIN #__fb_messages_text ON #__fb_messages.id=#__fb_messages_text.mesid WHERE #__fb_messages.id=$id");
		$message1 = $database->loadObjectList();
		$mes = $message1[0];
		$userid = $mes->userid;
		if($is_moderator){
			$allowEdit = 1;
		}

		if($fbConfig->useredit == 1 && $my->id != ""){
			if($my->id == $userid){
				if(((int)$fbConfig->usereditTime) == 0){
					$allowEdit = 1;
				} else{
					$modtime = $mes->modified_time;
					if(!$modtime){
						$modtime = $mes->time;
					}
					if(($modtime + ((int)$fbConfig->usereditTime) + ((int)$fbConfig->usereditTimeGrace)) >= FBTools::fbGetInternalTime()){
						$allowEdit = 1;
					}
				}
			}
		}
		if($allowEdit == 1){
			if($attachfile != ''){
				include JB_ABSSOURCESPATH . 'fb_file_upload.php';
			}
			if($attachimage != ''){
				include JB_ABSSOURCESPATH . 'fb_image_upload.php';
			}
			$message = trim(addslashes($message));
			if(count($message1) > 0){
				$database->setQuery("UPDATE #__fb_messages SET name='$fb_authorname', email='" . addslashes($email) . (($fbConfig->editMarkUp) ? "' ,modified_by='" . $modified_by . "' ,modified_time='" . $modified_time . "' ,modified_reason='" . $modified_reason : "") . "', subject='" . addslashes($subject) . "', topic_emoticon='" . ((int)$topic_emoticon) . "' WHERE id={$id}");
				$dbr_nameset = $database->query();
				$database->setQuery("UPDATE #__fb_messages_text SET message='{$message}' WHERE mesid={$id}");
				if($database->query() && $dbr_nameset){
					if($imageLocation != ""){
						$database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$id','$imageLocation')");
						if(!$database->query()){
							echo "<script> alert('Storing image failed: " . $database->getErrorMsg() . "'); </script>\n";
						}
					}
					if($fileLocation != ""){
						$database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$id','$fileLocation')");
						if(!$database->query()){
							echo "<script> alert('Storing file failed: " . $database->getErrorMsg() . "'); </script>\n";
						}
					}
					//echo '<div align="center">' . _POST_SUCCESS_EDIT . '<br /><br />';
					//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
					//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
					//echo '</div>';
					?>
				<script language="javascript">
					document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id) . '#' . $id;?>';
					//setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id) . '#' . $id;?>'", 3500);
				</script>
					<?php
				} else{
					echo _POST_ERROR_MESSAGE_OCCURED;
				}
			} else{
				echo _POST_INVALID;
			}
		} else{
			echo ("Hacking attempt");
		}
	} else if($do == "delete"){
		if(!$is_moderator){
			die ("Hacking Attempt!");
		}
		$id = (int)$id;
		$database->setQuery("SELECT * FROM #__fb_messages WHERE id=$id");
		$message = $database->loadObjectList();
		foreach($message as $mes){
			?>
		<form action="<?php echo sefRelToAbs(JB_LIVEURLREL . "&amp;catid=$catid&amp;func=post"); ?>" method="post" name="myform">
			<input type="hidden" name="do" value="deletepostnow"/>
			<input type="hidden" name="id" value="<?php echo $mes->id;?>"/> <?php echo _POST_ABOUT_TO_DELETE; ?>: <strong><?php echo stripslashes(htmlspecialchars($mes->subject)); ?></strong>.
			<br/>
			<br/> <?php echo _POST_ABOUT_DELETE; ?><br/>
			<br/>
			<input type="checkbox" checked name="delAttachments" value="delAtt"/> <?php echo _POST_DELETE_ATT; ?>
			<br/>
			<br/>
			<a href="javascript:document.myform.submit();"><?php echo _GEN_CONTINUE; ?></a> | <a href="<?php echo sefRelToAbs(JB_LIVEURLREL . "&amp;func=view&amp;catid=$catid;&amp;id=$id");?>"><?php echo _GEN_CANCEL; ?></a>
		</form>
			<?php
		}
	} else if($do == "deletepostnow"){
		if(!$is_moderator){
			die ("Hacking Attempt!");
		}
		$id = (int)mosGetParam($_POST, 'id', '');
		$dellattach = mosGetParam($_POST, 'delAttachments', '') == 'delAtt' ? 1 : 0;
		$thread = fb_delete_post($database, $id, $dellattach);
		switch($thread){
			case -1:
				echo _POST_ERROR_TOPIC . '<br />';

				echo _FB_POST_DEL_ERR_CHILD;
				break;
			case -2:
				echo _POST_ERROR_TOPIC . '<br />';
				echo _FB_POST_DEL_ERR_MSG;
				break;
			case -3:
				echo _POST_ERROR_TOPIC . '<br />';
				$tmpstr = _FB_POST_DEL_ERR_TXT;
				$tmpstr = str_replace('%id%', $id, $tmpstr);
				echo $tmpstr;
				break;
			case -4:
				echo _POST_ERROR_TOPIC . '<br />';
				echo _FB_POST_DEL_ERR_USR;
				break;
			case -5:
				echo _POST_ERROR_TOPIC . '<br />';
				echo _AFB_POLLNODEL;
				break;
			default:
				echo '<div align="center">' . _POST_SUCCESS_DELETE . '<br /><br />';
				echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
				echo '</div>';
				echo '<script language="javascript">';
				if($do == 'deletetopicnow'){
					echo 'setTimeout("location=\'' . sefRelToAbs(JB_LIVEURLREL . '&func=showcat&catid=' . $catid) . '\'",1)';
				} else{
					echo 'setTimeout("location=\'' . sefRelToAbs(JB_LIVEURLREL . '&func=showcat&catid=' . $catid) . '\'",1)';
				}
				echo '</script>';
				break;
		}
	} else if($do == "move"){
		if(!$is_moderator){
			die ("Hacking Attempt!");
		}
		$catid = (int)$catid;
		$id = (int)$id;
		$database->setQuery("SELECT a.*, b.name AS category" . "\nFROM #__fb_categories AS a" . "\nLEFT JOIN #__fb_categories AS b ON b.id = a.parent" . "\nWHERE a.parent != '0'" . "\nORDER BY parent, ordering");
		$catlist = $database->loadObjectList();
		$database->setQuery("select subject from #__fb_messages where id=$id");
		$topicSubject = $database->loadResult();
		?>
	<form action="<?php echo sefRelToAbs(JB_LIVEURLREL . "&amp;func=post"); ?>" method="post" name="myform">
		<input type="hidden" name="do" value="domovepost"/>
		<input type="hidden" name="id" value="<?php echo $id;?>"/>

		<p>
			<?php echo _GEN_TOPIC; ?>: <strong><?php echo $topicSubject; ?></strong>
			<br/>
			<br/> <?php echo _POST_MOVE_TOPIC; ?>:
			<br/>
			<select name="catid" size="15" class="fb_move_selectbox">
				<?php
				foreach($catlist as $cat){
					echo "<OPTION value=\"$cat->id\" > $cat->category/$cat->name </OPTION>";
				}
				?>
			</select>
			<br/>
			<input type="checkbox" checked name="leaveGhost" value="1"/> <?php echo _POST_MOVE_GHOST; ?>
			<br/>
			<input type="submit" class="button" value="<?php echo _GEN_MOVE;?>"/>
	</form>
		<?php
	} else if($do == "domovepost"){
		if(!$is_moderator){
			die ("Hacking Attempt!");
		}
		$catid = (int)$catid;
		$id = (int)$id;
		$bool_leaveGhost = (int)mosGetParam($_POST, 'leaveGhost', 0);
		$database->setQuery("SELECT `subject`, `catid`, `time` AS timestamp FROM #__fb_messages WHERE `id`='$id'");
		$oldRecord = $database->loadObjectList();
		$newSubject = _MOVED_TOPIC . " " . $oldRecord[0]->subject;
		$database->setQuery("SELECT MAX(time) AS timestamp FROM #__fb_messages WHERE `thread`='$id'");
		$lastTimestamp = $database->loadResult();
		if($lastTimestamp == ""){
			$lastTimestamp = $oldRecord[0]->timestamp;
		}
		$database->setQuery("UPDATE #__fb_messages SET `catid`='$catid' WHERE `id`='$id'");
		if($database->query()){
			$database->setQuery("UPDATE #__fb_messages set `catid`='$catid' WHERE `thread`='$id'");
			if($database->query()){
				if($bool_leaveGhost){
					$database->setQuery("INSERT INTO #__fb_messages (`parent`, `subject`, `time`, `catid`, `moved`) VALUES ('0','$newSubject','" . $lastTimestamp . "','" . $oldRecord[0]->catid . "','1')");
					if($database->query()){
						$newId = $database->insertid();
						$newURL = "catid=" . $catid . "&amp;id=" . $id;
						$database->setQuery("INSERT INTO #__fb_messages_text (`mesid`, `message`) VALUES ('$newId', '$newURL')");
						if(!$database->query()){
							$database->stderr(true);
						}
						$database->setQuery("UPDATE #__fb_messages SET `thread`='$newId' WHERE `id`='$newId'");
						if(!$database->query()){
							$database->stderr(true);
						}
					} else{
						echo '<p style="text-align:center">' . _POST_GHOST_FAILED . '</p>';
					}
				}
				//echo '<div align="center">' . _POST_SUCCESS_MOVE . '<br /><br />';
				//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
				//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
				//echo '</div>';
				?>
			<script language="javascript">
				document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id); ?>';
				//setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id); ?>'", 3500);
			</script>
				<?php
			} else{
				echo _FB_POST_MOV_ERR_DB;
			}
		} else{
			echo _POST_TOPIC_NOT_MOVED; ?>
		<a href="<?php echo sefRelToAbs(JB_LIVEURLREL . "&amp;func=view&amp;catid=$catid&amp;id=$id");?>"><?php echo _POST_CLICK; ?></a>
			<?php
		}
	} else if($do == "subscribe"){
		$catid = (int)$catid;
		$id = (int)$id;
		$database->setQuery("INSERT INTO #__fb_subscriptions (thread,userid) VALUES ('$fb_thread','$my->id')");
		if($database->query()){
			echo _POST_SUBSCRIBED_TOPIC . "<br /><br />";
		} else{
			echo _POST_NO_SUBSCRIBED_TOPIC . "<br /><br />";
		}
		//echo '<div align="center">' . _POST_SUCCESS_SUBSCRIBE . '<br /><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '">' . _POST_SUCCESS_VIEW . '</a><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
		//echo '</div>';
		?>
	<script language="javascript">
		document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=userprofile&do=show'); ?>';
		//setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=userprofile&do=show'); ?>'", 3500);
	</script>
		<?php
	} else if($do == "favorite"){
		$catid = (int)$catid;
		$id = (int)$id;
		$database->setQuery("INSERT INTO #__fb_favorites (thread,userid) VALUES ('$fb_thread','$my->id')");
		if($database->query()){
			echo _POST_FAVORITED_TOPIC . "<br /><br />";
		} else{
			echo _POST_NO_FAVORITED_TOPIC . "<br /><br />";
		}
		//echo '<div align="center">' . _POST_SUCCESS_FAVORITE . '<br /><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '">' . _POST_SUCCESS_VIEW . '</a><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
		//echo '</div>';
		?>
	<script language="javascript">
		document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=userprofile&do=show'); ?>';
		//setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=userprofile&do=show'); ?>'", 3500);
	</script>
		<?php
	} else if($do == "sticky"){
		if(!$is_moderator){
			die ("Hacking Attempt!");
		}
		$database->setQuery("update #__fb_messages set ordering=1 where id=$id");
		if($database->query()){
			echo '<p align="center">' . _POST_STICKY_SET . '<br /><br />';
		} else{
			echo '<p align="center">' . _POST_STICKY_NOT_SET . '<br /><br />';
		}
		//echo '<div align="center">' . _POST_SUCCESS_REQUEST2 . '<br /><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
		//echo '</div>';
		?>
	<script language="javascript">
		document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id);?>';
		//setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id);?>'", 3500);
	</script>
		<?php
	} else if($do == "unsticky"){
		if(!$is_moderator){
			die ("Hacking Attempt!");
		}
		$database->setQuery("update #__fb_messages set ordering=0 where id=$id");
		if($database->query()){
			echo '<p align="center">' . _POST_STICKY_UNSET . '<br /><br />';
		} else{
			echo '<p align="center">' . _POST_STICKY_NOT_UNSET . '<br /><br />';
		}
		//echo '<div align="center">' . _POST_SUCCESS_REQUEST2 . '<br /><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
		//echo '</div>';
		?>
	<script language="javascript">
		document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id);?>';
		//setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id);?>'", 3500);
	</script>
		<?php
	} else if($do == "lock"){
		if(!$is_moderator){
			die ("Hacking Attempt!");
		}
		$database->setQuery("update #__fb_messages set locked=1 where id=$id");
		if($database->query()){
			echo '<p align="center">' . _POST_LOCK_SET . '<br /><br />';
		} else{
			echo '<p align="center">' . _POST_LOCK_NOT_SET . '<br /><br />';
		}
		//echo '<div align="center">' . _POST_SUCCESS_REQUEST2 . '<br /><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
		//echo '</div>';
		?>
	<script language="javascript">
		document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id);?>';
		//setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id);?>'", 3500);
	</script>
		<?php
	} else if($do == "unlock"){
		if(!$is_moderator){
			die ("Hacking Attempt!");
		}
		$database->setQuery("update #__fb_messages set locked=0 where id=$id");

		if($database->query()){
			echo '<p align="center">' . _POST_LOCK_UNSET . '<br /><br />';
		} else{
			echo '<p align="center">' . _POST_LOCK_NOT_UNSET . '<br /><br />';
		}
		//echo '<div align="center">' . _POST_SUCCESS_REQUEST2 . '<br /><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
		//echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
		//echo '</div>';
		?>
	<script language="javascript">
		document.location = '<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id);?>';
		//setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL . '&func=view&catid=' . $catid . '&id=' . $id);?>'", 3500);
	</script>
		<?php
	}
}
?>
</td>
</tr>
</table>
<?php
function hasPostPermission($database, $catid, $replyto, $userid, $pubwrite, $ismod){
	$fbConfig = FBJConfig::getInstance();
	if($replyto != 0){
		$database->setQuery("select thread from #__fb_messages where id='$replyto'");
		$topicID = $database->loadResult();
		$lockedWhat = _GEN_TOPIC;
		if($topicID != 0){
			$sql = 'select locked from #__fb_messages where id=' . $topicID;
		} else{
			$sql = 'select locked from #__fb_messages where id=' . $replyto;
		}
		$database->setQuery($sql);
		$topicLock = $database->loadResult();
	}
	if($topicLock == 0){
		$database->setQuery("select locked from #__fb_categories where id=$catid");
		$topicLock = $database->loadResult();
		$lockedWhat = _GEN_FORUM;
	}
	if(($userid != 0 || $pubwrite) && ($topicLock == 0 || $ismod)){
		return 1;
	} else{
		if($pubwrite){
			echo "<p align=\"center\">$lockedWhat " . _POST_LOCKED . "<br />";
			echo _POST_NO_NEW . "<br /><br /></p>";
		} else{
			echo "<p align=\"center\">";
			echo _POST_NO_PUBACCESS1 . "<br />";
			echo _POST_NO_PUBACCESS2 . "<br /><br />";
			if($fbConfig->cb_profile){
				echo '<a href="' . sefRelToAbs('index.php?option=com_comprofiler&amp;task=registers') . '">' . _POST_NO_PUBACCESS3 . '</a><br /></p>';
			} else{
				echo '<a href="' . sefRelToAbs('index.php?option=com_users&amp;task=register') . '">' . _POST_NO_PUBACCESS3 . '</a><br /></p>';
			}
		}
		return 0;
	}
}

function fb_delete_post(&$database, $id, $dellattach){
	$database->setQuery('SELECT id,catid,parent,thread,subject,userid FROM #__fb_messages WHERE id=' . $id);
	if(!$database->query()){
		return -2;
	}
	unset($mes);
	$database->loadObject($mes);
	$thread = $mes->thread;
	if($mes->parent == 0){
		$database->setQuery('DELETE FROM #__fb_polls WHERE threadid=' . $thread);
		$database->query();
		$database->setQuery('DELETE FROM #__fb_pollsotvet WHERE poll_id=' . $thread);
		$database->query();
		$database->setQuery('DELETE FROM #__fb_pollsresults WHERE threadid=' . $thread);
		$database->query();
		$children = array();
		$userids = array();
		$database->setQuery('SELECT userid,id, catid FROM #__fb_messages WHERE thread=' . $id . ' OR id=' . $id);
		foreach($database->loadObjectList() as $line){
			$children[] = $line->id;
			if($line->userid > 0){
				$userids[] = $line->userid;
			}
		}
		$children = implode(',', $children);
		$userids = implode(',', $userids);
	} else{
		$database->setQuery('UPDATE #__fb_messages SET parent=\'' . $mes->parent . '\' WHERE parent=\'' . $id . '\'');
		if(!$database->query()){
			return -1;
		}
		$children = $id;
		$userids = $mes->userid > 0 ? $mes->userid : '';
	}
	$database->setQuery('DELETE FROM #__fb_messages WHERE id=' . $id . ' OR thread=' . $id);
	if(!$database->query()){
		return -2;
	}
	FBTools::decreaseCategoryStats($id, $mes->catid);
	$database->setQuery('DELETE FROM #__fb_messages_text WHERE mesid IN (' . $children . ')');
	if(!$database->query()){
		return -3;
	}
	if(count($userids) > 0){
		$database->setQuery('UPDATE #__fb_users SET posts=posts-1 WHERE userid IN (' . $userids . ')');
		if(!$database->query()){
			return -4;
		}
	}
	$database->setQuery('SELECT mesid FROM #__fb_messages_text WHERE message=\'catid=' . $mes->catid . '&amp;id=' . $id . '\'');
	$int_ghost_id = $database->loadResult();
	if($int_ghost_id > 0){
		$database->setQuery('DELETE FROM #__fb_messages WHERE id=' . $int_ghost_id);
		$database->query();
		$database->setQuery('DELETE FROM #__fb_messages_text WHERE mesid=' . $int_ghost_id);
		$database->query();
	}
	if($dellattach){
		$database->setQuery('SELECT filelocation FROM #__fb_attachments WHERE mesid IN (' . $children . ')');
		$fileList = $database->loadObjectList();
		if(count($fileList) > 0){
			foreach($fileList as $fl){
				unlink($fl->filelocation);
			}
			$database->setQuery('DELETE FROM #__fb_attachments WHERE mesid IN (' . $children . ')');
			$database->query();
		}
	}
	return $thread;
}

function listThreadHistory($id, $fbConfig, $database){
	if($id != 0){
		$database->setQuery("SELECT parent FROM #__fb_messages WHERE id='$id'");
		$this_message_parent = $database->loadResult();
		$database->setQuery("SELECT thread FROM #__fb_messages WHERE id='$id'");
		$this_message_thread = $database->loadResult();
		if($this_message_parent == 0){
			$thread = $id;
		} else{
			$thread = $this_message_thread;
		}
		$database->setQuery("SELECT * FROM #__fb_messages LEFT JOIN #__fb_messages_text ON #__fb_messages.id=#__fb_messages_text.mesid WHERE thread='$thread' OR id='$thread' AND hold = 0 ORDER BY time DESC LIMIT " . $fbConfig->historyLimit);
		$messages = $database->loadObjectList();
		$database->setQuery("SELECT subject FROM #__fb_messages WHERE id='$thread' and parent=0");
		$this_message_subject = $database->loadResult();
		echo "<b>" . _POST_TOPIC_HISTORY . ":</b> " . stripslashes(htmlspecialchars($this_message_subject)) . " <br />" . _POST_TOPIC_HISTORY_MAX . " " . $fbConfig->historyLimit . " " . _POST_TOPIC_HISTORY_LAST . "<br />";
		?>
	<table border="0" cellspacing="1" cellpadding="3" width="100%" class="fb_review_table">
		<tr>
			<td class="fb_review_header" width="20%" align="center">
				<strong><?php echo _GEN_AUTHOR; ?></strong>
			</td>

			<td class="fb_review_header" align="center">
				<strong><?php echo _GEN_MESSAGE; ?></strong>
			</td>
		</tr>
		<?php
		$k = 0;
		$smileyList = smile::getEmoticons(1);
		foreach($messages as $mes){
			$k = 1 - $k;
			$mes->name = htmlspecialchars($mes->name);
			$mes->email = htmlspecialchars($mes->email);
			$mes->subject = htmlspecialchars($mes->subject);
			$fb_message_txt = stripslashes(($mes->message));
			$fb_message_txt = smile::smileReplace($fb_message_txt, 1, $fbConfig->disemoticons, $smileyList);
			?>
			<tr>
				<td class="fb_review_body<?php echo $k;?>" valign="top">
					<?php echo stripslashes($mes->name); ?>
				</td>
				<td class="fb_review_body<?php echo $k;?>">
					<?php
					$fb_message_txt = str_replace("</P><br />", "</P>", $fb_message_txt);
					$fb_message_txt = smile::htmlwrap($fb_message_txt, $fbConfig->wrap);
					if($fbConfig->jmambot){
						$_MAMBOTS = mosMambotHandler::getInstance();
						$row = new t();
						$row->text = $fb_message_txt;
						$_MAMBOTS->loadBotGroup('content');
						$params = new mosParameters('');
						$results = $_MAMBOTS->trigger('onPrepareContent', array(&$row, &$params, 0), true);
						$fb_message_txt = $row->text;
					}
					if($fbConfig->badwords && is_file($mosConfig_absolute_path . '/components/com_badword/class.badword.php')){
						$badwords = Badword::filter($fb_message_txt, $my);
						if($badwords == "true"){
							$fb_message_txt = _COM_A_BADWORDS_NOTICE;
						}
					}
					echo $fb_message_txt;
					?>
				</td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
	}
}

?>
<!-- Begin: Forum Jump -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
	<div class="<?php echo $boardclass; ?>_bt_cvr2">
		<div class="<?php echo $boardclass; ?>_bt_cvr3">
			<div class="<?php echo $boardclass; ?>_bt_cvr4">
				<div class="<?php echo $boardclass; ?>_bt_cvr5">
					<table class="fb_blocktable" id="fb_bottomarea" border="0" cellspacing="0" cellpadding="0" width="100%">
						<thead>
						<tr>
							<th class="th-right">
								<?php
								if($fbConfig->enableForumJump){
									require_once (JB_ABSSOURCESPATH . 'fb_forumjump.php');
								}
								?>
							</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>