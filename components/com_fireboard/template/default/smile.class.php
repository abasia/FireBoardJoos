<?php
/**
 * @version $Id: smile.class.php 522 2007-12-19 23:15:43Z miro_dietiker $
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
 * Russian edition by Adeptus (c) 2008
 *
 **/
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
include_once(JB_ABSSOURCESPATH . "parser.inc.php");
include_once(JB_ABSSOURCESPATH . "interpreter.fireboard.inc.php");
class smile{
	public static function smileParserCallback($fb_message, $history, $emoticons, $iconList = null){
		$type = ($history == 1) ? "-grey" : "";
		$message_emoticons = array();
		$message_emoticons = $iconList ? $iconList : smile::getEmoticons($history);
		$fb_message_txt = $fb_message;
		if($emoticons != 1){
			reset($message_emoticons);
			while(list($emo_txt, $emo_src) = each($message_emoticons)){
				$fb_message_txt = str_replace($emo_txt, '<img src="' . $emo_src . '" alt="" style="vertical-align: middle;border:0px;" />', $fb_message_txt);
			}
		}
		return $fb_message_txt;
	}

	public static function smileReplace($fb_message, $history, $emoticons, $iconList = null){
		$fb_message_txt = $fb_message;
		$fb_message_txt = preg_replace("/\[code\]/si", "[code]", $fb_message_txt);
		$fb_message_txt = preg_replace("/\[\/code\]/si", "[/code]", $fb_message_txt);
		$fb_message_txt = preg_replace("/\[code:1\]/si", "[code]", $fb_message_txt);
		$fb_message_txt = preg_replace("/\[\/code:1\]/si", "[/code]", $fb_message_txt);
		$fb_message_txt = preg_replace("/\[noparse\]/si", "[noparse]", $fb_message_txt);
		$fb_message_txt = preg_replace("/\[\/noparse\]/si", "[/noparse]", $fb_message_txt);
		$parser = new TagParser();
		$interpreter = new FireBoardBBCodeInterpreter($parser);
		$task = $interpreter->NewTask();
		$task->SetText($fb_message_txt);
		$task->dry = FALSE;
		$task->drop_errtag = FALSE;
		$task->history = $history;
		$task->emoticons = $emoticons;
		$task->iconList = $iconList;
		$task->Parse();
		return $task->text;
	}

	public static function getEmoticons($grayscale, $emoticonbar = 0){
		$database = FBJConfig::database();
		$grayscale == 1 ? $column = "greylocation" : $column = "location";
		$sql = "SELECT `code` , `$column` FROM `#__fb_smileys`";
		if($emoticonbar == 1) $sql .= " where `emoticonbar` = 1";
		$sql .= ";";
		$database->setQuery($sql);
		$smilies = $database->loadObjectList();
		$smileyArray = array();
		foreach($smilies as $smiley){
			$smileyArray[$smiley->code] = '' . JB_URLEMOTIONSPATH . '' . $smiley->$column;
		}
		if($emoticonbar == 0){
			array_multisort(array_keys($smileyArray), SORT_DESC, $smileyArray);
			reset($smileyArray);
		}
		return $smileyArray;
	}

