<?php
/**
* @version $Id: listcat.php 462 2007-12-10 00:05:53Z fxstein $
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
global $fbConfig;
$catid = (int)$catid;
$moderatedForum = 0;
$lockedForum = 0;
$database->setQuery("SELECT group_id FROM #__fb_users WHERE userid=$my->id");
$mygroup = $database->loadResult();
if ($mygroup == 2)
{
	$database->setQuery("SELECT * FROM #__fb_categories WHERE parent= 0 and published=1 ORDER BY ordering");
}
elseif (!$mygroup)
{
	$database->setQuery("SELECT * FROM #__fb_categories WHERE parent= 0 and published=1 AND admin_recurse=1 ORDER BY ordering");
}
else
{
	$database->setQuery("SELECT * FROM #__fb_categories WHERE parent= 0 and published=1 AND (admin_recurse=1 OR admin_recurse=".$mygroup.") ORDER BY ordering");
}
$allCat = $database->loadObjectList();
$threadids = array ();
$categories = array ();
$mainframe->setPageTitle(_GEN_FORUMLIST . ' - ' . $fbConfig['board_title']);
if (count($allCat) > 0)
{
    foreach ($allCat as $category)
    {
        $threadids[] = $category->id;
        $categories[$category->parent][] = $category;
    }
}
if (in_array($catid, $threadids))
{
    unset ($threadids);
    $threadids[] = $catid;
    unset ($categories);
	if ($mygroup == 2)
	{
		$database->setQuery("SELECT * FROM #__fb_categories WHERE parent= '0' and published='1' and id='$catid' ORDER BY ordering");
	}
	elseif (!$mygroup)
	{
		$database->setQuery("SELECT * FROM #__fb_categories WHERE parent= '0' and published='1' and id='$catid' and admin_recurse=1 ORDER BY ordering");
	}
	else
	{
		$database->setQuery("SELECT * FROM #__fb_categories WHERE parent= '0' and published='1' and id='$catid' and (admin_recurse=1 OR admin_recurse=".$mygroup.") ORDER BY ordering");
	}
    $categories[$category->parent] = $database->loadObjectList();
}
if ($fbSession->allowed != "na" && !$new_fb_user) {
    $allow_forum = explode(',', $fbSession->allowed);
}
else {
    $allow_forum = array ();
}
if ($fbConfig['showAnnouncement'] > 0)
{
    if (file_exists(JB_ABSTMPLTPATH . '/plugin/announcement/announcementbox.php')) {
        require_once (JB_ABSTMPLTPATH . '/plugin/announcement/announcementbox.php');
    }
    else {
        require_once (JB_ABSPATH . '/template/default/plugin/announcement/announcementbox.php');
    }
}
if (mosCountModules('fb_2'))
{
?>
    <div class = "fb-fb_2">
        <?php
        mosLoadModules('fb_2', -3);
        ?>
    </div>

<?php
}
if (file_exists(JB_ABSTMPLTPATH . '/fb_pathway.php')) {
    require_once (JB_ABSTMPLTPATH . '/fb_pathway.php');
}
else {
    require_once (JB_ABSPATH . '/template/default/fb_pathway.php');
}
if (count($categories[0]) > 0)
{
    foreach ($categories[0] as $cat)
    {
        $obj_fb_cat = new jbCategory($database, $cat->id);

        $is_Mod = fb_has_moderator_permission($database, $obj_fb_cat, $my->id, $is_admin);
        $letPass = 0;
        if (!$is_Mod) {
            $letPass = fb_has_read_permission($obj_fb_cat, $allow_forum, $aro_group->group_id, $acl);
        }

        if ($letPass || $is_Mod)
        {
            if (empty($allowed_forums)) {
                $allowed_forums = $cat->id;
            }
            else {
                $allowed_forums = $allowed_forums . ',' . $cat->id;
            }
            if ($my->id)
            {
                $database->setQuery("UPDATE #__fb_sessions SET allowed='$allowed_forums' WHERE userid=$my->id");
                $database->query();
            }
?>
<div class="<?php echo $boardclass; ?>_bt_cvr1" id="fb_block<?php echo $cat->id ; ?>">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
            <table class = "fb_blocktable<?php echo $cat->class_sfx; ?>"  width="100%" id = "fb_cat<?php echo $cat->id ; ?>" border = "0" cellspacing = "0" cellpadding = "0">
                <thead>
                    <tr>
                        <th colspan = "5">
                            <div class = "fb_title_cover fbm" >
                                <a  class="fb_title fbxl" href = "<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;task=listcat&amp;catid=' . $cat->id) ;?>"><?php echo $cat->name; ?></a>
                                <?php
                                if ($cat->description != "") {
                                    echo '' . $cat->description . '';
                                }
                                ?>
                            </div>
                            <img id = "BoxSwitch_<?php echo $cat->id ; ?>__catid_<?php echo $cat->id ; ?>" class = "hideshow" src = "<?php echo JB_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
                        </th>
                    </tr>
                </thead>
                <tbody id = "catid_<?php echo $cat->id ; ?>">
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
					if ($mygroup == 2)
					{
						$database->setQuery("SELECT c.*,m.subject, mm.catid as lastcat, m.name as mname, m.userid, u.username, u.name as uname FROM #__fb_categories as c left join #__fb_messages as m on c.id_last_msg = m.id left join #__users as u on u.id = m.userid left join #__fb_messages as mm on mm.id = c.id_last_msg WHERE c.parent='$cat->id' and c.published='1' order by ordering");
					}
					elseif (!$mygroup)
					{
						$database->setQuery("SELECT c.*,m.subject, mm.catid as lastcat, m.name as mname, m.userid, u.username, u.name as uname FROM #__fb_categories as c left join #__fb_messages as m on c.id_last_msg = m.id left join #__users as u on u.id = m.userid left join #__fb_messages as mm on mm.id = c.id_last_msg WHERE c.parent='$cat->id' and c.published='1' and admin_recurse=1 order by ordering");
					}
					else
					{
						$database->setQuery("SELECT c.*,m.subject, mm.catid as lastcat, m.name as mname, m.userid, u.username, u.name as uname FROM #__fb_categories as c left join #__fb_messages as m on c.id_last_msg = m.id left join #__users as u on u.id = m.userid left join #__fb_messages as mm on mm.id = c.id_last_msg WHERE c.parent='$cat->id' and c.published='1' and (admin_recurse=1 OR admin_recurse=".$mygroup.") order by ordering");
					}
                    $rows = $database->loadObjectList();
                    $tabclass = array
                    (
                        "sectiontableentry1",
                        "sectiontableentry2"
                    );
                    $k = 0;
                    if (sizeof($rows) == 0) {
                        echo '' . _GEN_NOFORUMS . '';
                    }
                    else
                    {
                        foreach ($rows as $singlerow)
                        {
                            $obj_fb_cat = new jbCategory($database, $singlerow->id);
                            $is_Mod = fb_has_moderator_permission($database, $obj_fb_cat, $my->id, $is_admin);
                            $letPass = 0;
                            if (!$is_Mod) {
                                $letPass = fb_has_read_permission($obj_fb_cat, $allow_forum, $aro_group->group_id, $acl);
                            }

                            if ($letPass || $is_Mod)
                            {
                                if ($allowed_forums == "") {
                                    $allowed_forums = $singlerow->id;
                                }
                                else {
                                    $allowed_forums = $allowed_forums . ',' . $singlerow->id;
                                }


                                if ($my->id)
                                {
                                    $database->setQuery("UPDATE #__fb_sessions SET allowed='$allowed_forums' WHERE userid=$my->id");
                                    $database->query();
                                }
                                $k = 1 - $k;
                $numtopics = $singlerow->numTopics;
                $numreplies = $singlerow->numPosts;
                $lastPosttime = $singlerow->time_last_msg;
                $lastptime = FB_timeformat(FBTools::fbGetShowTime($singlerow->time_last_msg));
                $forumDesc = $singlerow->description;
                                $database->setQuery("SELECT id, name, numTopics, numPosts from #__fb_categories WHERE  parent='$singlerow->id'  AND published =1 ");
                                $forumparents = $database->loadObjectList();
                                if ($my->id)
                                {
                                    $database->setQuery("SELECT DISTINCT thread from #__fb_messages where catid=$singlerow->id and hold=0 and time>$prevCheck group by thread");
                                    $newThreadsAll = $database->loadObjectList();
                                    if (count($newThreadsAll) == 0) {
                                        $newThreadsAll = array ();
                                    }

                                }
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
                                $latestname = $singlerow->mname;
                                    $latestcatid = $singlerow->catid;
                                    $latestid = $singlerow->id_last_msg;
                                    $latestsubject = stripslashes($singlerow->subject);
                                    $latestuserid = $singlerow->userid;

                    ?>
                                <tr class = "<?php echo ''.$boardclass.'' . $tabclass[$k] . ''; ?>" id="fb_cat<?php echo $singlerow->id ?>">
                                    <td class = "td-1" align="center">
                                    <a href = "<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $singlerow->id) ;?>">
                                        <?php
                                        if ($fbConfig['showNew'] && $my->id != 0)
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
                                                    echo $fbIcons['unreadforum']
                                                             ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['unreadforum'] . '" border="0" alt="' . _GEN_FORUM_NEWPOST . '" title="' . _GEN_FORUM_NEWPOST . '" />' : $fbConfig['newChar'];
                                                }
                                            }
                                            else
                                            {
                                                if (is_file(JB_ABSCATIMAGESPATH . "" . $singlerow->id . "_off.gif")) {
                                                    echo "<img src=\"" . JB_URLCATIMAGES . "" . $singlerow->id . "_off.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                                }
                                                else {
                                                    echo $fbIcons['readforum'] ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['readforum'] . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '" />' : $fbConfig['newChar'];
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if (is_file(JB_ABSCATIMAGESPATH . "" . $singlerow->id . "_notlogin.gif")) {
                                                echo "<img src=\"" . JB_URLCATIMAGES . "" . $singlerow->id . "_notlogin.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                            }
                                            else {
                                                echo $fbIcons['notloginforum']
                                                         ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['notloginforum'] . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '" />' : $fbConfig['newChar'];
                                            }
                                        }
                                        ?>
                                        </a>
                                    </td>
                                    <td class = "td-2" align="left">
                                        <div class = "<?php echo $boardclass ?>thead-title fbl">
                                            <a href = "<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $singlerow->id) ;?>"> <?php echo $singlerow->name; ?> </a>

                                            <?php //new posts available
                                            if ($cxThereisNewInForum == 1 && $my->id > 0) {
                                                echo '<img src="'.JB_URLICONSPATH.''.$fbIcons['favoritestar'].'" border="0" alt="'._FB_MYPROFILE_NEW_MESSAGE.'"/>&nbsp;<span style="font-size:10px;">('.$newPostsAvailable.')</span>';
                                            }
                                            $cxThereisNewInForum = 0;
                                            if ($singlerow->locked)
                                            {
                                                echo $fbIcons['forumlocked'] ? '&nbsp;&nbsp;<img src="' . JB_URLICONSPATH . '' . $fbIcons['forumlocked']
                                                         . '" border="0" alt="' . _GEN_LOCKED_FORUM . '" title="' . _GEN_LOCKED_FORUM . '"/>' : '&nbsp;&nbsp;<img src="' . JB_URLEMOTIONSPATH . 'lock.gif"  border="0" alt="' . _GEN_LOCKED_FORUM . '">';
                                                $lockedForum = 1;
                                            }

                                            if ($singlerow->review)
                                            {
                                                echo $fbIcons['forummoderated'] ? '&nbsp;&nbsp;<img src="' . JB_URLICONSPATH . '' . $fbIcons['forummoderated']
                                                         . '" border="0" alt="' . _GEN_MODERATED . '" title="' . _GEN_MODERATED . '"/>' : '&nbsp;&nbsp;<img src="' . JB_URLEMOTIONSPATH . 'review.gif" border="0"  alt="' . _GEN_MODERATED . '">';
                                                $moderatedForum = 1;
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if ($forumDesc != "")
                                        {
                                        ?>
                                            <div class = "<?php echo $boardclass ?>thead-desc fbm">
<?php echo $forumDesc ?>
                                            </div>
                                        <?php
                                        }
                                        if (count($forumparents) > 0)
                                        {
                                        ?>
                                            <div class = "<?php echo $boardclass?>thead-child">
                                                <div class = "<?php echo $boardclass?>cc-childcat-title fbs">
                                                    <b><?php if(count($forumparents)==1) { echo _FB_CHILD_BOARD; } else { echo _FB_CHILD_BOARDS; } ?>:</b>
                                                </div>
                                                <table cellpadding = "0" cellspacing = "0" border = "0" class = "<?php echo $boardclass?>cc-table">
                                                    <?php
                                                    $ir9 = 0;
                                                    $num_rows = ceil(count($forumparents) / $fbConfig['numchildcolumn']);
                                                    for ($row_count = 0; $row_count < $num_rows; $row_count++)
                                                    {
                                                        echo '<tr>';
                                                        for ($col_count = 0; $col_count < $fbConfig['numchildcolumn']; $col_count++)
                                                        {
                                                            echo '<td width="' . floor(100 / $fbConfig['numchildcolumn']) . '%" class="' . $boardclass . 'cc-sectiontableentry1 fbm">';

                                                            $forumparent = @$forumparents[$ir9];
                                                            if ($forumparent)
                                                            {

                                                                if ($fbConfig['showChildCatIcon'])
                                                                {
                                                                    if ($fbConfig['showNew'] && $my->id != 0)
                                                                    {
                                                                        $database->setQuery("SELECT thread from #__fb_messages where catid=$forumparent->id and hold=0 and time>$prevCheck group by thread");
                                                                        $newPThreadsAll = $database->loadObjectList();
                                                                        if (count($newPThreadsAll) == 0) {
                                                                            $newPThreadsAll = array ();
                                                                        }
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
                                                                                echo $fbIcons['unreadforum'] ? '<img src="' . JB_URLICONSPATH
                                                                                         . '' . $fbIcons['unreadforum_childsmall'] . '" border="0" alt="' . _GEN_FORUM_NEWPOST . '" title="' . _GEN_FORUM_NEWPOST . '" />' : $fbConfig['newChar'];
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            if (is_file(JB_ABSCATIMAGESPATH . "" . $forumparent->id . "_off_childsmall.gif")) {
                                                                                echo "<img src=\"" . JB_URLCATIMAGES . "" . $forumparent->id . "_off_childsmall.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                                                            }
                                                                            else {
                                                                                echo $fbIcons['readforum'] ? '<img src="' . JB_URLICONSPATH
                                                                                         . '' . $fbIcons['readforum_childsmall'] . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '" />' : $fbConfig['newChar'];
                                                                            }
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        if (is_file(JB_ABSCATIMAGESPATH . "" . $forumparent->id . "_notlogin_childsmall.gif")) {
                                                                            echo "<img src=\"" . JB_URLCATIMAGES . "" . $forumparent->id . "_notlogin_childsmall.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                                                        }
                                                                        else {
                                                                            echo $fbIcons['notloginforum'] ? '<img src="' . JB_URLICONSPATH
                                                                                     . '' . $fbIcons['notloginforum_childsmall'] . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '" />' : $fbConfig['newChar'];
                                                                        }
                                                                    }
                                                                }
                                                                echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $forumparent->id) . '">' . $forumparent->name . '</a> <span class="fb_childcount fbs">('.$forumparent->numTopics."/".$forumparent->numPosts.')</span>';
                                                            }
																echo "</td>";
                                                            $ir9++;
                                                        } // inner column loop
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        <?php
                                        }
                                        $database->setQuery("select * from #__fb_moderation left join #__users on #__users.id=#__fb_moderation.userid where #__fb_moderation.catid=$singlerow->id");
                                        $modslist = $database->loadObjectList();
                                        if (count($modslist) > 0)
                                        {
                                        ?>
                                            <div class = "<?php echo $boardclass ;?>thead-moderators fbs">
<?php echo _GEN_MODERATORS; ?>:
                                                <?php
                                                foreach ($modslist as $mod) {
												 echo '&nbsp;<a href = "' . sefRelToAbs(FB_PROFILE_LINK_SUFFIX.''.$mod->userid).'">'.$mod->username.'</a>&nbsp; ';
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        }

                                        if ($is_moderator)
                                        {
                                            if ($numPending > 0)
                                            {
                                                echo '<div class="fbs"><span style="color:red">';
                                                echo ' <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=review&amp;action=list&amp;catid=' . $singlerow->id) . '" >';
                                                echo '' . $numcolor . '' . $numPending . ' ' . _SHOWCAT_PENDING;
                                                echo '</a></span></div>';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class = "td-3  fbm" align="center" ><?php echo $numtopics; ?></td>
                                    <td class = "td-4  fbm" align="center" >
<?php echo $numreplies; ?>
                                    </td>
                                    <?php
                                    if ($numtopics != 0)
                                    {
                                    ?>
                                        <td class = "td-5" align="left">
                                            <div class = "<?php echo $boardclass ?>latest-subject fbm">
                                                <a href = "<?php echo sefRelToAbs(JB_LIVEURLREL.'&amp;func=view&amp;catid='.$singlerow->lastcat.'&amp;id='.$latestid).'#'.$latestid;?>"><?php echo $latestsubject; ?></a>
                                            </div>
                                            <div class = "<?php echo $boardclass ?>latest-subject-by fbs">
<?php echo _GEN_BY; ?>
 <a href = "<?php echo sefRelToAbs(FB_PROFILE_LINK_SUFFIX.''.$latestuserid)?>"><?php echo $latestname; ?></a>
                                    | <?php echo $lastptime; ?> <a href = "<?php echo sefRelToAbs(JB_LIVEURLREL.'&amp;func=view&amp;catid='.$singlerow->lastcat.'&amp;id='.$latestid).'#'.$latestid;?>"> <?php
    echo $fbIcons['latestpost'] ? '<img src="'
             . JB_URLICONSPATH . '' . $fbIcons['latestpost'] . '" border="0" alt="' . _SHOW_LAST . '" title="' . _SHOW_LAST . '" />' : '  <img src="' . JB_URLEMOTIONSPATH . 'icon_newest_reply.gif" border="0"  alt="' . _SHOW_LAST . '" />'; ?> </a>
                                            </div>
                                        </td>
                                </tr>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <td class = "td-5"  align="left">
<?php echo _NO_POSTS; ?>
                                        </td>
                                        </tr>
                    <?php
                                    }
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
<!-- F: List Cat -->
<?php
        }
    }
    if ($fbConfig['showLatest'] > 0)
    {
        if (file_exists(JB_ABSTMPLTPATH . '/plugin/recentposts/recentposts.php')) {
            include (JB_ABSTMPLTPATH . '/plugin/recentposts/recentposts.php');
        }
        else {
            include (JB_ABSPATH . '/template/default/plugin/recentposts/recentposts.php');
        }
    }
	if ($fbConfig['fm'])
	{
		if ($my->id != 0 OR $fbConfig['fm_guests'])
		{
			if (file_exists(JB_ABSPATH.'/template/default/plugin/lister/lister.php')) include_once (JB_ABSPATH.'/template/default/plugin/lister/lister.php');
		}
	}
	//if (file_exists(JB_ABSPATH.'/template/default/plugin/album/album.php')) include_once (JB_ABSPATH.'/template/default/plugin/album/album.php');
	if ($fbConfig['showstats'] > 0)
    {
		if (file_exists(JB_ABSTMPLTPATH . '/plugin/stats/stats.class.php')) {
			include_once (JB_ABSTMPLTPATH . '/plugin/stats/stats.class.php');
		}
		else {
			include_once (JB_ABSPATH . '/template/default/plugin/stats/stats.class.php');
		}
		if (file_exists(JB_ABSTMPLTPATH . '/plugin/stats/frontstats.php')) {
			include (JB_ABSTMPLTPATH . '/plugin/stats/frontstats.php');
		}
		else {
			include (JB_ABSPATH . '/template/default/plugin/stats/frontstats.php');
		}
	}
	if ($fbConfig['showWhoisOnline'] > 0)
    {
		if (file_exists(JB_ABSTMPLTPATH . '/plugin/who/whoisonline.php')) {
			include (JB_ABSTMPLTPATH . '/plugin/who/whoisonline.php');
		}
		else {
			include (JB_ABSPATH . '/template/default/plugin/who/whoisonline.php');
		}
	}
    if (file_exists(JB_ABSTMPLTPATH . '/fb_category_list_bottom.php')) {
        include (JB_ABSTMPLTPATH . '/fb_category_list_bottom.php');
    }
    else {
        include (JB_ABSPATH . '/template/default/fb_category_list_bottom.php');
    }
}
else
{
?>
    <div>
        <?php
        echo _LISTCAT_NO_CATS . '<br />';
        echo _LISTCAT_ADMIN . '<br />';
        echo _LISTCAT_PANEL . '<br /><br />';
        echo _LISTCAT_INFORM . '<br /><br />';
        echo _LISTCAT_DO . ' <img src="' . JB_URLEMOTIONSPATH . 'wink.gif"  alt="" border="0" />';
        ?>
    </div>
<?php
}
?>