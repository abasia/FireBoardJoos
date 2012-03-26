<?PHP
/**
* @version $Id: parser.inc.php 496 2007-12-16 21:16:32Z fxstein $
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
define('TAGPARSER_RET_OK', 0);
define('TAGPARSER_RET_ERR', 1);
define('TAGPARSER_RET_NOTHING', 0);
define('TAGPARSER_RET_REPLACED', 1);
define('TAGPARSER_RET_RECURSIVE', 2);
$GLOBALS['microtime_total'] = 0;
$GLOBALS['microtime_prev'] = 0;
function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    $newtime = ((float)$usec + (float)$sec);
    if($GLOBALS['microtime_prev']) {
        $GLOBALS['microtime_total'] += ($newtime-$GLOBALS['microtime_prev']);
    }
    $GLOBALS['microtime_prev'] = $newtime;
}
class TagParser {
    function TagParser() {
    }
    function Parse(&$task) {
        microtime_float();
        $interpreter =& $task->interpreter;
        $skip = $task->dry;
        $remove = $task->drop_errtag;
        $text =& $task->text;
        $pos_act =& $task->pos_act;
        $pos_act = 0;
        $pos_encode_last =& $task->pos_encode_last;
        $pos_encode_last = 0;
        $st =& $task->st;
        $st = Array(); $sti = 0;
        while(TRUE) {
            microtime_float();
            if($interpreter->ParseNext($task)!==TAGPARSER_RET_OK) {
                break;
            }
            $tag_start = $pos_act;
            if($interpreter->UnEscape($task)==TAGPARSER_RET_REPLACED) {
                continue;
            }
            $tag = NULL;
            if($interpreter->ParseTag($tag, $task)
            !==TAGPARSER_RET_OK) {
                $offset = 0;
                $this->RemoveOrEncode($offset, $task, $tag_start, $tag_end, 'parsetag');
                $pos_act += $offset;
                unset($offset);
                continue;
            }
            $tag_end = $tag->tag_end;
            if($interpreter->CheckTag($task, $tag)
            !==TAGPARSER_RET_OK) {
                $offset = 0;
                $this->RemoveOrEncode($offset, $task, $tag_start, $tag_end, 'checktag');
                $pos_act += $offset;
                unset($offset);
                continue;
            }
            $encode_len = $tag_start-$pos_encode_last;
            $textnew = '';
            if(!$skip
            && ($task->interpreter->Encode($textnew, $task
            , substr($text, $pos_encode_last, $encode_len), 'text')
            !==TAGPARSER_RET_NOTHING)) {
                $encode_diff = strlen($textnew)-$encode_len;
                $text = substr($text, 0, $pos_encode_last)
                .$textnew.substr($text, $tag_start);
                $tag->Offset($encode_diff);
                $tag_start += $encode_diff;
                $tag_end += $encode_diff;
                $pos_act += $encode_diff;
                unset($encode_diff);
            }
            unset($textnew);
            $pos_encode_last = $tag_start;
            unset($encode_len);
            $tag_len = $tag_end-$tag_start+1;
            if(is_a($tag, 'ParserEventTagEnd')) {
                $i=$sti-1;
                while($i>=0) {
                    $temp = $st[$i];
                    if($temp->name==$tag->name) {
                        break;
                    }
                    $i--;
                }
                unset($temp);
                if($i==-1) {
                    $err = new ParserErrorContext('parser.err.tag.nostart');
                    $err->GrabContext($task, $tag);
                    $task->ErrorPush($err);
                    unset($err);
                    if($remove) {
                        $text = substr($text, 0, $tag_start).substr($text, $tag_end+1);
                        $pos_act = $tag_start;
                    } else {
                        $pos_act = $tag_end+1;
                    }
                    continue;
                }
                while($sti>($i+1)) {
                    --$sti;
                    $starttag =& $st[$sti];
                    $starttag_len = $starttag->tag_end-$starttag->tag_start+1;
                    $tag_new = NULL;
                    if($interpreter->TagSingleLate($tag_new, $task, $starttag)
                    !==TAGPARSER_RET_NOTHING) {
                        if($skip) {
                            continue;
                        }
                        $templen = strlen($tag_new)-$starttag_len;
                        $text = substr($text, 0, $starttag->tag_start)
                        .$tag_new.substr($text, $starttag->tag_end+1);
                        $tag->Offset($templen);
                        $tag_start += $templen;
                        $tag_end += $templen;
                        $pos_act += $templen;
                        unset($templen);
                        continue;
                    } else {
                        $err = new ParserErrorContext('parser.err.tag.remain');
                        $err->GrabContext($task, $starttag);
                        $task->ErrorPush($err);
                        unset($err);
                        $offset = 0;
                        $this->RemoveOrEncode($offset, $task, $starttag->tag_start, $starttag->tag_end, 'unsupported');
                        $tag->Offset($offset);
                        $tag_start += $offset;
                        $tag_end += $offset;
                        $pos_encode_last += $offset;
                        $pos_act += $offset;
                        unset($offset);
                        continue;
                    }
                    unset($starttag, $starttag_len);
                }
                unset($i);
                unset($st[$sti]);
                $sti--;
                $starttag =& $st[$sti];
                $tag_new = $tag_new_start = $tag_new_end = NULL;
                if($task->interpreter->TagStandard($tag_new_start, $tag_new_end, $task
                , $starttag)
                !==TAGPARSER_RET_NOTHING) {
                    if($skip) {
                        continue;
                    }
                    $midlen = $tag_start-$starttag->tag_end-1;
                    $text = substr($text, 0, $starttag->tag_start).$tag_new_start
                    .substr($text, $starttag->tag_end+1, $midlen)
                    .$tag_new_end.substr($text, $tag_end+1);
                    $totallen = strlen($tag_new_start)+$midlen+strlen($tag_new_end);
                    $pos_act = $starttag->tag_start+$totallen;
                    $pos_encode_last = $pos_act;
                    unset($midlen, $totallen);
                } else if($task->interpreter->TagExtended($tag_new, $task, $starttag,
                substr($text, $starttag->tag_end+1, $tag_start-$starttag->tag_end-1))
                !==TAGPARSER_RET_NOTHING) {
                    if($skip) {
                        continue;
                    }
                    $text = substr($text, 0, $starttag->tag_start)
                    .$tag_new.substr($text, $tag_end+1);
                    $templen = strlen($tag_new);
                    $pos_encode_last = $pos_act = $starttag->tag_start+$templen;
                    unset($templen);
                } else {
                    $err = new ParserErrorContext('parser.err.tag.unsupported');
                    $err->GrabContext($task, $starttag);
                    $task->ErrorPush($err);
                    unset($err);
                    $offset_start = $offset_end = 0;
                    $this->RemoveOrEncode($offset_end, $task, $tag_start, $tag_end, 'unsupported');
                    $this->RemoveOrEncode($offset_start, $task, $starttag->tag_start, $starttag->tag_end, 'unsupported');
                    $tag->Offset($offset_end+$offset_start);
                    $pos_act += $offset_end+$offset_start;
                    $pos_encode_last = $pos_act;
                    unset($offset_end, $offset_start);
                }
                unset($starttag);
            } else {
                $tag_new = NULL;
                $kind = $task->interpreter->TagSingle($tag_new, $task, $tag);
                if($kind!==TAGPARSER_RET_NOTHING) {
                    if($skip) {
                        continue;
                    }
                    $text = substr($text, 0, $tag_start).$tag_new.substr($text, $tag_end+1);
                    if($kind==TAGPARSER_RET_RECURSIVE) {
                        $pos_act = $tag_start;
                        $pos_encode_last = $pos_act;
                    } else {
                        $templen = strlen($tag_new);
                        $pos_act = $tag_start+$templen;
                        $pos_encode_last = $pos_act;
                    }
                } else {
                    $st[$sti] = $tag;
                    unset($tag);
                    $sti++;
                    $pos_act = $tag_end+1;
                    $pos_encode_last = $pos_act;
                }
            }
        }
        $textnew = '';
        if(!$skip
        && ($task->interpreter->Encode($textnew, $task, substr($text, $pos_encode_last), 'text')
        !==TAGPARSER_RET_NOTHING)) {
            $text = substr($text, 0, $pos_encode_last).$textnew;
        }
        unset($textnew);
        while($sti>0) {
            --$sti;
            $starttag =& $st[$sti];
            $starttag_len = $starttag->tag_end-$starttag->tag_start+1;
            $tag_new = NULL;
            if($interpreter->TagSingleLate($tag_new, $task, $starttag)
            !==TAGPARSER_RET_NOTHING) {
                if($skip) {
                    continue;
                }
                $text = substr($text, 0, $starttag->tag_start)
                .$tag_new.substr($text, $starttag->tag_end+1);
            } else {
                $err = new ParserErrorContext('parser.err.tag.remain');
                $err->GrabContext($task, $starttag);
                $task->ErrorPush($err);
                unset($err);
                $offset = 0;
                $this->RemoveOrEncode($offset, $task, $starttag->tag_start, $starttag->tag_end, 'unsupported');
                unset($offset);
            }
            unset($starttag, $starttag_len);
        }
        microtime_float();
        if(count($task->errarr)) {
            return TAGPARSER_RET_ERR;
        }
        return TAGPARSER_RET_OK;
    }
    function RemoveOrEncode(&$offset, &$task, $tag_start, $tag_end, $context) {
        if($task->dry) {
            return TAGPARSER_RET_OK;
        }
        $offset = 0;
        $text =& $task->text;
        $tag_len = $tag_end-$tag_start+1;
        if($task->drop_errtag) {
            $text = substr($text, 0, $tag_start)
            .substr($text, $tag_end+1);
            $offset = -$tag_len;
        } else {
            $textnew = '';
            if($task->interpreter->Encode($textnew, $task
            , substr($text, $tag_start, $tag_len)
            , 'tagremove.'.$context)
            !==TAGPARSER_RET_NOTHING) {
                $text = substr($text, 0, $tag_start)
                .$textnew.substr($text, $tag_end+1);
                $offset = strlen($textnew)-$tag_len;
            }
        }
        return TAGPARSER_RET_OK;
    }
}
class TagInterpreter {
    var $parser = NULL;
    function TagInterpreter(&$parser) {
        $this->parser =& $parser;
    }
    function &NewTask() {
        $task = new ParserTask($this);
        return $task;
    }
    function ParseNext(&$task) {
        return TAGPARSER_RET_ERR;
    }
    function UnEscape(&$task) {
        return TAGPARSER_RET_NOTHING;
    }
    function ParseTag(&$tag, &$task) {
        return TAGPARSER_RET_ERR;
    }
    function CheckTag(&$task, $tag) {
        return TAGPARSER_RET_ERR;
    }
    function Encode(&$text_new, &$task, $text_old, $context) {
        return TAGPARSER_RET_NOTHING;
    }
    function TagSingle(&$tag_new, &$task, $tag) {
        return TAGPARSER_RET_NOTHING;
    }
    function TagStandard(&$tag_new_start, &$tag_new_end, &$task, $tag) {
        return TAGPARSER_RET_NOTHING;
    }
    function TagExtended(&$tag_new, &$task, $tag, $between) {
        return TAGPARSER_RET_NOTHING;
    }
    function TagSingleLate(&$tag_new, &$task, $tag) {
        return TAGPARSER_RET_NOTHING;
    }
}
class ParserTask {
    var $interpreter = NULL;
    var $errarr = array();
    var $text = NULL;
    var $dry = FALSE;
    var $drop_errtag = FALSE;
    var $st = array();
    var $pos_act = 0;
    var $pos_encode_last = 0;
    function ParserTask($interpreter) {
        $this->interpreter =& $interpreter;
    }
    function setText($text) {
        $this->text = $text;
        return TAGPARSER_RET_OK;
    }
    function Reset() {
        $this->errarr = array();
        return TAGPARSER_RET_OK;
    }
    function Parse($text=NULL) {
        if($text!==NULL) {
            $this->text = $text;
        }
        return $this->interpreter->parser->Parse($this);
    }
    function ErrorPush($err) {
        $this->errarr[] = $err;
    }
    function ErrorShow() {
        reset($this->errarr);
        while(list($tempkey, $tempval) = each($this->errarr)) {
            echo $tempval->Show();
            echo '<br />';
            echo "\n";
        }
    }
}
class ParserRun {
    var $task = null;
    var $st = array();
    var $pos_act = 0;
    var $pos_encode_last = 0;
    function ParserRun($task) {
        $this->task = $task;
    }
}
class ParserEvent {
    var $tag_start = NULL;
    var $tag_end = NULL;
    var $name = '';
    function ParserEvent($tag_start, $tag_end, $name) {
        $this->tag_start = $tag_start;
        $this->tag_end = $tag_end;
        $this->name = $name;
    }
    function Offset($offset) {
        $this->tag_start += $offset;
        $this->tag_end += $offset;
    }
}
class ParserEventTag extends ParserEvent {
    var $options = array();
    function setOptions($opt) {
        $this->options = $opt;
    }
}
class ParserEventTagEnd extends ParserEvent {
}
class ParserErrorContext {
    var $error;
    var $pos = NULL;
    var $text = NULL;
    var $tag = NULL;
    function ParserErrorContext($error) {
        $this->error = $error;
    }
    function GrabContext($task, $tag=NULL) {
        $this->pos = $task->pos_act;
        $this->text = substr($task->text, $task->pos_act-10, $task->pos_act+20);
        if($tag!==NULL) {
            $this->tag = $tag;
            $this->pos = $tag->tag_start;
            $tag_len = $tag->tag_end-$tag->tag_start+1;
            $this->text = substr($task->text, $tag->tag_start, $tag_len);
        }
    }
    function Show() {
        echo 'ERROR:'.$this->error.' @'.$this->pos.' near "'.$this->text.'"';
    }
}
