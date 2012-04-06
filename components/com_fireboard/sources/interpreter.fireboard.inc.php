<?PHP
/**
 * @version $Id: interpreter.fireboard.inc.php 551 2008-01-10 09:31:14Z fxstein $
 * Fireboard Component
 * @package Fireboard
 * @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.bestofjoomla.com
 *
 * Russian edition by Adeptus (c) 2007
 *
 **/
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
include_once("interpreter.bbcode.inc.php");
class FireBoardBBCodeInterpreter extends BBCodeInterpreter{
	function &NewTask(){
		$task = new FireBoardBBCodeParserTask($this);
		return $task;
	}

	function hyperlink($text){
		$text = ' ' . $text . ' ';
		$text = preg_replace("/\s" . "(" . "[a-zA-Z]+:\/\/" . "[a-z][a-z0-9\_\.\-]*" . "[a-z]{2,6}" . "(" . "\/[a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.\,\#]*" . ")?" . ")" . "([\s|\.|\,])/i", " <a href=\"$1\" target=\"_blank\">$1</a>$3", $text);
		$text = preg_replace("/\s" . "(" . "www" . "\.[a-z][a-z0-9\_\.\-]*" . "[a-z]{2,6}" . "(" . "\/[a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.\,\#]*" . ")?" . ")" . "([\s|\.|\,])/i", " <a href=\"http://$1\" target=\"_blank\">$1</a>$3", $text);
		$text = preg_replace("/\s" . "(" . "[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*" . "\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6}" . ")" . "([\s|\.|\,])/i", " <a href=\"mailto://$1\">$1</a>$2", $text);
		return substr($text, 1, -1);
	}

	function Encode(&$text_new, &$task, $text_old, $context){
		if($task->in_code){
			return TAGPARSER_RET_NOTHING;
		}
		if($task->in_noparse){
			$text_new = htmlspecialchars($text_old, ENT_QUOTES);
			return TAGPARSER_RET_REPLACED;
		}
		$text_new = $text_old;
		$text_new = htmlspecialchars($text_new, ENT_QUOTES);
		if($context == 'text' && ($task->autolink_disable == 0)){
			$text_new = FireBoardBBCodeInterpreter::hyperlink($text_new);
			$text_new = smile::smileParserCallback($text_new, $task->history, $task->emoticons, $task->iconList);
		}
		return TAGPARSER_RET_REPLACED;
	}

