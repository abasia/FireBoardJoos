<?php
/**
* @version $Id: icons.php 462 2007-12-10 00:05:53Z fxstein $
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
class FBJIcons{
	public $delete;
	public $edit;
	public $lock;
	public $move;
	public $new_topic;
	public $new_poll;
	public $quote;
	public $reply;
	public $sticky;
	public $subscribe;
	public $unsubscribe;
	public $favorite;
	public $unfavorite;
	public $favoritestar;
	public $unlock;
	public $unsticky;
	public $topicreply;
	public $quickmsg;
	public $forumlocked;
	public $forummoderated;
	public $unreadmessage;
	public $readmessage;
	public $notloginmessage;
	public $unreadforum;
	public $readforum;
	public $notloginforum;
	public $unreadforum_childsmall;
	public $readforum_childsmall;
	public $notloginforum_childsmall;
	public $unreadforum_s;
	public $readforum_s;
	public $notloginforum_s;
	public $toparrow;
	public $bottomarrow;
	public $latestpost;
	public $topicsticky;
	public $topiclocked;
	public $markThisForumRead;
	public $userprofile;
	public $pms2;
	public $pms;
	public $onlineicon;
	public $offlineicon;
	public $msgip;
	public $msgicq;
	public $msgskype;
	public $msggtalk;
	public $msgwebsite;
	public $msgmale;
	public $msgfemale;
	public $msglocation;
	public $msgbirthdate;
	public $msgaim;
	public $msgmsn;
	public $msgyim;

	function __construct(){
		$this->delete = 'delete.gif';
		$this->edit = 'edit.gif';
		$this->lock = 'lock.gif';
		$this->move = 'move.gif';
		$this->new_topic = 'new_thread.gif';
		$this->new_poll = 'new_poll.gif';
		$this->quote = 'quote.gif';
		$this->reply = 'msg_reply.gif';
		$this->sticky = 'sticky.gif';
		$this->subscribe = 'subscribe.gif';
		$this->unsubscribe = 'unsubscribe.gif';
		$this->favorite = 'favorite.gif';
		$this->unfavorite = 'unfavorite.gif';
		$this->favoritestar = 'favoritestar.gif';
		$this->unlock = 'unlock.gif';
		$this->unsticky = 'unsticky.gif';
		$this->topicreply = 'reply.gif';
		$this->quickmsg = 'quick_reply.gif';
		$this->forumlocked = 'tlock.gif';
		$this->forummoderated = 'tmoder.gif';
		$this->unreadmessage = 'unreadmessage_s.gif';
		$this->readmessage = 'readmessage_s.gif';
		$this->notloginmessage = 'readmessage_s.gif';
		$this->unreadforum = 'folder.gif';
		$this->readforum = 'folder_nonew.gif';
		$this->notloginforum = 'folder_nonew.gif';
		$this->unreadforum_childsmall = 'folder_s.gif';
		$this->readforum_childsmall = 'folder_nonew_s.gif';
		$this->notloginforum_childsmall = 'folder_nonew_s.gif';
		$this->unreadforum_s = 'folder_s.gif';
		$this->readforum_s = 'folder_nonew_s.gif';
		$this->notloginforum_s = 'folder_nonew_s.gif';
		$this->toparrow = 'top_arrow.gif';
		$this->bottomarrow = 'bottom_arrow.gif';
		$this->latestpost = 'tlatest.gif';
		$this->topicsticky = 'tsticky.gif';
		$this->topiclocked = 'thread_lock.gif';
		$this->markThisForumRead ='markthisforumread.gif';
		$this->userprofile ='profile.gif';
		$this->pms2 ='pm.gif';
		$this->pms ='pm.gif';
		$this->onlineicon ='online.gif';
		$this->offlineicon ='offline.gif';
		$this->msgip ='ip.gif';
		$this->msgicq ='msgicq.gif';
		$this->msgskype ='msgskype.gif';
		$this->msggtalk ='msggtalk.gif';
		$this->msgwebsite ='msgwebsite.gif';
		$this->msgmale ='msgmale.gif';
		$this->msgfemale ='msgfemale.gif';
		$this->msglocation ='msglocation.gif';
		$this->msgbirthdate ='msgbirthdate.gif';
		$this->msgaim ='msgaim.gif';
		$this->msgmsn ='msgmsn.gif';
		$this->msgyim ='msgyim.gif';
	}
	public static function getInstance(){
		static $instance;
		if(!is_object($instance)){
			$instance = new FBJIcons();
		}
		return $instance;
	}
}
