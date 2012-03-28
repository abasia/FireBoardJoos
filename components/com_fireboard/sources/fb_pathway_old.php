<?php
/**
* @version $Id: fb_pathway_old.php 462 2007-12-10 00:05:53Z fxstein $
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
$fbConfig = FBJConfig::getInstance();
?>
<table border = "0" cellspacing = "0" cellpadding = "0" width = "100%" class = "contentpane">
    <tr>
        <td>
            <div>
                <?php
                $catids = intval($catid);
                $parent_ids = 1000;
                while ($parent_ids)
                {
                    $query = "select * from #__fb_categories where id=$catids and published=1";
                    $database->setQuery($query);
                    $results = $database->query();
                    $parent_ids = @mysql_result($results, 0, 'parent');
                    $sname = "<a href='" . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catids) . "'>" . @mysql_result($results, 0, 'name') . "</a>";
                    if (empty($spath)) {
                        $spath = $sname;
                    }
                    else {
                        $spath = $sname . ' » ' . $spath;
                    }
                    $catids = $parent_ids;
                }
                $shome = '<a href="' . sefRelToAbs(JB_LIVEURLREL) . '">' . _GEN_FORUMLIST . '</a> ';
                $pathNames = $shome . ' » ' . $spath . " ";
                echo $pathNames;
                $database->setQuery("SELECT name,locked,review,id, description, parent from #__fb_categories where id='$catid'");
                $database->loadObject($objCatInfo);
                $database->setQuery("SELECT name,id FROM #__fb_categories WHERE id='$objCatInfo->parent'");
                $database->loadObject($objCatParentInfo);
                $mainframe->setPageTitle($objCatParentInfo->name . ' - ' . $objCatInfo->name . ' - ' . $fbConfig->board_title);
                $forumLocked = $objCatInfo->locked;
                $forumReviewed = $objCatInfo->review;
                if ($forumLocked)
                {
                    echo $fbIcons->forumlocked ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->forumlocked
                             . '" border="0" alt="' . _GEN_LOCKED_FORUM . '" title="' . _GEN_LOCKED_FORUM . '"/>' : '  <img src="' . JB_URLEMOTIONSPATH . 'lock.gif"  border="0"   alt="' . _GEN_LOCKED_FORUM . '" title="' . _GEN_LOCKED_FORUM . '">';
                    $lockedForum = 1;
                }
                else {
                    echo "";
                }

                if ($forumReviewed)
                {
                    echo $fbIcons->forummoderated ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->forummoderated
                             . '" border="0" alt="' . _GEN_MODERATED . '" title="' . _GEN_MODERATED . '"/>' : '  <img src="' . JB_URLEMOTIONSPATH . 'review.gif" border="0"  alt="' . _GEN_MODERATED . '" title="' . _GEN_MODERATED . '">';
                    $moderatedForum = 1;
                }
                else {
                    echo "";
                }
                ?>
            </div>
        </td>
    </tr>
</table>