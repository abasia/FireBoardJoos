<?php
/**
* @version $Id: fb_permissions.php 462 2007-12-10 00:05:53Z fxstein $
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
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
function fb_has_post_permission(&$database,$catid,$replyto,$userid,$pubwrite,$ismod) {
    global $fbConfig;
    if ($ismod)
        return 1;
    if($replyto != 0) {
        $database->setQuery("select thread from #__fb_messages where id='$replyto'");
        $topicID=$database->loadResult();
        if ($topicID != 0)
            $sql='select locked from #__fb_messages where id='.$topicID;
        else
            $sql='select locked from #__fb_messages where id='.$replyto;
        $database->setQuery($sql);
        if ($database->loadResult()==1)
        return -1;
    }
    $database->setQuery("select locked from #__fb_categories where id=$catid");
    if ($database->loadResult()==1)
        return -2;
    if ($userid != 0|| $pubwrite)
        return 1;
    return 0;
}
function fb_has_moderator_permission(&$database,&$obj_fb_cat,$int_fb_uid,$bool_fb_isadmin) {
    if ($bool_fb_isadmin)
        return 1;
    if ($obj_fb_cat!='' && $obj_fb_cat->getModerated() && $int_fb_uid != 0) {
        $database->setQuery('SELECT userid FROM #__fb_moderation WHERE catid='.$obj_fb_cat->getId());
        $modIDs=$database->loadResultArray();
        if (sizeof($modIDs) != 0 && in_array($int_fb_uid, $modIDs))
            return 1;
    }
    return 0;
}
function fb_has_read_permission(&$obj_fbcat,&$allow_forum,$groupid,&$acl) {
    if ($obj_fbcat->getPubRecurse())
        $pub_recurse="RECURSE";
    else
        $pub_recurse="NO_RECURSE";

    if ($obj_fbcat->getAdminRecurse())
        $admin_recurse="RECURSE";
    else
        $admin_recurse="NO_RECURSE";
      if ($obj_fbcat->getPubAccess() == 0 || ($obj_fbcat->getPubAccess() == -1 && $groupid > 0) || (sizeof($allow_forum)> 0 && in_array($obj_fbcat->getId(),$allow_forum))) {
         return 1;
      }
      else {
        if( $groupid == $obj_fbcat->getPubAccess()) {
            return 1;
        }
        else {
            if ($pub_recurse=='RECURSE') {
                $group_childs=array();
                $group_childs=$acl->get_group_children( $obj_fbcat->getPubAccess(), 'ARO', $pub_recurse );
                if ( is_array( $group_childs ) && count( $group_childs ) > 0) {
                    if ( in_array($groupid, $group_childs) ) {
                        return 1;
                    }
               }
            }
        }
        if( $groupid == $obj_fbcat->getAdminAccess() ) {
            return 1;
        }
        else {
            if ($admin_recurse=='RECURSE') {
                $group_childs=array();
                $group_childs=$acl->get_group_children( $obj_fbcat->getAdminAccess(), 'ARO', $admin_recurse );
                if (is_array( $group_childs ) && count( $group_childs ) > 0) {
                      if ( in_array($groupid, $group_childs) ) {
                         return 1;
                    }
                }
            }
         }
    }
    return 0;
}