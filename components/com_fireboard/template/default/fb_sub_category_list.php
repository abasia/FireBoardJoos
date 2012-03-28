<?php
/**
* @version $Id: fb_sub_category_list.php 462 2007-12-10 00:05:53Z fxstein $
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
<?php
$database->setQuery("SELECT id, name, locked,review, pub_access, pub_recurse, admin_access, admin_recurse FROM #__fb_categories WHERE parent='$catid'  and published='1' order by ordering");
$rows = $database->loadObjectList();
$tabclass = array
(
    "sectiontableentry1",
    "sectiontableentry2"
);
$k = 0;
if (sizeof($rows) == 0)
    ;
else
{
?>
    <!-- B: List Cat -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
    <table class = "fb_blocktable<?php echo $objCatInfo->class_sfx; ?>"  width="100%" id = "fb_cat<?php echo $objCatInfo->id ; ?>"  border = "0" cellspacing = "0" cellpadding = "0">
        <thead>
            <tr>
                <th colspan = "5" align="left">
                    <div class = "fb_title_cover fbm" >
                        <?php
                        echo '<a class="fb_title fbxl" href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $objCatInfo->id) . '">' . $objCatInfo->name . '</a>';
                        if ($objCatInfo->description != "") {
                            echo '' . $objCatInfo->description . '';
                        }
                        ?>
                    </div>
                    <img id = "BoxSwitch_<?php echo $objCatInfo->id ; ?>__catid_<?php echo $objCatInfo->id ; ?>" class = "hideshow" src = "<?php echo JB_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
                </th>
            </tr>
        </thead>
        <tbody id = "catid_<?php echo $objCatInfo->id ; ?>">
           <tr class = "fb_sth fbs ">
                        <th class = "th-1 <?php echo $boardclass; ?>sectiontableheader" width="1%">&nbsp;</th>
                        <th class = "th-2 <?php echo $boardclass; ?>sectiontableheader" align="left"><?php echo _GEN_FORUM; ?></th>
                        <th class = "th-3 <?php echo $boardclass; ?>sectiontableheader" align="center" width="5%"><?php echo _GEN_TOPICS; ?></th>
                        <th class = "th-4 <?php echo $boardclass; ?>sectiontableheader" align="center" width="5%">
<?php echo _GEN_REPLIES; ?>
                        </th>
                        <th class = "th-5 <?php echo $boardclass; ?>sectiontableheader" align="left" width="25%">
<?php echo _GEN_LAST_POST; ?>
                        </th>
                    </tr>
            <?php
            foreach ($rows as $singlerow)
            {
                $obj_fb_cat = new jbCategory($database, $singlerow->id);
                $is_Mod = fb_has_moderator_permission($database, $obj_fb_cat, $my->id, $is_admin);
                $letPass = 0;
                if (!$is_Mod)
                    $letPass = fb_has_read_permission($obj_fb_cat, $allow_forum, $aro_group->group_id, $acl);

                if ($letPass || $is_Mod)
                {
                    if ($allowed_forums == "") {
                        $allowed_forums = $singlerow->id;
                    }
                    else {
                        $allowed_forums = $allowed_forums . ',' . $singlerow->id;
                    }

                    $database->setQuery("UPDATE #__fb_sessions SET allowed='$allowed_forums' WHERE userid=$my->id");
                    $database->query();
                    $k = 1 - $k;
                    $database->setQuery("SELECT id FROM #__fb_messages WHERE catid='$singlerow->id' and parent='0' and hold='0'");
                    $num = $database->loadObjectList();
                    $numtopics = count($num);
                    $database->setQuery("SELECT id FROM #__fb_messages WHERE catid='$singlerow->id' and parent!='0' and hold='0'");
                    $num = $database->loadObjectList();
                    $numreplies = count($num);
                    $database->setQuery("SELECT MAX(time) from #__fb_messages WHERE catid='$singlerow->id' and hold='0' AND moved!='1'");
                    $lastPosttime = $database->loadResult();
                    $lastptime = FB_timeformat(FBTools::fbGetShowTime($lastPosttime));
                    $lastPosttime = (int)$lastPosttime;
                    if ($my->id != 0)
                    {
                        $database->setQuery("SELECT thread from #__fb_messages where catid='$singlerow->id' and hold='0' and time>$prevCheck group by thread");
                        $newThreadsAll = $database->loadObjectList();
                        if (count($newThreadsAll) == 0)
                            $newThreadsAll = array ();
                        $readTopics = "";
                        $database->setQuery("SELECT readtopics FROM #__fb_sessions WHERE userid=$my->id");
                        $readTopics = $database->loadResult();
                        $read_topics = explode(',', $readTopics);
                    }
                    $database->setQuery("SELECT description from #__fb_categories where id='$singlerow->id'");
                    $forumDesc = $database->loadResult();
                    $database->setQuery("SELECT id, name from #__fb_categories WHERE  parent='$singlerow->id'  AND published =1 ");
                    $forumparents = $database->loadObjectList();
                    $database->setQuery("SELECT userid FROM #__fb_moderation WHERE catid='$singlerow->id'");
                    $moderatorList = $database->loadObjectList();
                    $modIDs[] = array ();
                    array_splice($modIDs, 0);
                    if (count($moderatorList) > 0)
                    {
                        foreach ($moderatorList as $ml) {
                            $modIDs[] = $ml->userid;
                        }
                    }
                    $nummodIDs = count($modIDs);
                    $numPending = 0;
                    if ((in_array($my_id, $modIDs)) || $is_admin == 1)
                    {
                        $database->setQuery("select count(*) from #__fb_messages where catid='$singlerow->id' and hold='1'");
                        $numPending = $database->loadResult();
                        $is_Mod = 1;
                    }
                    $numPending = (int)$numPending;
                    $latestname = "";
                    $latestcatid = "";
                    $latestid = "";
                    if ($lastPosttime != 0)
                    {
                        unset($obj_lp);
                        $database->setQuery("SELECT id, catid,name, subject, userid from #__fb_messages WHERE time=$lastPosttime and hold='0' and moved!='1' LIMIT 1");
                        $database->loadObject($obj_lp);
                        $latestname = $obj_lp->name;
                        $latestcatid = $obj_lp->catid;
                        $latestid = $obj_lp->id;
                        $latestsubject = stripslashes($obj_lp->subject);
                        $latestuserid = $obj_lp->userid;
                    }

                    echo '<tr class="' . $boardclass . '' . $tabclass[$k] . '" id="fb_cat'.$singlerow->id.'" >';
					echo '<td class="td-1 " align="center">';
					echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $singlerow->id) . '">';
                    if ($fbConfig->showNew && $my->id != 0)
                    {
                        $newPostsAvailable = 0;
                        foreach ($newThreadsAll as $nta)
                        {
                            if (!in_array($nta->thread, $read_topics)) {
                                $newPostsAvailable++;
                            }
                        }
                        if ($newPostsAvailable > 0 && count($newThreadsAll) != 0)
                        {
                            $cxThereisNewInForum = 1;
                            if (is_file(JB_ABSCATIMAGESPATH . "" . $singlerow->id . "_on.gif")) {
                                echo "<img src=\"" . JB_URLCATIMAGES . "" . $singlerow->id . "_on.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                            }
                            else {
                                echo $fbIcons->unreadforum ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->unreadforum . '" border="0" alt="' . _GEN_FORUM_NEWPOST . '" title="' . _GEN_FORUM_NEWPOST . '"/>' : $fbConfig->newChar;
                            }
                        }
                        else
                        {
                            if (is_file(JB_ABSCATIMAGESPATH . "" . $singlerow->id . "_off.gif")) {
                                echo "<img src=\"" . JB_URLCATIMAGES . "" . $singlerow->id . "_off.gif\" border=\"0\" class='forum-cat-image' alt=\" \"  />";
                            }
                            else {
                                echo $fbIcons->readforum ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->readforum . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '"/>' : $fbConfig->newChar;
                            }
                        }
                    }
                    else
                    {
                        if (is_file(JB_ABSCATIMAGESPATH . "" . $singlerow->id . "_notlogin.gif")) {
                            echo "<img src=\"" . JB_URLCATIMAGES . "" . $singlerow->id . "_notlogin.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                        }
                        else {
                            echo $fbIcons->notloginforum ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->notloginforum . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '"/>' : $fbConfig->newChar;
                        }
                    }
					echo '</a>';
					echo '</td>';
                    echo '<td class="td-2"  align="left"><div class="'
                             . $boardclass . 'thead-title fbl"><a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $singlerow->id) . '">' . $singlerow->name . '</a>';
                    if ($cxThereisNewInForum == 1 && $my->id > 0) {
                        echo '<img src="'.JB_URLICONSPATH.''.$fbIcons->favoritestar.'" border="0" alt="'._FB_MYPROFILE_NEW_MESSAGE.'"/>&nbsp;<span style="font-size:10px;">('.$newPostsAvailable.')</span>';
                    }
                    $cxThereisNewInForum = 0;
                    if ($singlerow->locked)
                    {
                        echo
                            $fbIcons->forumlocked ? '&nbsp;&nbsp;<img src="' . JB_URLICONSPATH . ''
                                . $fbIcons->forumlocked . '" border="0" alt="' . _GEN_LOCKED_FORUM . '" title="' . _GEN_LOCKED_FORUM . '"/>' : '&nbsp;&nbsp;<img src="' . JB_URLEMOTIONSPATH . 'lock.gif"  border="0" alt="' . _GEN_LOCKED_FORUM . '">';
                        $lockedForum = 1;
                    }
                    if ($singlerow->review)
                    {
                        echo $fbIcons->forummoderated ? '&nbsp;&nbsp;<img src="' . JB_URLICONSPATH . ''
                                 . $fbIcons->forummoderated . '" border="0" alt="' . _GEN_MODERATED . '" title="' . _GEN_MODERATED . '"/>' : '&nbsp;&nbsp;<img src="' . JB_URLEMOTIONSPATH . 'review.gif" border="0"  alt="' . _GEN_MODERATED . '"/>';
                        $moderatedForum = 1;
                    }
                    echo '</div>';
                    if ($forumDesc != "") {
                        echo '<div class="' . $boardclass . 'thead-desc  fbm">' . $forumDesc . ' </div>';
                    }
                    if (count($forumparents) > 0)
                    {
                        if(count($forumparents)==1) {
                          echo '<div class="' . $boardclass . 'thead-child  fbs"><b>' . _FB_CHILD_BOARD . ' </b>';
                        } else {
                          echo '<div class="' . $boardclass . 'thead-child  fbs"><b>' . _FB_CHILD_BOARDS . ' </b>';
                        };

                        foreach ($forumparents as $forumparent)
                        {
                            if ($fbConfig->showChildCatIcon)
                            {
                                if ($fbConfig->showNew && $my->id != 0)
                                {
                                    $database->setQuery("SELECT thread from #__fb_messages where catid='$forumparent->id' and hold='0' and time>$prevCheck group by thread");
                                    $newPThreadsAll = $database->loadObjectList();
                                    if (count($newPThreadsAll) == 0)
                                        $newPThreadsAll = array ();
                                    $newPPostsAvailable = 0;
                                    foreach ($newPThreadsAll as $npta)
                                    {
                                        if (!in_array($npta->thread, $read_topics)) {
                                            $newPPostsAvailable++;
                                        }
                                    }
                                    if ($newPPostsAvailable > 0 && count($newPThreadsAll) != 0)
                                    {
                                        if (is_file(JB_ABSCATIMAGESPATH . "" . $forumparent->id . "_on_childsmall.gif")) {
                                            echo "<img src=\"" . JB_URLCATIMAGES . "" . $forumparent->id . "_on_childsmall.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                        }
                                        else {
                                            echo $fbIcons->unreadforum
                                                     ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->unreadforum_childsmall . '" border="0" alt="' . _GEN_FORUM_NEWPOST . '" title="' . _GEN_FORUM_NEWPOST . '" />' : $fbConfig->newChar;
                                        }
                                    }
                                    else
                                    {
                                        if (is_file(JB_ABSCATIMAGESPATH . "" . $forumparent->id . "_off_childsmall.gif")) {
                                            echo "<img src=\"" . JB_URLCATIMAGES . "" . $forumparent->id . "_off_childsmall.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                        }
                                        else {
                                            echo $fbIcons->readforum
                                                     ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->readforum_childsmall . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '" />' : $fbConfig->newChar;
                                        }
                                    }
                                }
                                else
                                {
                                    if (is_file(JB_ABSCATIMAGESPATH . "" . $forumparent->id . "_notlogin_childsmall.gif")) {
                                        echo "<img src=\"" . JB_URLCATIMAGES . "" . $forumparent->id . "_notlogin_childsmall.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                    }
                                    else {
                                        echo $fbIcons->notloginforum
                                                 ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons->notloginforum_childsmall . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '" />' : $fbConfig->newChar;
                                    }
                                }
                            }
                            echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $forumparent->id) . '">' . $forumparent->name . '</a> &nbsp;';
                        }
                        echo "</div>";
                    }
                    $database->setQuery("select * from #__fb_moderation left join #__users on #__users.id=#__fb_moderation.userid where #__fb_moderation.catid=$singlerow->id");
                    $modslist = $database->loadObjectList();
                    if (count($modslist) > 0)
                    {
                        echo '<div class="' . $boardclass . 'thead-moderators  fbs">' . _GEN_MODERATORS . ": ";
                        foreach ($modslist as $mod) {
                             echo '&nbsp;<a href = "' . sefRelToAbs(FB_PROFILE_LINK_SUFFIX.''.$mod->userid).'">'.$mod->username.'</a>&nbsp; ';
                        }
                        echo '</div>';
                    }
                    if ($is_moderator)
                    {
                        if ($numPending > 0)
                        {
                            echo '<div class="fbs" ><span style="color:red">';
                            echo ' <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=review&amp;action=list&amp;catid=' . $singlerow->id) . '" >';
                            echo '' . $numcolor . '' . $numPending . ' ' . _SHOWCAT_PENDING;
                            echo '</a></span></div>';
                        }
                    }
                    echo "</td>";
                    echo " <td class=\"td-3  fbm\" align=\"center\" >$numtopics</td>";
                    echo " <td class=\"td-4  fbm\" align=\"center\" >$numreplies</td>";
                    if ($numtopics != 0)
                    {
            ?>
                        <td class = "td-5" align="left">
                            <div class = "<?php echo $boardclass ?>latest-subject fbm">
                                <a href = "<?php echo sefRelToAbs(JB_LIVEURLREL.'&amp;func=view&amp;catid='.$latestcatid.'&amp;id='.$latestid).'#'.$latestid;?>"><?php echo $latestsubject; ?></a>
                            </div>
                            <div class = "<?php echo $boardclass ?>latest-subject-by  fbs">
<?php echo _GEN_BY; ?>
 <a href = "<?php echo sefRelToAbs(FB_PROFILE_LINK_SUFFIX.''.$latestuserid)?>"><?php echo $latestname; ?></a>
                    | <?php echo $lastptime; ?> <a href = "<?php echo sefRelToAbs(JB_LIVEURLREL.'&amp;func=view&amp;catid='.$latestcatid.'&amp;id='.$latestid).'#'.$latestid;?>"> <?php
    echo $fbIcons->latestpost ? '<img src="'
             . JB_URLICONSPATH . '' . $fbIcons->latestpost . '" border="0" alt="' . _SHOW_LAST . '" title="' . _SHOW_LAST . '" />' : '  <img src="' . JB_URLEMOTIONSPATH . 'icon_newest_reply.gif" border="0"   alt="' . _SHOW_LAST . '" />'; ?> </a>
                            </div>
                        </td>
                        </tr>
            <?php
                    }
                    else {
                        echo ' <td class="td-5"  align="left">' . _NO_POSTS . '</td></tr>';
                    }
                }
            }
            ?>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<?php
}
?>