	public static function topicToolbar($selected, $tawidth){
		global $func;	//TODO:GoDr удалить глобальную
		if(!$selected) $selected = 1;
		$selected = (int)$selected;
		?>
	<table border="0" cellspacing="0" cellpadding="0" class="fb_flat">
		<tr>
			<td>
				<input type="radio" name="topic_emoticon"
					   value="0"<?php echo $selected == 0 ? " checked=\"checked\" " : "";?>/><?php echo _NO_SMILIE; ?>
				<input type="radio" name="topic_emoticon"
					   value="1"<?php echo $selected == 1 ? " checked=\"checked\" " : "";?>/>
				<img src="<?php echo JB_URLEMOTIONSPATH;?>default.gif" alt="" border="0"/>
				<input type="radio" name="topic_emoticon"
					   value="2"<?php echo $selected == 2 ? " checked=\"checked\" " : "";?>/>
				<img src="<?php echo JB_URLEMOTIONSPATH;?>exclam.gif" alt="" border="0"/>
				<input type="radio" name="topic_emoticon"
					   value="3"<?php echo $selected == 3 ? " checked=\"checked\" " : "";?>/>
				<img src="<?php echo JB_URLEMOTIONSPATH;?>question.gif" alt="" border="0"/>
				<input type="radio" name="topic_emoticon"
					   value="4"<?php echo $selected == 4 ? " checked=\"checked\" " : "";?>/>
				<img src="<?php echo JB_URLEMOTIONSPATH;?>arrow.gif" alt="" border="0"/>
				<?php
				if($tawidth <= 320){
					echo '</td></tr><tr><td>';
				}
				?>
				<input type="radio" name="topic_emoticon"
					   value="5"<?php echo $selected == 5 ? " checked=\"checked\" " : "";?>/>
				<img src="<?php echo JB_URLEMOTIONSPATH;?>love.gif" alt="" border="0"/>
				<input type="radio" name="topic_emoticon"
					   value="6"<?php echo $selected == 6 ? " checked=\"checked\" " : "";?>/>
				<img src="<?php echo JB_URLEMOTIONSPATH;?>grin.gif" alt="" border="0"/>
				<input type="radio" name="topic_emoticon"
					   value="7"<?php echo $selected == 7 ? " checked=\"checked\" " : "";?>/>
				<img src="<?php echo JB_URLEMOTIONSPATH;?>shock.gif" alt="" border="0"/>
				<input type="radio" name="topic_emoticon"
					   value="8"<?php echo $selected == 8 ? " checked=\"checked\" " : "";?>/>
				<img src="<?php echo JB_URLEMOTIONSPATH;?>smile.gif" alt="" border="0"/>
				<?php if($func == 'poll'){
				?>
				<input type="radio" name="topic_emoticon"
					   value="9"<?php echo $selected == 9 ? " checked=\"checked\" " : "";?>/>
				<img src="<?php echo JB_URLEMOTIONSPATH;?>poll.gif" alt="" border="0"/>
				<?php
			}?>
			</td>
		</tr>
	</table>
	<?php
	}

	function fbStripHtmlTags($text){
		$fb_message_txt = $text;
		$fb_message_txt = preg_replace("/<p>/si", "", $fb_message_txt);
		$fb_message_txt = preg_replace("%</p>%si", "\n", $fb_message_txt);
		$fb_message_txt = preg_replace("/<br>/si", "\n", $fb_message_txt);
		$fb_message_txt = preg_replace("%<br />%si", "\n", $fb_message_txt);
		$fb_message_txt = preg_replace("%<br />%si", "\n", $fb_message_txt);
		$fb_message_txt = preg_replace("%<br/>%si", "\n", $fb_message_txt);
		$fb_message_txt = preg_replace("/&nbsp;/si", " ", $fb_message_txt);
		$fb_message_txt = preg_replace("/<OL>/si", "[ol]", $fb_message_txt);
		$fb_message_txt = preg_replace("%</OL>%si", "[/ol]", $fb_message_txt);
		$fb_message_txt = preg_replace("/<ul>/si", "[ul]", $fb_message_txt);
		$fb_message_txt = preg_replace("%</ul>%si", "[/ul]", $fb_message_txt);
		$fb_message_txt = preg_replace("/<LI>/si", "[li]", $fb_message_txt);
		$fb_message_txt = preg_replace("%</LI>%si", "[/li]", $fb_message_txt);
		$fb_message_txt = preg_replace("/<div class=\\\"fb_quote\\\">/si", "[quote]", $fb_message_txt);
		$fb_message_txt = preg_replace("%</div>%si", "[/quote]", $fb_message_txt);
		$fb_message_txt = preg_replace("/<b>/si", "[b]", $fb_message_txt);
		$fb_message_txt = preg_replace("%</b>%si", "[/b]", $fb_message_txt);
		$fb_message_txt = preg_replace("/<i>/si", "[i]", $fb_message_txt);
		$fb_message_txt = preg_replace("%</i>%si", "[/i]", $fb_message_txt);
		$fb_message_txt = preg_replace("/<u>/si", "[u]", $fb_message_txt);
		$fb_message_txt = preg_replace("%</u>%si", "[/u]", $fb_message_txt);
		$fb_message_txt = preg_replace("/<s>/si", "[s]", $fb_message_txt);
		$fb_message_txt = preg_replace("%</s>%si", "[/s]", $fb_message_txt);
		$fb_message_txt = preg_replace("/<strong>/si", "[b]", $fb_message_txt);
		$fb_message_txt = preg_replace("%</strong>%si", "[/b]", $fb_message_txt);
		$fb_message_txt = preg_replace("/<em>/si", "[i]", $fb_message_txt);
		$fb_message_txt = preg_replace("%<em>%si", "[/i]", $fb_message_txt);
		while($fb_message_txt != strip_tags($fb_message_txt)){
			$fb_message_txt = strip_tags($fb_message_txt);
		}
		return $fb_message_txt;
	}

