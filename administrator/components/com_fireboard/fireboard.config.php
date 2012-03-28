<?php
/**
 * @package Fireboard
 * @Copyright (C) 2000 - 2012 Gold Dragon
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://joostinadev.ru
 * @author Gold Dragon
 **/
defined('_VALID_MOS') or die();

class FBJConfig{
	private $database;

	public $board_title;
	public $re;
	public $email;
	public $board_offline;
	public $board_ofset;
	public $offline_message;
	public $default_view;
	public $enableRSS;
	public $enablePDF;
	public $chat;
	public $chat_guests;
	public $polls;
	public $pollmax;
	public $threads_per_page;
	public $messages_per_page;
	public $messages_per_page_search;
	public $showHistory;
	public $historyLimit;
	public $showNew;
	public $newChar;
	public $jmambot;
	public $disemoticons;
	public $template;
	public $templateimagepath;
	public $joomlaStyle;
	public $showAnnouncement;
	public $avatarOnCat;
	public $CatImagePath;
	public $numchildcolumn;
	public $showChildCatIcon;
	public $AnnModId;
	public $rtewidth;
	public $rteheight;
	public $enableRulesPage;
	public $rules_infb;
	public $rules_cid;
	public $rules_link;
	public $enableHelpPage;
	public $help_infb;
	public $help_cid;
	public $help_link;
	public $enableForumJump;
	public $reportmsg;
	public $username;
	public $askemail;
	public $showemail;
	public $showstats;
	public $postStats;
	public $statsColor;
	public $showkarma;
	public $useredit;
	public $usereditTime;
	public $usereditTimeGrace;
	public $editMarkUp;
	public $allowsubscriptions;
	public $subscriptionschecked;
	public $allowfavorites;
	public $wrap;
	public $maxSubject;
	public $maxSig;
	public $regonly;
	public $changename;
	public $pubwrite;
	public $floodprotection;
	public $mailmod;
	public $mailadmin;
	public $captcha;
	public $mailfull;
	public $allowAvatar;
	public $allowAvatarUpload;
	public $allowAvatarGallery;
	public $imageProcessor;
	public $avatarSmallHeight;
	public $avatarSmallWidth;
	public $avatarHeight;
	public $avatarWidth;
	public $avatarLargeHeight;
	public $avatarLargeWidth;
	public $avatarSize;
	public $avatarQuality;
	public $allowImageUpload;
	public $allowImageRegUpload;
	public $imageHeight;
	public $imageWidth;
	public $imageSize;
	public $allowFileUpload;
	public $allowFileRegUpload;
	public $fileTypes;
	public $fileSize;
	public $attach_guests;
	public $showranking;
	public $rankimages;
	public $avatar_src;
	public $fb_profile;
	public $pm_component;
	public $cb_profile;
	public $badwords;
	public $discussBot;
	public $userlist_rows;
	public $userlist_online;
	public $userlist_avatar;
	public $userlist_name;
	public $userlist_username;
	public $userlist_group;
	public $userlist_posts;
	public $userlist_karma;
	public $userlist_email;
	public $userlist_usertype;
	public $userlist_joindate;
	public $userlist_lastvisitdate;
	public $userlist_userhits;
	public $showLatest;
	public $latestCount;
	public $latestCountPerPage;
	public $latestCategory;
	public $latestSingleSubject;
	public $latestReplySubject;
	public $latestSubjectLength;
	public $latestShowDate;
	public $latestShowHits;
	public $latestShowAuthor;
	public $showStats;
	public $showWhoisOnline;
	public $showGenStats;
	public $showPopUserStats;
	public $PopUserCount;
	public $showPopSubjectStats;
	public $PopSubjectCount;
	public $usernamechange;
	public $version;

