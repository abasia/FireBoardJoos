<?php
/**
* @version $Id: forummsg.php 387 2007-10-01 09:11:08Z florut $
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
?>
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
<table class = "fb_blocktable " id="fb_userprfmsg" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
    <thead>
        <tr>
            <th colspan = "6" align="left">
                <div class = "fb_title_cover  fbm">
                    <span class="fb_title fbxl"><?php echo _FB_USERPROFILE_MESSAGES; ?></span>
                </div>
                <img id = "BoxSwitch_fbuserprofile__<?php echo $boardclass ;?>fbuserprofile_tbody" class = "hideshow" src = "<?php echo JB_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
        </tr>
    </thead>
    <tbody id = "<?php echo $boardclass ;?>fbuserprofile_tbody">
        <tr  class = "fb_sth fbs">
            <th class = "th-1 <?php echo $boardclass ;?>sectiontableheader" align="center" width="1%">&nbsp;
            </th>
            <th class = "th-2 <?php echo $boardclass ;?>sectiontableheader"  align="left" width="44%"><?php echo _FB_USERPROFILE_TOPICS; ?>
            </th>
            <th class = "th-3 <?php echo $boardclass ;?>sectiontableheader" align="left" width="30%"><?php echo _FB_USERPROFILE_CATEGORIES; ?>
            </th>
            <th class = "th-4 <?php echo $boardclass ;?>sectiontableheader" align="center" width="5%"><?php echo _FB_USERPROFILE_HITS; ?>
            </th>
            <th class = "th-5 <?php echo $boardclass ;?>sectiontableheader"  align="left" width="20%"><?php echo _FB_USERPROFILE_DATE; ?>
            </th>
            <th class = "th-6 <?php echo $boardclass ;?>sectiontableheader" align="center" width="1%">&nbsp;
            </th>
        </tr>
        <?php
        $topic_emoticons = array ();
		$topic_emoticons[0] = JB_URLEMOTIONSPATH . 'default.gif';
		$topic_emoticons[1] = JB_URLEMOTIONSPATH . 'default.gif';
		$topic_emoticons[2] = JB_URLEMOTIONSPATH . 'exclam.gif';
		$topic_emoticons[3] = JB_URLEMOTIONSPATH . 'question.gif';
		$topic_emoticons[4] = JB_URLEMOTIONSPATH . 'arrow.gif';
		$topic_emoticons[5] = JB_URLEMOTIONSPATH . 'love.gif';
		$topic_emoticons[6] = JB_URLEMOTIONSPATH . 'grin.gif';
		$topic_emoticons[7] = JB_URLEMOTIONSPATH . 'shock.gif';
		$topic_emoticons[8] = JB_URLEMOTIONSPATH . 'smile.gif';
		$topic_emoticons[9] = JB_URLEMOTIONSPATH . 'poll.gif';
        $pageperlistlm = 15;
        $limit = intval(trim(mosGetParam($_REQUEST, 'limit', $pageperlistlm)));
        $limitstart = intval(trim(mosGetParam($_REQUEST, 'limitstart', 0)));
        $query = "select gid from #__users where id=$my->id";
        $database->setQuery($query);
        $database->query();
        $dse_groupid = $database->loadObjectList();
        if (count($dse_groupid)) {
            $group_id = $dse_groupid[0]->gid;
        }
        else {
            $group_id = 0;
        }
        $query
            = "SELECT a.* , b.id as category, b.name as catname, c.hits AS 'threadhits' FROM #__fb_messages AS a, "
            . "\n #__fb_categories AS b, #__fb_messages AS c, #__fb_messages_text AS d"
            . "\n WHERE a.catid = b.id AND b.admin_recurse=1" . "\n AND a.thread = c.id"
            . "\n AND a.id = d.mesid" . "\n AND a.hold = 0 AND b.published = 1" . "\n AND a.userid=$userid" . "\n AND (b.pub_access<='$group_id') ";
        $database->setQuery($query);
        $total = count($database->loadObjectList());

        if ($total <= $limit) {
            $limitstart = 0;
        }
        $query
            = "SELECT a.* , b.id as category, b.name as catname, c.hits AS 'threadhits'" . "\n FROM #__fb_messages AS a, " . "\n #__fb_categories AS b, #__fb_messages AS c, #__fb_messages_text AS d" . "\n WHERE a.catid = b.id AND b.admin_recurse=1"
            . "\n AND a.thread = c.id" . "\n AND a.id = d.mesid" . "\n AND a.hold = 0 AND b.published = 1" . "\n AND a.userid=$userid" . "\n AND (b.pub_access<='$group_id') " . "\n ORDER BY time DESC" . "\n LIMIT $limitstart, $limit";
        $database->setQuery($query);
        $items = $database->loadObjectList();
        require ("$mosConfig_absolute_path/includes/pageNavigation.php");
        $pageNav = new mosPageNav($total, $limitstart, $limit);
        if (count($items) > 0)
        {
            $tabclass = array
            (
                "sectiontableentry1",
                "sectiontableentry2"
            );
            $k = 0;
            foreach ($items AS $item)
            {
                $k = 1 - $k;
                if (!ISSET($item->created))
                    $item->created = "";
                $fbURL = sefRelToAbs("index.php?option=com_fireboard&amp;func=view".FB_FB_ITEMID_SUFFIX."&amp;catid=" . $item->catid . "&amp;id=" . $item->id . "#" . $item->id);
                $fbCatURL = sefRelToAbs("index.php?option=com_fireboard".FB_FB_ITEMID_SUFFIX."&amp;func=showcat&amp;catid=" . $item->catid);
        ?>
            <tr class = "<?php echo ''.$boardclass.''. $tabclass[$k] . ''; ?> ">
                <td class = "td-1  fbm"  align="center"><?php echo "<img src=\"" . $topic_emoticons[$item->topic_emoticon] . "\" alt=\"emo\" />"; ?>
                </td>
                <td class = "td-2  fbm"  align="left">
                        <a  class="fb-topic-title fbm"  href = "<?php echo $fbURL; ?>"> <?php echo stripslashes ($item->subject); ?> </a>
                </td>
                <td class = "td-3 fbm" align="left">
                        <a  class="fb-topic-cat fbm" href = "<?php echo $fbCatURL; ?>"> <?php echo $item->catname; ?></a>
                </td>
                <td class = "td-4 fbm" align="center"><?php echo $item->threadhits; ?>
                </td>
                <td class = "td-5  fbs" align="left">
                  <div class="fb-latest-subject-date fbs">
<?php echo '' . date(_DATETIME, $item->time) . ''; ?>
                  </div>
                </td>
                <td class = "td-6  fbm" align="center">
                    <a href = "<?php echo $fbURL; ?>"> <?php
    echo $fbIcons['latestpost'] ? '<img src="'
             . JB_URLICONSPATH . '' . $fbIcons['latestpost'] . '" border="0" alt="' . _SHOW_LAST . '" title="' . _SHOW_LAST . '" />' : '  <img src="' . JB_URLEMOTIONSPATH . 'icon_newest_reply.gif" border="0"   alt="' . _SHOW_LAST . '" />'; ?> </a>
                </td>
            </tr>
        <?php
            }
        }
        else
        {
        ?>
            <tr>
                <td colspan = "6" class = "<?php echo $boardclass ;?>profile-bottomnav" align="center">
                    <br/>
                    <b><?php echo _FB_USERPROFILE_NOFORUMPOSTS; ?></b>
                    <br/>
                    <br/>
                </td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan = "6" class = "<?php echo $boardclass ;?>profile-bottomnav  fbm " align="center">
                <?php
                echo $pageNav->writePagesLinks("index.php?option=com_fireboard&amp;func=fbprofile&amp;task=showprf&amp;userid=$userid".FB_FB_ITEMID_SUFFIX);
                ?>
<?php
echo $pageNav->writeLimitBox("index.php?option=com_fireboard&amp;func=fbprofile&amp;task=showprf&amp;userid=$userid" . FB_FB_ITEMID_SUFFIX . "");
?>
                <br/>
<?php echo $pageNav->writePagesCounter(); ?>
            </td>
        </tr>
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>