	public static function fbHtmlSafe($text){
		$fb_message_txt = $text;
		$fb_message_txt = str_replace("<", "&lt;", $fb_message_txt);
		$fb_message_txt = str_replace(">", "&gt;", $fb_message_txt);
		return $fb_message_txt;
	}

	public static function fbWriteTextarea($areaname, $html, $width, $height, $useRte, $emoticons){
		global $editmode;	//TODO:GoDr удалить глобальную
		$fbConfig = FBJConfig::getInstance();
		if($fbConfig->joomlaStyle < 1){
			$boardclass = "fb_";
		}
		?>
	<tr class="<?php echo $boardclass; ?>sectiontableentry1">
		<td class="fb_leftcolumn" valign="top">
			<strong><a
				href="<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=faq') . '#boardcode';?>"><?php echo _COM_BOARDCODE; ?></a></strong>:
		</td>
		<td>
			<table border="0" cellspacing="0" cellpadding="0" class="fb-postbuttonset">
				<tr>
					<td class="fb-postbuttons">
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="b" name="addbbcode0"
							   value=" B " style="font-weight:bold; " onclick="bbstyle(0)" onmouseover="helpline('b')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="i" name="addbbcode2"
							   value=" i " style="font-style:italic; " onclick="bbstyle(2)"
							   onmouseover="helpline('i')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="u" name="addbbcode4"
							   value=" u " style="text-decoration: underline;" onclick="bbstyle(4)"
							   onmouseover="helpline('u')"/>

						<input type="button" class="<?php echo $boardclass;?>button" accesskey="l" name="addbbcode6"
							   value="<-|" style="text-decoration: none; " onclick="bbstyle(6)"
							   onmouseover="helpline('lt')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="r" name="addbbcode8"
							   value="|->" style="text-decoration: none; " onclick="bbstyle(8)"
							   onmouseover="helpline('rt')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="z" name="addbbcode10"
							   value="->|<-" style="text-decoration: none; " onclick="bbstyle(10)"
							   onmouseover="helpline('cr')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="" name="addbbcode12"
							   value="|<->|" style="text-decoration: none; " onclick="bbstyle(12)"
							   onmouseover="helpline('jy')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="q" name="addbbcode14"
							   value="Quote" onclick="bbstyle(14)" onmouseover="helpline('q')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="c" name="addbbcode16"
							   value="#" onclick="bbstyle(16)" onmouseover="helpline('c')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="k" name="addbbcode18"
							   value="ul" onclick="bbstyle(18)" onmouseover="helpline('k')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="o" name="addbbcode20"
							   value="Spoiler" onclick="bbstyle(20)" onmouseover="helpline('spoiler')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="l" name="addbbcode22"
							   value="li" onclick="bbstyle(22)" onmouseover="helpline('l')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="p" name="addbbcode24"
							   value="Img" onclick="bbstyle(24)" onmouseover="helpline('p')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="w" name="addbbcode26"
							   value="URL" style="text-decoration: underline; " onclick="bbstyle(26)"
							   onmouseover="helpline('w')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="h" name="addbbcode28"
							   value="Hide" style="text-decoration: underline; " onclick="bbstyle(28)"
							   onmouseover="helpline('h')"/>
						<br/>
						<!--<input type = "button" class = "<?php echo $boardclass;?>button" accesskey = "hu" name = "addbbcode30" value = "HideURL" style = "text-decoration: none; " onclick = "bbstyle(30)" onmouseover = "helpline('hu')"/>-->
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="3" name="addbbcode32"
							   value="mp3" onclick="bbstyle(32)" onmouseover="helpline('mp3')"/>
						<input type="button" class="<?php echo $boardclass;?>button" accesskey="f" name="addbbcode34"
							   value="Media" style="text-decoration: underline; " onclick="bbstyle(34)"
							   onmouseover="helpline('fl')"/>
					<span style="white-space:nowrap;">&nbsp;<?php echo _AFB_VIDEO;?>
						<script type="text/javascript">function vid_help() {
							document.postform.helpbox.value = 'Видео: [video type=provider size=100 width=480 height=360]xyz[/video]';
						}</script>
                    <select name="vid_code"
							onchange="bbfontstyle('[video type=' + this.form.vid_code.options[this.form.vid_code.selectedIndex].value, '[/video]')"
							onmouseover="vid_help()" class="<?php echo $boardclass;?>button">
						<?php
						$vid_provider = array('AnimeEpisodes', 'Biku', 'Bofunk', 'Break', 'Clipfish', 'Collegehumor', 'Current', 'DailyMotion', 'DivX,divx]http://', 'Fliptrack', 'Flash,flash]http://', 'FlashVars,flashvars param=]http://', 'Gametrailers', 'Gamevideos', 'GMX', 'Google', 'iFilm', 'Jumpcut', 'LiveLeak', 'MediaPlayer', 'MegaVideo', 'Metacafe', 'Mofile', 'MySpace', 'MyVideo', 'QuickTime,quicktime]http://', 'Quxiu', 'RealPlayer,realplayer]http://', 'Revver', 'Sevenload', 'Stage6,stage6]http://', 'Stickam', 'Streetfire', 'Tudou', 'Uume', 'Veoh', 'Vidiac', 'Vimeo', 'WangYou', 'WEB.DE', 'YouTube');
						foreach($vid_provider as $vid_type){
							list($vid_name, $vid_type) = explode(',', $vid_type);
							echo '<option value = "' . (($vid_type) ? $vid_type : strtolower($vid_name) . ']') . '">' . $vid_name . '</option>';
						}
						?>
					</select></span><br/>
						&nbsp;<?php echo _SMILE_COLOUR; ?>:
						<select name="addbbcode36"
								onchange="bbfontstyle('[color=' + this.form.addbbcode36.options[this.form.addbbcode36.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;"
								onmouseover="helpline('s')" class="<?php echo $boardclass;?>slcbox">
							<option style="color:black;   background-color: #FAFAFA"
									value=""><?php echo _COLOUR_DEFAULT; ?></option>
							<option style="color:#FF0000; background-color: #FAFAFA"
									value="#FF0000"><?php echo _COLOUR_RED; ?></option>
							<option style="color:#800080; background-color: #FAFAFA"
									value="#800080"><?php echo _COLOUR_PURPLE; ?></option>
							<option style="color:#0000FF; background-color: #FAFAFA"
									value="#0000FF"><?php echo _COLOUR_BLUE; ?></option>
							<option style="color:#008000; background-color: #FAFAFA"
									value="#008000"><?php echo _COLOUR_GREEN; ?></option>
							<option style="color:#FFFF00; background-color: #FAFAFA"
									value="#FFFF00"><?php echo _COLOUR_YELLOW; ?></option>
							<option style="color:#FF6600; background-color: #FAFAFA"
									value="#FF6600"><?php echo _COLOUR_ORANGE; ?></option>
							<option style="color:#000080; background-color: #FAFAFA"
									value="#000080"><?php echo _COLOUR_DARKBLUE; ?></option>
							<option style="color:#825900; background-color: #FAFAFA"
									value="#825900"><?php echo _COLOUR_BROWN; ?></option>
							<option style="color:#9A9C02; background-color: #FAFAFA"
									value="#9A9C02"><?php echo _COLOUR_GOLD; ?></option>
							<option style="color:#A7A7A7; background-color: #FAFAFA"
									value="#A7A7A7"><?php echo _COLOUR_SILVER; ?></option>
						</select>
						&nbsp;<?php echo _SMILE_SIZE; ?>:
						<select name="addbbcode38"
								onchange="bbfontstyle('[size=' + this.form.addbbcode38.options[this.form.addbbcode38.selectedIndex].value + 'px]', '[/size]')"
								onmouseover="helpline('f')" class="<?php echo $boardclass;?>button">
							<option value="9"><?php echo _SIZE_VSMALL; ?></option>
							<option value="10"><?php echo _SIZE_SMALL; ?></option>
							<option value="12" selected="selected"><?php echo _SIZE_NORMAL; ?></option>
							<option value="20"><?php echo _SIZE_BIG; ?></option>
							<option value="36"><?php echo _SIZE_VBIG; ?></option>
						</select>
						&nbsp;&nbsp;<a href="javascript: bbstyle(-1)" onmouseover="helpline('a')">
						<small><?php echo _BBCODE_CLOSA; ?></small>
					</a>
					</td>
				</tr>
				<tr>
					<td class="<?php echo $boardclass;?>posthint">
						<input type="text" name="helpbox" size="45" class="<?php echo $boardclass;?>inputbox"
							   maxlength="140" value="<?php echo _BBCODE_HINT;?>"/>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="<?php echo $boardclass; ?>sectiontableentry2">
		<td valign="top" class="fb_leftcolumn">
			<strong><?php echo _MESSAGE; ?></strong>:
			<?php
			if($emoticons != 1){
				?>
				<br/>
				<br/>
				<div align="right">
					<table border="0" cellspacing="3" cellpadding="0">
						<tr>
							<td colspan="4" style="text-align: center;">
								<strong><?php echo _GEN_EMOTICONS; ?></strong>
							</td>
						</tr>
						<tr>
							<?php
							generate_smilies();
							?>
						</tr>
					</table>
				</div>
				<?php
			}
			?>
		</td>
		<td valign="top">
			<textarea class="<?php echo $boardclass;?>txtarea" name="<?php echo $areaname;?>"
					  id="<?php echo $areaname;?>"><?php echo htmlspecialchars($html, ENT_QUOTES); ?></textarea>
			<?php
			if($editmode){
				?>
				<fieldset>
					<legend><?php echo _FB_EDITING_REASON?></legend>
					<input name="modified_reason" size="40" maxlength="200" type="text"><br/>
				</fieldset>
				<?php
			}
			?>
		</td>
	</tr>
	<?php
	}