	function __construct(){
		$database = database::getInstance();
		/*
		$sql = "SELECT * FROM #__gdfaq_config";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		if(count($rows)){
			foreach($rows as $row){
				$tmp[$row->name] = $row->value;
			}
		}else{
			GDFaqHtml::error(_GDF_ERR1);
		}
		$this->title_com = (isset($tmp['title_com'])) ? $tmp['title_com'] : 'GDFaq';
		$this->view_title_cat = (isset($tmp['view_title_cat'])) ? intval($tmp['view_title_cat']) : 1;
		$this->view_title_com = (isset($tmp['view_title_com'])) ? intval($tmp['view_title_com']) : 1;
		$this->stat = (isset($tmp['stat'])) ? intval($tmp['stat']) : 1;
		$this->sort = (isset($tmp['sort'])) ? $tmp['sort'] : 'ques_asc';
		$this->max_question = (isset($tmp['max_question'])) ? intval($tmp['max_question']) : 100;
		$this->max_answer = (isset($tmp['max_answer'])) ? intval($tmp['max_answer']) : 1000;
		$this->view_date_ques = (isset($tmp['view_date_ques'])) ? intval($tmp['view_date_ques']) : 1;
		$this->view_date_ans = (isset($tmp['view_date_ans'])) ? intval($tmp['view_date_ans']) : 1;
		$this->view_autor_ques = (isset($tmp['view_autor_ques'])) ? intval($tmp['view_autor_ques']) : 1;
		$this->view_autor_ans = (isset($tmp['view_autor_ans'])) ? intval($tmp['view_autor_ans']) : 1;
		$this->ip_limit = (isset($tmp['ip_limit'])) ? intval($tmp['ip_limit']) : 120;
		*/
		$this->board_title = 'СуперФорум';
		$this->re = '0';
		$this->email = 'change@me.com';
		$this->board_offline = '0';
		$this->board_ofset = '0';
		$this->offline_message = '<h2>Форум временно закрыт.</h2><br/>Зайдите позже!';
		$this->default_view = 'flat';
		$this->enableRSS = '1';
		$this->enablePDF = '1';
		$this->chat = '1';
		$this->chat_guests = '1';
		$this->polls = '1';
		$this->pollmax = '5';
		$this->threads_per_page = '20';
		$this->messages_per_page = '6';
		$this->messages_per_page_search = '15';
		$this->showHistory = '1';
		$this->historyLimit = '6';
		$this->showNew = '1';
		$this->newChar = 'NEW!';
		$this->jmambot = '1';
		$this->disemoticons = '0';
		$this->template = 'default';
		$this->templateimagepath = 'default';
		$this->joomlaStyle = '0';
		$this->showAnnouncement = '1';
		$this->avatarOnCat = '1';
		$this->CatImagePath = 'category_images/';
		$this->numchildcolumn = '2';
		$this->showChildCatIcon = '1';
		$this->AnnModId = '62';
		$this->rtewidth = '450';
		$this->rteheight = '300';
		$this->enableRulesPage = '1';
		$this->rules_infb = '1';
		$this->rules_cid = '1';
		$this->rules_link = '';
		$this->enableHelpPage = '1';
		$this->help_infb = '1';
		$this->help_cid = '1';
		$this->help_link = '';
		$this->enableForumJump = '1';
		$this->reportmsg = '1';
		$this->username = '1';
		$this->askemail = '0';
		$this->showemail = '1';
		$this->showstats = '1';
		$this->postStats = '1';
		$this->statsColor = '12';
		$this->showkarma = '1';
		$this->useredit = '1';
		$this->usereditTime = '0';
		$this->usereditTimeGrace = '600';
		$this->editMarkUp = '1';
		$this->allowsubscriptions = '1';
		$this->subscriptionschecked = '1';
		$this->allowfavorites = '1';
		$this->wrap = '250';
		$this->maxSubject = '50';
		$this->maxSig = '300';
		$this->regonly = '0';
		$this->changename = '0';
		$this->pubwrite = '0';
		$this->floodprotection = '0';
		$this->mailmod = '0';
		$this->mailadmin = '0';
		$this->captcha = '1';
		$this->mailfull = '0';
		$this->allowAvatar = '1';
		$this->allowAvatarUpload = '1';
		$this->allowAvatarGallery = '1';
		$this->imageProcessor = 'gd2';
		$this->avatarSmallHeight = '50';
		$this->avatarSmallWidth = '50';
		$this->avatarHeight = '100';
		$this->avatarWidth = '100';
		$this->avatarLargeHeight = '250';
		$this->avatarLargeWidth = '250';
		$this->avatarSize = '100';
		$this->avatarQuality = '75';
		$this->allowImageUpload = '1';
		$this->allowImageRegUpload = '1';
		$this->imageHeight = '800';
		$this->imageWidth = '1024';
		$this->imageSize = '500';
		$this->allowFileUpload = '1';
		$this->allowFileRegUpload = '1';
		$this->fileTypes = 'zip,txt,doc,rar';
		$this->fileSize = '1024';
		$this->attach_guests = '1';
		$this->showranking = '1';
		$this->rankimages = '1';
		$this->avatar_src = 'fb';
		$this->fb_profile = 'fb';
		$this->pm_component = 'no';
		$this->cb_profile = '0';
		$this->badwords = '0';
		$this->discussBot = '0';
		$this->userlist_rows = '30';
		$this->userlist_online = '1';
		$this->userlist_avatar = '1';
		$this->userlist_name = '1';
		$this->userlist_username = '1';
		$this->userlist_group = '1';
		$this->userlist_posts = '1';
		$this->userlist_karma = '1';
		$this->userlist_email = '1';
		$this->userlist_usertype = '1';
		$this->userlist_joindate = '1';
		$this->userlist_lastvisitdate = '1';
		$this->userlist_userhits = '1';
		$this->showLatest = '1';
		$this->latestCount = '10';
		$this->latestCountPerPage = '5';
		$this->latestCategory = '';
		$this->latestSingleSubject = '1';
		$this->latestReplySubject = '1';
		$this->latestSubjectLength = '100';
		$this->latestShowDate = '1';
		$this->latestShowHits = '1';
		$this->latestShowAuthor = '1';
		$this->showStats = '1';
		$this->showWhoisOnline = '1';
		$this->showGenStats = '1';
		$this->showPopUserStats = '1';
		$this->PopUserCount = '10';
		$this->showPopSubjectStats = '1';
		$this->PopSubjectCount = '10';
		$this->usernamechange = '1';
		$this->version = '2.0';
	}

	public static function getInstance(){
		static $instance;
		if(!is_object($instance)){
			$instance = new FBJConfig();
		}
		return $instance;
	}

	public static function database(){
		$database = database::getInstance();
		return $database;
	}

	public static function my(){
		$mainframe = self::mainframe();
		$my = $mainframe->getUser();
		return $my;
	}

	public static function mainframe(){
		$mainframe = mosMainFrame::getInstance();
		return $mainframe;
	}
	public static function getCfg($str){
		$mainframe = self::mainframe();
		$result = $mainframe->getCfg($str);
		return $result;
	}

	/**
	 * @static Попытка получить Itemid
	 * @return int - Itemid
	 */
	public static function getItemid(){
		if(isset($_REQUEST['Itemid'])){
			$itemid = intval($_REQUEST['Itemid']);
			if($itemid==0){
				$database = self::database();
				$sql = "SELECT id FROM #__menu WHERE link LIKE '%index.php?option=com_fireboard%' LIMIT 1";
				$database->setQuery($sql);
				$itemid = $database->loadResult();
			}else{
				$itemid = 0;
			}
		}else{
			$itemid = 0;
		}
		return $itemid;
	}
}

