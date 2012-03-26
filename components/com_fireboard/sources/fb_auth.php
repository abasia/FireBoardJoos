<?php
/**
 * @version $Id: fb_auth.php 462 2007-12-10 00:05:53Z fxstein $
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
class fb_auth{
	public static function validate_user(&$forum, &$allow_forum, $groupid, &$acl){
		if($forum->pub_recurse){
			$pub_recurse = "RECURSE";
		} else{
			$pub_recurse = "NO_RECURSE";
		}
		if($forum->admin_recurse){
			$admin_recurse = "RECURSE";
		} else{
			$admin_recurse = "NO_RECURSE";
		}
		if(fb_is_private_has_access($forum->id, $my->id) == 0){
			return 0;
		} else{
			if($forum->pub_access == 0 || ($forum->pub_access == -1 && $groupid > 0) || in_array($forum->id, $allow_forum)){
				return 1;
			} else{
				if($groupid == $forum->pub_access){
					return 1;
				} else{
					if($pub_recurse == 'RECURSE'){
						$group_childs = array();
						$group_childs = $acl->get_group_children($forum->pub_access, 'ARO', $pub_recurse);
						if(is_array($group_childs) && count($group_childs) > 0){
							if(in_array($groupid, $group_childs)){
								return 1;
							}
						}
					}
				}
				if($groupid == $forum->admin_access){
					return 1;
				} else{
					if($admin_recurse == 'RECURSE'){
						$group_childs = array();
						$group_childs = $acl->get_group_children($forum->admin_access, 'ARO', $admin_recurse);
						if(is_array($group_childs) && count($group_childs) > 0){
							if(in_array($groupid, $group_childs)){
								return 1;
							}
						}
					}
				}
			}
		}
		return 0;
	}
}
