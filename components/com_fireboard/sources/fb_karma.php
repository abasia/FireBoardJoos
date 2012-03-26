<?php
/**
* @version $Id: fb_karma.php 462 2007-12-10 00:05:53Z fxstein $
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
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
global $fbConfig;
$karma_min_seconds = '21600';
?>
<table border = 0 cellspacing = 0 cellpadding = 0 width = "100%" align = "center">
    <tr>
        <td>
            <br>
                <?php
                $catid = (int)$catid;
                $pid = (int)$pid;
                if ($fbConfig['showkarma'] && $my->id != "" && $my->id != 0 && $do != '' && $userid != '')
                {
                    $time = FBTools::fbGetInternalTime();

                    if ($my->id != $userid)
                    {
                        if (!$is_moderator)
                        {
                            $database->setQuery('SELECT karma_time FROM #__fb_users WHERE userid=' . $my->id . '');
                            $karma_time_old = $database->loadResult();
                            $karma_time_diff = $time - $karma_time_old;
                        }
                        if ($karma_time_diff >= $karma_min_seconds || $is_moderator)
                        {
                            if ($do == "increase")
                            {
                                $database->setQuery('UPDATE #__fb_users SET karma_time=' . $time . ' WHERE userid=' . $my->id . '');
                                $database->query();
                                $database->setQuery('UPDATE #__fb_users SET karma=karma+1 WHERE userid=' . $userid . '');
                                $database->query();
                                echo _KARMA_INCREASED . '<br /> <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $pid) . '">' . _POST_CLICK . '</a>.';
                ?>
                            <script language = "javascript">
                                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$pid); ?>'", 3500);
                            </script>
                <?php
                            }
                            else if ($do == "decrease")
                            {
                                $database->setQuery('UPDATE #__fb_users SET karma_time=' . $time . ' WHERE userid=' . $my->id . '');
                                $database->query();
                                $database->setQuery('UPDATE #__fb_users SET karma=karma-1 WHERE userid=' . $userid . '');
                                $database->query();
                                echo _KARMA_DECREASED . '<br /> <a href="' . sefRelToAbs(JB_LIVEURLREL. '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $pid) . '">' . _POST_CLICK . '</a>.';
                ?>
                            <script language = "javascript">
                                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$pid); ?>'", 3500);
                            </script>
                <?php
                            }
                            else
                            {
                                echo _USER_ERROR_A;
                                echo _USER_ERROR_B . "<br /><br />";
                                echo _USER_ERROR_C . "<br /><br />" . _USER_ERROR_D . ": <code>fb001-karma-02NoDO</code><br /><br />";
                            }
                        }
                        else
                            echo _KARMA_WAIT . '<br /> ' . _KARMA_BACK . ' <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $pid) . '">' . _POST_CLICK . '</a>.';
                    }
                    else if ($my->id == $userid)
                    {
                        if ($do == "increase")
                        {
                            $database->setQuery('UPDATE #__fb_users SET karma=karma-10, karma_time=' . $time . ' WHERE userid=' . $my->id . '');
                            $database->query();
                            echo _KARMA_SELF_INCREASE . '<br />' . _KARMA_BACK . ' <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $pid) . '">' . _POST_CLICK . '</a>.';
                        }

                        if ($do == "decrease")
                        {
                            $database->setQuery('UPDATE #__fb_users SET karma_time=' . $time . ' WHERE userid=' . $my->id . '');
                            $database->query();
                            echo _KARMA_SELF_DECREASE . '<br /> ' . _KARMA_BACK . ' <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $pid) . '">' . _POST_CLICK . '</a>.';
                        }
                    }
                }
                else
                {
                    echo _USER_ERROR_A;
                    echo _USER_ERROR_B . "<br /><br />";
                    echo _USER_ERROR_C . "<br /><br />" . _USER_ERROR_D . ": <code>fb001-karma-01NLO</code><br /><br />";
                }
                ?>
        </td>
    </tr>
</table>