	public static function purify($text){
		$text = preg_replace("'<script[^>]*>.*?</script>'si", "", $text);
		$text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text);
		$text = preg_replace('/<!--.+?-->/', '', $text);
		$text = preg_replace('/{.+?}/', '', $text);
		$text = preg_replace('/&nbsp;/', ' ', $text);
		$text = preg_replace('/&amp;/', ' ', $text);
		$text = preg_replace('/&quot;/', ' ', $text);
		//smilies
		$text = preg_replace('/:laugh:/', ':-D', $text);
		$text = preg_replace('/:angry:/', ' ', $text);
		$text = preg_replace('/:mad:/', ' ', $text);
		$text = preg_replace('/:unsure:/', ' ', $text);
		$text = preg_replace('/:ohmy:/', ':-O', $text);
		$text = preg_replace('/:blink:/', ' ', $text);
		$text = preg_replace('/:huh:/', ' ', $text);
		$text = preg_replace('/:dry:/', ' ', $text);
		$text = preg_replace('/:lol:/', ':-))', $text);
		$text = preg_replace('/:money:/', ' ', $text);
		$text = preg_replace('/:rolleyes:/', ' ', $text);
		$text = preg_replace('/:woohoo:/', ' ', $text);
		$text = preg_replace('/:cheer:/', ' ', $text);
		$text = preg_replace('/:silly:/', ' ', $text);
		$text = preg_replace('/:blush:/', ' ', $text);
		$text = preg_replace('/:kiss:/', ' ', $text);
		$text = preg_replace('/:side:/', ' ', $text);
		$text = preg_replace('/:evil:/', ' ', $text);
		$text = preg_replace('/:whistle:/', ' ', $text);
		$text = preg_replace('/:pinch:/', ' ', $text);
		//bbcode
		$text = preg_replace('/\[hide\](.*?)\[\/hide\]/is', '', $text);
		$text = preg_replace('/\[hide==([1-3])\](.*?)\[\/hide\]/s', '', $text);
		$text = preg_replace('/\[hide post=(\d+)\](.*?)\[\/hide\]/is', '', $text);
		$text = preg_replace('/\[hideurl\](.*?)\[\/hideurl\]/is', '', $text);
		$text = preg_replace('/\[hideurl=(.*?)\](.*?)\[\/hideurl\]/s', '\\2', $text);
		$text = preg_replace('/\[right\](.*?)\[\/right\]/is', '\\1', $text);
		$text = preg_replace('/\[left\](.*?)\[\/left\]/is', '\\1', $text);
		$text = preg_replace('/\[center\](.*?)\[\/center\]/is', '\\1', $text);
		$text = preg_replace('/\[justify\](.*?)\[\/justify\]/is', '\\1', $text);
		$text = preg_replace('/(\[br\])/', ' ', $text);
		$text = preg_replace('/(\[hr\])/', ' ', $text);

