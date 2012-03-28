<?php
/**
* @version $Id: fb_rss.php 487 2007-12-13 14:41:10Z danialt $
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
defined ('_VALID_MOS') or die('Direct Access to this location is not allowed.');
$database = FBJConfig::database();
$mainframe = FBJConfig::mainframe();
$my = FBJConfig::my();
$mosConfig_absolute_path = FBJConfig::getCfg('absolute_path');

include ($mosConfig_absolute_path . "/components/com_fireboard/template/default/smile.class.php");
$now = date("Y-m-d H:i:s", FBTools::fbGetShowTime());
$menu = new mosMenu($database);
$menu->load(1);
$params = mosParseParams($menu->params);
$count = isset($params->count) ? $params->count : 6;
$intro = isset($params->intro) ? $params->intro : 3;
$orderby = @$params->orderby;
$_texts = '';
switch (strtolower($orderby))
{
    case 'date':
        $orderby = "a.created";
        break;
    case 'rdate':
        $orderby = "a.created DESC";
        break;
    default:
        $orderby = "f.ordering, a.ordering ASC, a.catid, a.sectionid";
        break;
}
$database->setQuery("SELECT a. * , b.id as category, b.published as published, c.message as message" . "\n FROM #__fb_messages AS a LEFT JOIN "
                        . "\n #__fb_categories AS b on a.catid = b.id LEFT JOIN"
                        . "\n #__fb_messages_text AS c ON a.id = c.mesid"
                        . "\n WHERE a.hold = 0 AND b.published = 1"
                        . "\n AND b.pub_access = 0"
                        . "\n ORDER  BY a.time DESC "
                        . "\n LIMIT 10 ");
$rows = $database->loadObjectList();
header ('Content-type: application/xml');
$encoding = explode("=", _ISO);
echo "<?xml version=\"1.0\" encoding=\"" . $encoding[1] . "\"?>";
?>
<!DOCTYPE rss PUBLIC "-//Netscape Communications//DTD RSS 0.91//EN" "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<!-- Mambo Open Source 4.5 RSS Generator Version 2.07 (12/10/2003) - Robert Castley -->
<!-- Changed for use with fireboard (10/04/2004) -->
<!-- Copyright (C) 2000-2003 - <?php echo $mosConfig_sitename; ?> -->
<rss version = "0.91">
    <channel>
        <title><?php echo stripslashes(htmlspecialchars($mosConfig_sitename)); ?> - Forum</title>
        <link><?php echo $mosConfig_live_site; ?></link>
        <description>
<?php echo $option ?>
        </description>
        <language>
            en-us
        </language>
        <lastBuildDate>
            <?php
            $date = date("r");
            echo "$date";
            ?>
        </lastBuildDate>
        <image>
        <title>Powered by FireboardRE</title>
        <url>
		<?php echo JB_URLEMOTIONSPATH; ?>fb_rsspower.gif
        </url>
        <link><?php echo $mosConfig_live_site; ?></link>
        <width>
            88
        </width>
        </image>
        <?php
        foreach ($rows as $row)
        {
            echo ("<item>");
            echo ("<title>" . _GEN_SUBJECT . ": " . stripslashes(htmlspecialchars($row->subject)) . " - " . _GEN_BY . ": " . stripslashes(htmlspecialchars($row->name)) . "</title>" . "\n");
            echo "<link>";
            if ($mosConfig_sef == "1") {
                echo sefRelToAbs(JB_LIVEURLREL . "&amp;func=view&amp;id=" . $row->id . "&amp;catid=" . $row->catid);
            }
            else {
                echo $mosConfig_live_site . "/index.php?option=com_fireboard" . FB_FB_ITEMID_SUFFIX . "&amp;func=view&amp;id=" . $row->id . "&amp;catid=" . $row->catid;
            }

            echo "</link>\n";
            $words = $row->message;
            $words = smile::purify($words);
            echo ("<description>" . htmlspecialchars(substr($words, 0, 512)) . "...</description>" . "\n");
            echo ("</item>" . "\n");
        }
        ?>
    </channel>
</rss>