	function TagStandard(&$tns, &$tne, &$task, $tag){
		if($task->in_code){
			return TAGPARSER_RET_NOTHING;
		}
		if($task->in_noparse){
			switch(strtolower($tag->name)){
				case 'noparse':
					$tns = "";
					$tne = '';
					$task->in_noparse = FALSE;
					return TAGPARSER_RET_REPLACED;
					break;
				default:
					break;
			}
			return TAGPARSER_RET_NOTHING;
		}
		switch(strtolower($tag->name)){
			case 'b':
				$tns = "<b>";
				$tne = '</b>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'i':
				$tns = "<i>";
				$tne = '</i>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'u':
				$tns = "<u>";
				$tne = '</u>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'size':
				if(!isset($tag->options['default']) || strlen($tag->options['default']) == 0){
					return TAGPARSER_RET_NOTHING;
				}
				$size_css = array(1 => 'fbxs', 'fbs', 'fbm', 'fbl', 'fbxl', 'fbxxl');
				if(isset($size_css[$tag->options['default']])){
					$tns = '<span class="' . $size_css[$tag->options['default']] . '">';
					$tne = '</span>';
					return TAGPARSER_RET_REPLACED;
				}
				$tns = "<span style='font-size:" . htmlspecialchars($tag->options['default'], ENT_QUOTES) . "'>";
				$tne = '</span>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'ol':
				$tns = "<ol>";
				$tne = '</ol>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'ul':
				$tns = "<ul>";
				$tne = '</ul>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'li':
				$tns = "<li>";
				$tne = '</li>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'color':
				$tns = "<span style='color: " . htmlspecialchars($tag->options['default'], ENT_QUOTES) . "'>";
				$tne = '</span>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'highlight':
				$tns = "<span style='font-weight: 700;'>";
				$tne = '</span>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'left':
				$tns = '<div style="width:100%;text-align:left" align="left">';
				$tne = '</div>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'center':
				$tns = '<div style="width:100%;text-align:center" align="center">';
				$tne = '</div>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'right':
				$tns = '<div style="width:100%;text-align:right" align="right">';
				$tne = '</div>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'justify':
				$tns = '<div style="width:100%;text-align:justify" align="justify">';
				$tne = '</div>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'indent':
				$tns = "<blockquote>";
				$tne = '</blockquote>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'email':
				$task->autolink_disable--;
				if(isset($tag->options['default'])){
					$tempstr = $tag->options['default'];
					if(substr($tempstr, 0, 7) !== 'mailto:'){
						$tempstr = 'mailto:' . $tempstr;
					}
					$tns = "<a href='" . htmlspecialchars($tempstr, ENT_QUOTES) . "'>";
					$tne = '</a>';
					return TAGPARSER_RET_REPLACED;
				}
				break;
			case 'url':
				$task->autolink_disable--;
				if(isset($tag->options['default'])){
					$tempstr = $tag->options['default'];
					if(substr($tempstr, 0, 4) == 'www.'){
						$tempstr = 'http://' . $tempstr;
					}
					$tns = "<a href='" . htmlspecialchars($tempstr, ENT_QUOTES) . "' target='_blank'>";
					$tne = '</a>';
					return TAGPARSER_RET_REPLACED;
				}
				break;
			case 'thread':
				$task->autolink_disable--;
				if(isset($tag->options['default'])){
					$tns = "<a href='/thebadlink:thread" . htmlspecialchars($tag->options['default'], ENT_QUOTES) . "'>";
					$tne = '</a>';
					return TAGPARSER_RET_REPLACED;
				}
				break;
			case 'post':
				$task->autolink_disable--;
				if(isset($tag->options['default'])){
					$tns = "<a href='/thebadlink:post" . htmlspecialchars($tag->options['default'], ENT_QUOTES) . "'>";
					$tne = '</a>';
					return TAGPARSER_RET_REPLACED;
				}
				break;
			default:
				break;
		}
		return TAGPARSER_RET_NOTHING;
	}

