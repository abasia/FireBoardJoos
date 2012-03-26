<?php
/**
* @version 1.0
* @package FireboardRE
* @copyright (C) 2008 Adeptus
*/
	header("Cache-Control: no-cache");
	header("Pragma: nocache");
	header("Content-Type: text/html; charset=\"windows-1251\"");
	define( '_VALID_MOS', 1 );
	Error_Reporting(E_ERROR);
	require( '../../../../../globals.php' );
	require_once( '../../../../../configuration.php' );
	require_once( '../../../../../includes/joomla.php' );
	require_once( '../../../../../includes/database.php' );
	global $mosConfig_live_site,$database,$mosConfig_absolute_path,$mosConfig_lang,$mosConfig_dbprefix;
	$gid = intval(mosGetParam($_POST, 'gid'));
	$new = mosGetParam($_POST, 'update_value', '');
	$newtitle = utf2win1251($new);
	if ($gid && $newtitle)
	{
		$database->setQuery("UPDATE ".$mosConfig_dbprefix."fb_ranks SET rank_title='".$newtitle."' WHERE rank_id=$gid");
		$aaa = $database->loadResult();
	}
	//print_r($_POST);*/
	//echo $_POST['update_value'];
	echo $newtitle;
function utf2win1251($content)
{
	$newcontent = "";
	for ($i = 0; $i < strlen($content); $i++)
	{
		$c1 = substr($content, $i, 1);
		$byte1 = ord($c1);
		if ($byte1>>5 == 6)
		{
			$i++;
            $c2 = substr($content, $i, 1);
            $byte2 = ord($c2);
            $byte1 &= 31;
            $byte2 &= 63;
            $byte2 |= (($byte1 & 3) << 6);
            $byte1 >>= 2;
            $word = ($byte1<<8) + $byte2;
			if ($word == 1025) $newcontent .= chr(168);
            else if ($word == 1105) $newcontent .= chr(184);
            else if ($word >= 0x0410 && $word <= 0x044F) $newcontent .= chr($word-848);
            else
            {
            	$a = dechex($byte1);
                $a = str_pad($a, 2, "0", STR_PAD_LEFT);
                $b = dechex($byte2);
                $b = str_pad($b, 2, "0", STR_PAD_LEFT);
                $newcontent .= "".$a.$b.";";
			}
		}
        else $newcontent .= $c1;
	}
	return $newcontent;
}
