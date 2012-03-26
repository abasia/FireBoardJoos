<?PHP
/**
* @version $Id: interpreter.bbcode.inc.php 548 2008-01-10 07:39:32Z fxstein $
* Fireboard Component
* @package Fireboard
* @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.bestofjoomla.com
*
* Russian edition by Adeptus (c) 2008
*
**/
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
define('BBCODE_PARSE_START',      'start');
define('BBCODE_PARSE_NAME',       'name');
define('BBCODE_PARSE_SPACE',      'space');
define('BBCODE_PARSE_KEY_OR_END', 'key_or_end');
define('BBCODE_PARSE_EQUAL',      'equal');
define('BBCODE_PARSE_VAL',        'val');
define('BBCODE_PARSE_VALQUOT',    'valquot');
function fb_stripos($haystack , $needle , $offset=0) {
    if(function_exists('stripos')) {
        return stripos($haystack, $needle, $offset);
    }
    else {
        return strpos(strtolower($haystack), strtolower($needle), $offset);
    }
}
class BBCodeInterpreter extends TagInterpreter {
    var $tag_start = '[';
    var $tag_end = ']';

    function &NewTask() {
        $task = new BBCodeParserTask($this);
        return $task;
    }
    function ParseNext(&$task) {
        $text =& $task->text;
        $pos_act =& $task->pos_act;
        if($task->in_code) {
            $checkpos = fb_stripos($text, '[/code]', $pos_act);
            if($checkpos!==FALSE) {
                $pos_act = $checkpos;
                return TAGPARSER_RET_OK;
            }
            return TAGPARSER_RET_ERR;
        }
        if($task->in_noparse) {
            $checkpos = fb_stripos($text, '[/noparse]', $pos_act);
            if($checkpos!==FALSE) {
                $pos_act = $checkpos;
                return TAGPARSER_RET_OK;
            }
            return TAGPARSER_RET_ERR;
        }
        $checkpos = fb_stripos($text, $this->tag_start, $pos_act);
        if($checkpos!==FALSE) {
            $pos_act = $checkpos;
            return TAGPARSER_RET_OK;
        }
        return TAGPARSER_RET_ERR;
    }
    function UnEscape(&$task) {
        $text =& $task->text;
        $pos_act =& $task->pos_act;
        $nextchar = substr($text, $pos_act+1, 1);
        if($nextchar==$this->tag_start) {
            if($task->dry) {
                $pos_act += 2;
                return TAGPARSER_RET_REPLACED;
            }
            $text = substr($text, 0, $pos_act).substr($text, $pos_act+1);
            $pos_act += 1;
            return TAGPARSER_RET_REPLACED;
        }
        return TAGPARSER_RET_NOTHING;
    }
    function ParseTag(&$tag, &$task) {
        $text =& $task->text;
        $pos =& $task->pos_act;
        $pos_start = $pos;
        $tagname = '';
        $nowkey = '';
        $nowval = '';
        $arr = array();
        $quot='';
        $isesc = FALSE;
        $isend = FALSE;
        $mode = BBCODE_PARSE_START;
        while(TRUE) {
            $pos++;
            $char = substr($text, $pos, 1);
            if($char===FALSE) {
                $err = new ParserErrorContext('parser.err.tag.parsetag.endless');
                $err->GrabContext($task);
                $task->ErrorPush($err);
                unset($err);
                $pos_end = $pos+1;
                return TAGPARSER_RET_ERR;
            }
            if($mode==BBCODE_PARSE_START) {
                $mode=BBCODE_PARSE_NAME;
                if($char=='/') {
                    $isend = TRUE;
                    continue;
                }
            }
            if($mode==BBCODE_PARSE_NAME) {
                if($char==$this->tag_end
                || $char=='='
                || $char==' ') {
                    if($tagname=='') {
                        $err = new ParserErrorContext('parser.err.tag.parsetag.noname');
                        $err->GrabContext($task);
                        $task->ErrorPush($err);
                        unset($err);
                        $pos_end = $pos+1;
                        return TAGPARSER_RET_ERR;
                    }
                }
                if($char==$this->tag_end) {
                    break;
                }
                if($char=='=') {
                    $mode = BBCODE_PARSE_EQUAL;
                    $nowkey .= 'default';
                    continue;
                }
                if($char==' ') {
                    $mode = BBCODE_PARSE_SPACE;
                    continue;
                }
                $tagname .= $char;
                continue;
            }
            if($mode==BBCODE_PARSE_SPACE) {
                if($char==' ') {
                    continue;
                }
                if($char==$this->tag_end) {
                    break;
                }
                $nowkey .= $char;
                $mode=BBCODE_PARSE_KEY_OR_END;
                continue;
            }
            if($mode==BBCODE_PARSE_KEY_OR_END) {
                if($char=='=') {
                    $mode = BBCODE_PARSE_EQUAL;
                    continue;
                }
                if($char==$this->tag_end) {
                    $arr[$nowkey] = TRUE;
                    break;
                }
                if($char==' ') {
                    $arr[$nowkey] = TRUE;
                    $nowkey = '';
                    $mode = BBCODE_PARSE_SPACE;
                    continue;
                }
                $nowkey .= $char;
            }
            if($mode==BBCODE_PARSE_EQUAL) {
                $quot='';
                if($char=='"') {
                    $quot='"';
                    $mode = BBCODE_PARSE_VALQUOT;
                    continue;
                }
                if($char=='\'') {
                    $quot='\'';
                    $mode = BBCODE_PARSE_VALQUOT;
                    continue;
                }
                if($char==' ') {
                    $arr[$nowkey] = TRUE;
                    $nowkey = '';
                    $mode = BBCODE_PARSE_SPACE;
                    continue;
                }
                if($char==$this->tag_end) {
                    $arr[$nowkey] = TRUE;
                    break;
                }
                $nowval .= $char;
                $mode=BBCODE_PARSE_VAL;
                continue;
            }
            if($mode==BBCODE_PARSE_VALQUOT) {
                if($isesc) {
                    $nowval .= $char;
                    $isesc = FALSE;
                    continue;
                }
                if($char=='\\') {
                    $isesc = TRUE;
                    continue;
                }
                if($char==$quot) {
                    $arr[$nowkey] = $nowval;
                    $nowkey = $nowval = '';
                    $mode = BBCODE_PARSE_SPACE;
                    continue;
                }
                $nowval .= $char;
                continue;
            }
            if($mode==BBCODE_PARSE_VAL) {
                if($char==' ') {
                    $arr[$nowkey] = $nowval;
                    $nowkey = $nowval = '';
                    $mode = BBCODE_PARSE_SPACE;
                    continue;
                }
                if($char==$this->tag_end) {
                    $arr[$nowkey] = $nowval;
                    break;
                }
                $nowval .= $char;
                continue;
            }
        }
        if($isend) {
            $tag = new ParserEventTagEnd($pos_start, $pos, $tagname);
        } else {
            $tag = new ParserEventTag($pos_start, $pos, $tagname);
            $tag->setOptions($arr);
        }
        $pos++;
        return TAGPARSER_RET_OK;
    }
    function CheckTag(&$task, $tag) {
        return TAGPARSER_RET_OK;
    }
}
class BBCodeParserTask extends ParserTask {
    var $in_code = FALSE;
    var $in_noparse = FALSE;
}