	function TagExtended(&$tag_new, &$task, $tag, $between){
		if($task->in_code){
			switch(strtolower($tag->name)){
				case 'code:1':
				case 'code':
					$types = array("php", "mysql", "html", "js", "javascript");
					$code_start_html = '<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center"><tr><td colspan="2"><b>' . _FB_MSG_CODE . '</b></td></tr><tr><td class="afbcode"></td><td class="afbcode1">';
					if(in_array($tag->options["type"], $types)){
						$t_type = $tag->options["type"];
					} else{
						$t_type = "php";
					}
					// make sure we show line breaks
					$code_start_html .= "<script type=\"text/javascript\">document.write('<co' + 'de class=\"{$t_type}\">')</script>";
					$code_end_html = '</code></td></tr></table>';
					$tag_new = $code_start_html . htmlspecialchars($between, ENT_QUOTES) . $code_end_html;
					$task->in_code = FALSE;
					return TAGPARSER_RET_REPLACED;
					break;
				default:
					break;
			}
			return TAGPARSER_RET_NOTHING;
		}
		switch(strtolower($tag->name)){
			///////////////////////////////////////////
			case 'mp3':
				if($between){
					$mosConfig_live_site = FBJConfig::getCfg('live_site');
					$task->autolink_disable--;
					$tag_new = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" style="width:300px; height:20px;"  codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
<param name="movie" value="' . $mosConfig_live_site . '/components/com_fireboard/facebox/player.swf?file=http://' . $between . '" />
<param name="autostart" value="false" />
<embed src="' . $mosConfig_live_site . '/components/com_fireboard/facebox/player.swf?file=http://' . $between . '" style="width:300px; height:20px;" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>';
				}
				return TAGPARSER_RET_REPLACED;
				break;
			///////////////////////////////////////////
			case 'media':
				if($between){
					$mosConfig_live_site = FBJConfig::getCfg('live_site');
					$task->autolink_disable--;
					$tag_new = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" style="width:400px; height:323px;" title="Adeptus Fireboard Media"  codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
<param name="movie" value="' . $mosConfig_live_site . '/components/com_fireboard/facebox/player.swf?file=http://' . $between . '" />
<param name="autostart" value="false" />
<embed src="' . $mosConfig_live_site . '/components/com_fireboard/facebox/player.swf?file=http://' . $between . '" style="width:400px; height:323px;" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>';
				}
				return TAGPARSER_RET_REPLACED;
				break;
			///////////////////////////////////////////
			case 'hide':
				$my = FBJConfig::my();
				$database = FBJConfig::database();
				if($my->id > 0){
					if(isset($tag->options["post"])){
						$database->setQuery("SELECT posts FROM #__fb_users WHERE userid=$my->id");
						$myposts = $database->loadResult();
						if((int)$myposts >= (int)$tag->options["post"]){
							$tag_new = $between;
						} else{
							$tag_new .= "<span class=\"fb_hide\">" . _AFB_HIDDEN_POSTS . "<strong>" . $tag->options["post"] . "</strong>" . _AFB_HIDDEN_POSTS1 . "</span>";
						}
					} else $tag_new = $between;
				} else{
					$tag_new = "<span class=\"fb_hide\">" . _FB_HIDETEXT . "</span>";
				}
				return TAGPARSER_RET_REPLACED;
				break;
			case 'hideurl':
				$tempstr = $between;
				if(substr($tempstr, 0, 4) == 'www.'){
					$tempstr = 'http://' . $tempstr;
				}
				$tag_new = "<a href='" . base64_encode1($tempstr) . "' target='_blank'>" . base64_encode2($between) . '</a>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'email':
				$tempstr = $between;
				if(substr($tempstr, 0, 7) == 'mailto:'){
					$between = substr($tempstr, 7);
				} else{
					$tempstr = 'mailto:' . $tempstr;
				}
				$tag_new = "<a href='" . $tempstr . "'>" . $between . '</a>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'url':
				$tempstr = $between;
				if(substr($tempstr, 0, 4) == 'www.'){
					$tempstr = 'http://' . $tempstr;
				}
				$tag_new = "<a href='" . $tempstr . "'>" . $between . '</a>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'thread':
				$tag_new = "<a href='/thebadlink:thread" . $between . "'>" . $between . '</a>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'post':
				$tag_new = "<a href='/thebadlink:post" . $between . "'>" . $between . '</a>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'img':
				if($between){
					$task->autolink_disable--;
					/*$tag_new = '<a href="'.$between.'" rel="facebox"><img src="'.$between.
											((isset($tag->options['size']))?'" width="'.htmlspecialchars($tag->options['size']):'').
											'" border="0" style="max-width:'.(int)$GLOBALS['fbConfig']['rtewidth'].'px;" /></a>';*/
					$tag_new = '<br/>
						<a href="' . $between . '" rel="fancybox"><img src="' . $between . '" width="100px"/></a>';
					return TAGPARSER_RET_REPLACED;
				}
				return TAGPARSER_RET_NOTHING;
				break;
			case 'file':
				if($between){
					$task->autolink_disable--;
					$my = FBJConfig::my();
					$fbConfig = FBJConfig::getInstance();
					if($my->id OR $fbConfig->attach_guests){
						$tag_new = "<div class=\"fb_file_attachment\">" . _FB_FILENAME . "<a href='" . $between . "' target=\"_blank\" style=\"font-size:13px; font-weight:bold; color:#FFFFFF;\" title=\"" . _FB_FILEATTACH . "\">" . (($tag->options["name"]) ? htmlspecialchars($tag->options["name"]) : $between) . "</a><br>" . _FB_FILESIZE . htmlspecialchars($tag->options["size"], ENT_QUOTES) . " б</div>";
						return TAGPARSER_RET_REPLACED;
					} elseif(!$my->id && !$fbConfig->attach_guests){
						$tag_new = "<div class=\"fb_file_attachment\" style=\"color:#FFF; font-size:12px;\">" . _AFB_ATTACH_GUEST . "<br>" . _AFB_ATTACH_GUEST1 . "<br/></div>";
						return TAGPARSER_RET_REPLACED;
					}
				}
				return TAGPARSER_RET_NOTHING;
				break;
			case 'quote':
				$tag_new = '<span class="fb_quote">' . $between . '</span>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'spoiler':
				$spid = rand();
				$tag_new = '<div class="fb_spoiler_zag" onclick="$j(\'div#' . $spid . '\').toggle()">' . _ZAG_SPOILER . '</div>';
				$tag_new .= '<div class="fb_spoiler" style="display:none;" id="' . $spid . '">' . $between . '</div>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'attach':
				$tag_new = "<a href='/thebadlink:attachment'>ATTACH: " . $between . '</a>';
				return TAGPARSER_RET_REPLACED;
				break;
			case 'list':
				$tag_new = '<ul>';
				$tag_new .= "\n";
				$linearr = explode('[*]', $between);
				for($i = 0; $i < count($linearr); $i++){
					$tmp = trim($linearr[$i]);
					if(strlen($tmp)){
						$tag_new .= '<li>' . trim($linearr[$i]) . '</li>';
						$tag_new .= "\n";
					}
				}
				$tag_new .= '</ul>';
				$tag_new .= "\n";
				return TAGPARSER_RET_REPLACED;
				break;
			case 'video':
				if(!$between) return TAGPARSER_RET_NOTHING;
				$vid_minwidth = 20;
				$vid_minheight = 20;
				$vid_maxwidth = (int)$GLOBALS["fbConfig"]["rtewidth"];
				$vid_maxheight = 480;
				$vid['type'] = (isset($tag->options["type"])) ? htmlspecialchars($tag->options["type"]) : '';
				$vid['param'] = (isset($tag->options["param"])) ? htmlspecialchars($tag->options["param"]) : '';
				$vid_provider = array('animeepisodes' => array('flash', 428, 352, 0, 0, 'http://video.animeepisodes.net/vidiac.swf', array(array(6, 'flashvars', 'video=' . $between))), 'biku' => array('flash', 450, 364, 0, 0, 'http://www.biku.com/opus/player.swf?VideoID=' . $between . '&embed=true&autoStart=false'), 'bofunk' => array('flash', 446, 370, 0, 0, 'http://www.bofunk.com/e/' . $between), 'break' => array('flash', 464, 392, 0, 0, 'http://embed.break.com/' . $between), 'clipfish' => array('flash', 464, 380, 0, 0, 'http://www.clipfish.de/videoplayer.swf?as=0&videoid=' . $between . '&r=1&c=0067B3'), 'collegehumor' => array('flash', 480, 360, 0, 0, 'http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id=' . $between . '&fullscreen=1'), 'current' => array('flash', 400, 400, 0, 0, 'http://current.com/e/' . $between), 'dailymotion' => array('flash', 420, 331, 0, 0, 'http://www.dailymotion.com/swf/' . $between), 'flashvars' => array('flash', 480, 360, 0, 0, $between, array(array(6, 'flashvars', $vid['param']))), 'fliptrack' => array('flash', 402, 302, 0, 0, 'http://www.fliptrack.com/v/' . $between), 'gametrailers' => array('flash', 480, 392, 0, 0, 'http://www.gametrailers.com/remote_wrap.php?mid=' . $between), 'gamevideos' => array('flash', 420, 405, 0, 0, 'http://www.gamevideos.com/swf/gamevideos11.swf?embedded=1&fullscreen=1&autoplay=0&src=http://www.gamevideos.com/video/videoListXML%3Fid%3D' . $between . '%26adPlay%3Dfalse', array(array(6, 'bgcolor', '#000000'), array(6, 'wmode', 'window'))), 'gmx' => array('flash', 425, 367, 0, 0, 'http://video.gmx.net/movie/' . $between), 'google' => array('flash', 400, 326, 0, 0, 'http://video.google.com/googleplayer.swf?docId=' . $between), 'ifilm' => array('flash', 448, 365, 0, 0, 'http://www.ifilm.com/efp', array(array(6, 'flashvars', 'flvbaseclip=' . $between))), 'jumpcut' => array('flash', 408, 324, 0, 0, 'http://jumpcut.com/media/flash/jump.swf?id=' . $between . '&asset_type=movie&asset_id=' . $between . '&eb=1'), 'liveleak' => array('flash', 450, 370, 0, 0, 'http://www.liveleak.com/player.swf', array(array(6, 'flashvars', 'autostart=false&token=' . $between))), 'megavideo' => array('flash', 432, 351, 0, 0, 'http://www.megavideo.com/v/' . $between . '..0'), 'metacafe' => array('flash', 400, 345, 0, 0, 'http://www.metacafe.com/fplayer/' . $between . '/.swf'), 'mofile' => array('flash', 480, 395, 0, 0, 'http://tv.mofile.com/cn/xplayer.swf', array(array(6, 'flashvars', 'v=' . $between . '&autoplay=0&nowSkin=0_0'))), 'myspace' => array('flash', 430, 346, 0, 0, 'http://lads.myspace.com/videos/vplayer.swf', array(array(6, 'flashvars', 'm=' . $between . '&v=2&type=video'))), 'myvideo' => array('flash', 470, 406, 0, 0, 'http://www.myvideo.de/movie/' . $between), 'quxiu' => array('flash', 437, 375, 0, 0, 'http://www.quxiu.com/photo/swf/swfobj.swf?id=' . $between, array(array(6, 'menu', 'false'))), 'revver' => array('flash', 480, 392, 0, 0, 'http://flash.revver.com/player/1.0/player.swf?mediaId=' . $between), 'sevenload' => array('flash', 425, 350, 0, 0, 'http://sevenload.com/pl/' . $between . '/425x350/swf', array(array(6, 'flashvars', 'apiHost=api.sevenload.com&showFullScreen=1'))), 'stage6' => array('divx', 480, 360, 0, 25, 'http://video.stage6.com/' . $between . '/.divx', array(array(6, 'custommode', 'Stage6'))), 'stickam' => array('flash', 400, 300, 0, 0, 'http://player.stickam.com/flashVarMediaPlayer/' . $between), 'streetfire' => array('flash', 428, 352, 0, 0, 'http://videos.streetfire.net/vidiac.swf', array(array(6, 'flashvars', 'video=' . $between))), 'tudou' => array('flash', 400, 300, 0, 0, 'http://www.tudou.com/v/' . $between), 'uume' => array('flash', 400, 342, 0, 0, 'http://www.uume.com/v/' . $between . '_UUME'), 'veoh' => array('flash', 540, 438, 0, 0, 'http://www.veoh.com/videodetails2.swf?player=videodetailsembedded&type=v&permalinkId=' . $between), 'vidiac' => array('flash', 428, 352, 0, 0, 'http://www.vidiac.com/vidiac.swf', array(array(6, 'flashvars', 'video=' . $between))), 'vimeo' => array('flash', 400, 321, 0, 0, 'http://www.vimeo.com/moogaloop.swf?clip_id=' . $between . '&server=www.vimeo.com&fullscreen=1&show_title=1&show_byline=1&show_portrait=0&color='), 'wangyou' => array('flash', 441, 384, 0, 0, 'http://v.wangyou.com/images/x_player.swf?id=' . $between), 'web.de' => array('flash', 425, 367, 0, 0, 'http://video.web.de/movie/' . $between), 'youtube' => array('flash', 425, 355, 0, 0, 'http://www.youtube.com/v/' . $between . '&rel=1'), '_default' => array($vid["type"], 480, 360, 0, 25, $between));
				list($vid_type, $vid_width, $vid_height, $vid_addx, $vid_addy, $vid_source, $vid_par2) = (isset($vid_provider[$vid["type"]])) ? $vid_provider[$vid["type"]] : $vid_provider["_default"];
				$vid_size = intval($tag->options["size"]);
				if(($vid_size > 0) and ($vid_size < 100)){
					$vid_width = (int)($vid_width * $vid_size / 100);
					$vid_height = (int)($vid_height * $vid_size / 100);
				}
				$vid_width += $vid_addx;
				$vid_height += $vid_addy;
				if(!isset($tag->options["size"])){
					if(isset($tag->options["width"])) $vid_width = intval($tag->options["width"]);
					if(isset($tag->options["height"])) $vid_height = intval($tag->options["height"]);
				}
				if($vid_width < $vid_minwidth) $vid_width = $vid_minwidth;
				if($vid_width > $vid_maxwidth) $vid_width = $vid_maxwidth;
				if($vid_height < $vid_minheight) $vid_height = $vid_minheight;
				if($vid_height > $vid_maxheight) $vid_height = $vid_maxheight;
				switch($vid_type){
					case 'divx':
						$vid_par1 = array(array(1, 'classid', 'clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616'), array(1, 'codebase', 'http://go.divx.com/plugin/DivXBrowserPlugin.cab'), array(4, 'type', 'video/divx'), array(4, 'pluginspage', 'http://go.divx.com/plugin/download/'), array(6, 'src', $vid_source), array(6, 'autoplay', 'false'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
						break;
					case 'flash':
						$vid_par1 = array(array(1, 'classid', 'clsid:d27cdb6e-ae6d-11cf-96b8-444553540000'), array(1, 'codebase', 'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab'), array(2, 'movie', $vid_source), array(4, 'src', $vid_source), array(4, 'type', 'application/x-shockwave-flash'), array(4, 'pluginspage', 'http://www.macromedia.com/go/getflashplayer'), array(6, 'quality', 'high'), array(6, 'wmode', 'transparent'), array(6, 'allowFullScreen', 'true'), array(6, 'allowScriptAccess', 'never'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
						break;
					case 'mediaplayer':
						$vid_par1 = array(array(1, 'classid', 'clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95'), array(1, 'codebase', 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab'), array(4, 'type', 'application/x-mplayer2'), array(4, 'pluginspage', 'http://www.microsoft.com/Windows/MediaPlayer/'), array(6, 'src', $vid_source), array(6, 'autostart', 'false'), array(6, 'autosize', 'true'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
						break;
					case 'quicktime':
						$vid_par1 = array(array(1, 'classid', 'clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B'), array(1, 'codebase', 'http://www.apple.com/qtactivex/qtplugin.cab'), array(4, 'type', 'video/quicktime'), array(4, 'pluginspage', 'http://www.apple.com/quicktime/download/'), array(6, 'src', $vid_source), array(6, 'autoplay', 'false'), array(6, 'scale', 'aspect'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
						break;
					case 'realplayer':
						$vid_par1 = array(array(1, 'classid', 'clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA'), array(4, 'type', 'audio/x-pn-realaudio-plugin'), array(6, 'src', $vid_source), array(6, 'autostart', 'false'), array(6, 'controls', 'ImageWindow,ControlPanel'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
						break;
					default:
						return TAGPARSER_RET_NOTHING;
				}
				$vid_object = $vid_param = $vid_embed = array();
				foreach(((is_array($vid_par2)) ? array_merge($vid_par1, $vid_par2) : $vid_par1) as $vid_data){
					list($vid_key, $vid_name, $vid_value) = $vid_data;
					if($vid_key & 1) $vid_object[$vid_name] = ' ' . $vid_name . '="' . $vid_value . '"';
					if($vid_key & 2) $vid_param[$vid_name] = '<param name="' . $vid_name . '" value="' . $vid_value . '" />';
					if($vid_key & 4) $vid_embed[$vid_name] = ' ' . $vid_name . '="' . $vid_value . '"';
				}
				$tag_new = '<object';
				foreach($vid_object as $vid_data) $tag_new .= $vid_data;
				$tag_new .= '>';
				foreach($vid_param as $vid_data) $tag_new .= $vid_data;
				$tag_new .= '<embed';
				foreach($vid_embed as $vid_data) $tag_new .= $vid_data;
				$tag_new .= ' /></object>';
				return TAGPARSER_RET_REPLACED;
				break;
			default:
				break;
		}
		return TAGPARSER_RET_NOTHING;
	}

	function TagSingle(&$tag_new, &$task, $tag){
		if($task->in_code){
			return TAGPARSER_RET_NOTHING;
		}
		if($task->in_noparse){
			return TAGPARSER_RET_NOTHING;
		}
		switch(strtolower($tag->name)){
			case 'code:1':
			case 'code':
				$task->in_code = TRUE;
				return TAGPARSER_RET_NOTHING;
				break;
			case 'noparse':
				$task->in_noparse = TRUE;
				return TAGPARSER_RET_NOTHING;
				break;
			case 'email':
			case 'url':
			case 'thread':
			case 'post':
			case 'img':
			case 'file':
			case 'video':
				$task->autolink_disable++;
				return TAGPARSER_RET_NOTHING;
				break;
			case 'br':
				$tag_new = "<br />";
				return TAGPARSER_RET_REPLACED;
			case '*':
				$tag_new = "[*]";
				return TAGPARSER_RET_REPLACED;
				break;
			default:
				break;
		}
		return TAGPARSER_RET_NOTHING;
	}

	function TagSingleLate(&$tag_new, &$task, $tag){
		if($task->in_code){
			return TAGPARSER_RET_NOTHING;
		}
		if($task->in_noparse){
			return TAGPARSER_RET_NOTHING;
		}
		switch(strtolower($tag->name)){
			case 'img':
				$task->autolink_disable--;
				if(isset($tag->options['default'])){
					$tag->options['name'] = $tag->options['default'];
				}
				$tag_new = "<img class='c_img' BORDER='0' src='" . htmlspecialchars($tag->options['default'], ENT_QUOTES) . "'";
				if(isset($tag->options['width'])){
					$tag->options['width'] = (int)$tag->options['width'];
					$tag_new .= " width='" . $tag->options['width'] . "'";
				}
				if(isset($tag->options['height'])){
					$tag->options['height'] = (int)$tag->options['height'];
					$tag_new .= " height='" . $tag->options['height'] . "'";
				}
				if(isset($tag->options['left'])){
					$tag_new .= " align='left'";
				} else if(isset($tag->options['right'])){
					$tag_new .= " align='right'";
				}
				$tag_new .= " border='0'";
				$tag_new .= ">";
				return TAGPARSER_RET_REPLACED;
				break;
			default:
				break;
		}
		return TAGPARSER_RET_NOTHING;
	}
}

class FireBoardBBCodeParserTask extends BBCodeParserTask{
	var $autolink_disable = 0;
	var $history = 0; // 1=grey
	var $emoticons = 1; // true if to be replaced
	var $iconList = array(); // smilies
}

class FireBoardBBCodeInterpreterPlain extends BBCodeInterpreter{
	function MyTagInterpreterSearch($references){
		MyTagInterpreter::MyTagInterpreter();
	}

	function Encode(&$text_new, &$task, $text_old, $context){
		return TAGPARSER_RET_NOTHING;
	}

	function TagStandard(&$tns, &$tne, &$task, $tag){
		$tns = '';
		$tne = '';
		return TAGPARSER_RET_NOTHING;
	}

	function TagExtended(&$tag_new, &$task, $tag, $between){
		$tag_new = $between;
		return TAGPARSER_RET_NOTHING;
	}

	function TagSingle(&$tag_new, &$task, $tag){
		$tag_new = '';
		return TAGPARSER_RET_NOTHING;
	}

	function TagSingleLate(&$tag_new, &$task, $tag){
		$tag_new = '';
		return TAGPARSER_RET_NOTHING;
	}
}

function base64_encode1($link){
	return "redirect.php?id=" . urlsafe_b64encode($link);
}

function base64_encode2($text){
	return reducedwords(urlsafe_b64encode($text)) . ".url";
}

function reducedwords($words, $maxlen = 60, $start = 35){
	if(strlen($words) > ($maxlen + 3)) return (substr($words, 0, $start) . "..." . substr($words, strlen($words) - $maxlen + $start, $maxlen - $start));
	return $words;
}

function urlsafe_b64encode($string){
	$data = base64_encode($string);
	$data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
	return $data;
}