		$text = preg_replace('/(\[b\])/', ' ', $text);
		$text = preg_replace('/(\[\/b\])/', ' ', $text);
		$text = preg_replace('/(\[s\])/', ' ', $text);
		$text = preg_replace('/(\[\/s\])/', ' ', $text);
		$text = preg_replace('/(\[i\])/', ' ', $text);
		$text = preg_replace('/(\[\/i\])/', ' ', $text);
		$text = preg_replace('/(\[u\])/', ' ', $text);
		$text = preg_replace('/(\[\/u\])/', ' ', $text);
		$text = preg_replace('/(\[quote\])/', ' ', $text);
		$text = preg_replace('/(\[\/quote\])/', ' ', $text);
		$text = preg_replace('/(\[spoiler\])/', '', $text);
		$text = preg_replace('/(\[\/spoiler\])/', '', $text);
		$text = preg_replace('/(\[code:1\])(.*?)(\[\/code:1\])/', '\\2', $text);
		$text = preg_replace('/(\[ul\])(.*?)(\[\/ul\])/s', '\\2', $text);
		$text = preg_replace('/(\[li\])(.*?)(\[\/li\])/s', '\\2', $text);
		$text = preg_replace('/(\[ol\])(.*?)(\[\/ol\])/s', '\\2', $text);
		$text = preg_replace('/\[img size=([0-9][0-9][0-9])\](.*?)\[\/img\]/s', '\\2', $text);
		$text = preg_replace('/\[img size=([0-9][0-9])\](.*?)\[\/img\]/s', '\\2', $text);
		$text = preg_replace('/\[img\](.*?)\[\/img\]/s', '\\1', $text);
		$text = preg_replace('/\[img size=([0-9][0-9][0-9])\](.*?)\[\/img\]/s', '', $text);
		$text = preg_replace('/\[img size=([0-9][0-9])\](.*?)\[\/img\]/s', '', $text);
		$text = preg_replace('/\[img\](.*?)\[\/img\]/s', '', $text);
		$text = preg_replace('/\[url\](.*?)\[\/url\]/s', '\\1', $text);
		$text = preg_replace('/\[url=(.*?)\](.*?)\[\/url\]/s', '\\2 (\\1)', $text);
		$text = preg_replace('/<A (.*)>(.*)<\/A>/i', '\\2', $text);
		$text = preg_replace('/\[file(.*?)\](.*?)\[\/file\]/s', '\\2', $text);
		$text = preg_replace('/\[size=([1-7])\](.+?)\[\/size\]/s', '\\2', $text);
		$text = preg_replace('/\[color=(.*?)\](.*?)\[\/color\]/s', '\\2', $text);
		$text = preg_replace('/\[video type=(.*?)\](.*?)\[\/video\]/s', '\\1', $text);
		$text = preg_replace('#/n#s', ' ', $text);
		$text = strip_tags($text);
		$text = stripslashes($text);
		return ($text);
	}

	function urlMaker($text){
		$text = str_replace("\n", " \n ", $text);
		$words = explode(' ', $text);
		for($i = 0; $i < sizeof($words); $i++){
			$word = $words[$i];
			$c = 0;
			if(strtolower(substr($words[$i], 0, 7)) == 'http://'){
				$c = 1;
				$word = '<a href=\"' . $words[$i] . '\" rel=\"facebox\">' . $word . '</a>';
			} elseif(strtolower(substr($words[$i], 0, 8)) == 'https://'){
				$c = 1;
				$word = '<a href=\"' . $words[$i] . '\" target=\"_new\">' . $word . '</a>';
			} elseif(strtolower(substr($words[$i], 0, 6)) == 'ftp://'){
				$c = 1;
				$word = '<a href=\"' . $words[$i] . '\" target=\"_new\">' . $word . '</a>';
			} elseif(strtolower(substr($words[$i], 0, 4)) == 'ftp.'){
				$c = 1;
				$word = '<a href=\"ftp://' . $words[$i] . '\" target=\"_new\">' . $word . '</a>';
			} elseif(strtolower(substr($words[$i], 0, 4)) == 'www.'){
				$c = 1;
				$word = '<a href="http://' . $words[$i] . '\" target=\"_new\">' . $word . '</a>';
			} elseif(strtolower(substr($words[$i], 0, 7)) == 'mailto:'){
				$c = 1;
				$word = '<a href=\"' . $words[$i] . '\">' . $word . '</a>';
			}
			if($c == 1) $words[$i] = $word;
		}
		$ret = str_replace(" \n ", "\n", implode(' ', $words));
		return $ret;
	}

	public static function htmlwrap($str, $width = 60, $break = "\n", $nobreak = "", $nobr = "pre code", $utf = false){
		$content = preg_split("/([<>])/", $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		$nobreak = explode(" ", $nobreak);
		$nobr = explode(" ", $nobr);
		$intag = false;
		$innbk = array();
		$innbr = array();
		$drain = "";
		$utf = ($utf) ? "u" : "";
		$lbrks = "/?!%)-}]\\\"':;";
		if($break == "\r") $break = "\n";
		while(list(, $value) = each($content)){
			switch($value){
				case "<":
					$intag = true;
					break;
				case ">":
					$intag = false;
					break;
				default:
					if($intag){
						if($value{0} != "/"){
							preg_match("/^(.*?)(\s|$)/$utf", $value, $t);
							if((!count($innbk) && in_array($t[1], $nobreak)) || in_array($t[1], $innbk)) $innbk[] = $t[1];
							if((!count($innbr) && in_array($t[1], $nobr)) || in_array($t[1], $innbr)) $innbr[] = $t[1];
						} else{
							if(in_array(substr($value, 1), $innbk)) unset($innbk[count($innbk)]);
							if(in_array(substr($value, 1), $innbr)) unset($innbr[count($innbr)]);
						}
					} else if($value){
						if(!count($innbr)) $value = str_replace("\n", "\r", str_replace("\r", "", $value));
						if(!count($innbk)){
							do{
								$store = $value;
								if(preg_match("/^(.*?\s|^)(([^\s&]|&(\w{2,5}|#\d{2,4});){" . $width . "})(?!(" . preg_quote($break, "/") . "|\s))(.*)$/s$utf", $value, $match)){
									for($x = 0, $ledge = 0; $x < strlen($lbrks); $x++) $ledge = max($ledge, strrpos($match[2], $lbrks{$x}));
									if(!$ledge) $ledge = strlen($match[2]) - 1;
									$value = $match[1] . substr($match[2], 0, $ledge + 1) . $break . substr($match[2], $ledge + 1) . $match[6];
								}
							} while($store != $value);
						}
						if(!count($innbr)) $value = str_replace("\r", "<br />\n", $value);
					}
			}
			$drain .= $value;
		}
		return $drain;
	}
}

?>