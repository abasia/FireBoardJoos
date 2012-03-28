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
	}

	/**
	 * @static Загрузка данных из базы
	 */
	public static function loadConfig(){
		$config = self::getInstance();
		$database = database::getInstance();
		$sql = "SELECT * FROM #__fb_config";
		$database->setQuery($sql);
		$rows = $database->loadObjectList();
		foreach($rows as $row){
			$t[$row->name] = $row->value;
		}

		$config->board_title = (isset($t['board_title'])) ? $t['board_title'] : 'Форум';
		$config->re = (isset($t['re'])) ? $t['re'] : '0';
		$config->email = (isset($t['email'])) ? $t['email'] : 'change@me.com';
		$config->board_offline = (isset($t['board_offline'])) ? $t['board_offline'] : '0';
		$config->board_ofset = (isset($t['board_ofset'])) ? $t['board_ofset'] : '0';
		$config->offline_message = (isset($t['offline_message'])) ? $t['offline_message'] : '<h2>Форум временно закрыт.</h2><br/>Зайдите позже!';
		$config->default_view = (isset($t['default_view'])) ? $t['default_view'] : 'flat';
		$config->enableRSS = (isset($t['enableRSS'])) ? $t['enableRSS'] : '1';
		$config->enablePDF = (isset($t['enablePDF'])) ? $t['enablePDF'] : '1';
		$config->polls = (isset($t['polls'])) ? $t['polls'] : '1';
		$config->pollmax = (isset($t['pollmax'])) ? $t['pollmax'] : '5';
		$config->threads_per_page = (isset($t['threads_per_page'])) ? $t['threads_per_page'] : '20';
		$config->messages_per_page = (isset($t['messages_per_page'])) ? $t['messages_per_page'] : '6';
		$config->messages_per_page_search = (isset($t['messages_per_page_search'])) ? $t['messages_per_page_search'] : '15';
		$config->showHistory = (isset($t['showHistory'])) ? $t['showHistory'] : '1';
		$config->historyLimit = (isset($t['historyLimit'])) ? $t['historyLimit'] : '6';
		$config->showNew = (isset($t['showNew'])) ? $t['showNew'] : '1';
		$config->newChar = (isset($t['newChar'])) ? $t['newChar'] : 'NEW!';
		$config->jmambot = (isset($t['jmambot'])) ? $t['jmambot'] : '1';
		$config->disemoticons = (isset($t['disemoticons'])) ? $t['disemoticons'] : '0';
		$config->template = (isset($t['template'])) ? $t['template'] : 'default';
		$config->templateimagepath = (isset($t['templateimagepath'])) ? $t['templateimagepath'] : 'default';
		$config->joomlaStyle = (isset($t['joomlaStyle'])) ? $t['joomlaStyle'] : '0';
		$config->showAnnouncement = (isset($t['showAnnouncement'])) ? $t['showAnnouncement'] : '1';
		$config->avatarOnCat = (isset($t['avatarOnCat'])) ? $t['avatarOnCat'] : '1';
		$config->CatImagePath = (isset($t['CatImagePath'])) ? $t['CatImagePath'] : 'category_images/';
		$config->numchildcolumn = (isset($t['numchildcolumn'])) ? $t['numchildcolumn'] : '2';
		$config->showChildCatIcon = (isset($t['showChildCatIcon'])) ? $t['showChildCatIcon'] : '1';
		$config->AnnModId = (isset($t['AnnModId'])) ? $t['AnnModId'] : '62';
		$config->rtewidth = (isset($t['rtewidth'])) ? $t['rtewidth'] : '450';
		$config->rteheight = (isset($t['rteheight'])) ? $t['rteheight'] : '300';
		$config->enableRulesPage = (isset($t['enableRulesPage'])) ? $t['enableRulesPage'] : '1';
		$config->rules_infb = (isset($t['rules_infb'])) ? $t['rules_infb'] : '1';
		$config->rules_cid = (isset($t['rules_cid'])) ? $t['rules_cid'] : '1';
		$config->rules_link = (isset($t['rules_link'])) ? $t['rules_link'] : '';
		$config->enableHelpPage = (isset($t['enableHelpPage'])) ? $t['enableHelpPage'] : '1';
		$config->help_infb = (isset($t['help_infb'])) ? $t['help_infb'] : '1';
		$config->help_cid = (isset($t['help_cid'])) ? $t['help_cid'] : '1';
		$config->help_link = (isset($t['help_link'])) ? $t['help_link'] : '';
		$config->enableForumJump = (isset($t['enableForumJump'])) ? $t['enableForumJump'] : '1';
		$config->reportmsg = (isset($t['reportmsg'])) ? $t['reportmsg'] : '1';
		$config->username = (isset($t['username'])) ? $t['username'] : '1';
		$config->askemail = (isset($t['askemail'])) ? $t['askemail'] : '0';
		$config->showemail = (isset($t['showemail'])) ? $t['showemail'] : '1';
		$config->showstats = (isset($t['showstats'])) ? $t['showstats'] : '1';
		$config->postStats = (isset($t['postStats'])) ? $t['postStats'] : '1';
		$config->statsColor = (isset($t['statsColor'])) ? $t['statsColor'] : '12';
		$config->showkarma = (isset($t['showkarma'])) ? $t['showkarma'] : '1';
		$config->useredit = (isset($t['useredit'])) ? $t['useredit'] : '1';
		$config->usereditTime = (isset($t['usereditTime'])) ? $t['usereditTime'] : '0';
		$config->usereditTimeGrace = (isset($t['usereditTimeGrace'])) ? $t['usereditTimeGrace'] : '600';
		$config->editMarkUp = (isset($t['editMarkUp'])) ? $t['editMarkUp'] : '1';
		$config->allowsubscriptions = (isset($t['allowsubscriptions'])) ? $t['allowsubscriptions'] : '1';
		$config->subscriptionschecked = (isset($t['subscriptionschecked'])) ? $t['subscriptionschecked'] : '1';
		$config->allowfavorites = (isset($t['allowfavorites'])) ? $t['allowfavorites'] : '1';
		$config->wrap = (isset($t['wrap'])) ? $t['wrap'] : '250';
		$config->maxSubject = (isset($t['maxSubject'])) ? $t['maxSubject'] : '50';
		$config->maxSig = (isset($t['maxSig'])) ? $t['maxSig'] : '300';
		$config->regonly = (isset($t['regonly'])) ? $t['regonly'] : '0';
		$config->changename = (isset($t['changename'])) ? $t['changename'] : '0';
		$config->pubwrite = (isset($t['pubwrite'])) ? $t['pubwrite'] : '0';
		$config->floodprotection = (isset($t['floodprotection'])) ? $t['floodprotection'] : '0';
		$config->mailmod = (isset($t['mailmod'])) ? $t['mailmod'] : '0';
		$config->mailadmin = (isset($t['mailadmin'])) ? $t['mailadmin'] : '0';
		$config->captcha = (isset($t['captcha'])) ? $t['captcha'] : '1';
		$config->mailfull = (isset($t['mailfull'])) ? $t['mailfull'] : '0';
		$config->allowAvatar = (isset($t['allowAvatar'])) ? $t['allowAvatar'] : '1';
		$config->allowAvatarUpload = (isset($t['allowAvatarUpload'])) ? $t['allowAvatarUpload'] : '1';
		$config->allowAvatarGallery = (isset($t['allowAvatarGallery'])) ? $t['allowAvatarGallery'] : '1';
		$config->imageProcessor = (isset($t['imageProcessor'])) ? $t['imageProcessor'] : 'gd2';
		$config->avatarSmallHeight = (isset($t['avatarSmallHeight'])) ? $t['avatarSmallHeight'] : '50';
		$config->avatarSmallWidth = (isset($t['avatarSmallWidth'])) ? $t['avatarSmallWidth'] : '50';
		$config->avatarHeight = (isset($t['avatarHeight'])) ? $t['avatarHeight'] : '100';
		$config->avatarWidth = (isset($t['avatarWidth'])) ? $t['avatarWidth'] : '100';
		$config->avatarLargeHeight = (isset($t['avatarLargeHeight'])) ? $t['avatarLargeHeight'] : '250';
		$config->avatarLargeWidth = (isset($t['avatarLargeWidth'])) ? $t['avatarLargeWidth'] : '250';
		$config->avatarSize = (isset($t['avatarSize'])) ? $t['avatarSize'] : '100';
		$config->avatarQuality = (isset($t['avatarQuality'])) ? $t['avatarQuality'] : '75';
		$config->allowImageUpload = (isset($t['allowImageUpload'])) ? $t['allowImageUpload'] : '1';
		$config->allowImageRegUpload = (isset($t['allowImageRegUpload'])) ? $t['allowImageRegUpload'] : '1';
		$config->imageHeight = (isset($t['imageHeight'])) ? $t['imageHeight'] : '800';
		$config->imageWidth = (isset($t['imageWidth'])) ? $t['imageWidth'] : '1024';
		$config->imageSize = (isset($t['imageSize'])) ? $t['imageSize'] : '500';
		$config->allowFileUpload = (isset($t['allowFileUpload'])) ? $t['allowFileUpload'] : '1';
		$config->allowFileRegUpload = (isset($t['allowFileRegUpload'])) ? $t['allowFileRegUpload'] : '1';
		$config->fileTypes = (isset($t['fileTypes'])) ? $t['fileTypes'] : 'zip,txt,doc,rar';
		$config->fileSize = (isset($t['fileSize'])) ? $t['fileSize'] : '1024';
		$config->attach_guests = (isset($t['attach_guests'])) ? $t['attach_guests'] : '1';
		$config->showranking = (isset($t['showranking'])) ? $t['showranking'] : '1';
		$config->rankimages = (isset($t['rankimages'])) ? $t['rankimages'] : '1';
		$config->avatar_src = (isset($t['avatar_src'])) ? $t['avatar_src'] : 'fb';
		$config->fb_profile = (isset($t['fb_profile'])) ? $t['fb_profile'] : 'fb';
		$config->pm_component = (isset($t['pm_component'])) ? $t['pm_component'] : 'no';
		$config->cb_profile = (isset($t['cb_profile'])) ? $t['cb_profile'] : '0';
		$config->badwords = (isset($t['badwords'])) ? $t['badwords'] : '0';
		$config->discussBot = (isset($t['discussBot'])) ? $t['discussBot'] : '0';
		$config->userlist_rows = (isset($t['userlist_rows'])) ? $t['userlist_rows'] : '30';
		$config->userlist_online = (isset($t['userlist_online'])) ? $t['userlist_online'] : '1';
		$config->userlist_avatar = (isset($t['userlist_avatar'])) ? $t['userlist_avatar'] : '1';
		$config->userlist_name = (isset($t['userlist_name'])) ? $t['userlist_name'] : '1';
		$config->userlist_username = (isset($t['userlist_username'])) ? $t['userlist_username'] : '1';
		$config->userlist_group = (isset($t['userlist_group'])) ? $t['userlist_group'] : '1';
		$config->userlist_posts = (isset($t['userlist_posts'])) ? $t['userlist_posts'] : '1';
		$config->userlist_karma = (isset($t['userlist_karma'])) ? $t['userlist_karma'] : '1';
		$config->userlist_email = (isset($t['userlist_email'])) ? $t['userlist_email'] : '1';
		$config->userlist_usertype = (isset($t['userlist_usertype'])) ? $t['userlist_usertype'] : '1';
		$config->userlist_joindate = (isset($t['userlist_joindate'])) ? $t['userlist_joindate'] : '1';
		$config->userlist_lastvisitdate = (isset($t['userlist_lastvisitdate'])) ? $t['userlist_lastvisitdate'] : '1';
		$config->userlist_userhits = (isset($t['userlist_userhits'])) ? $t['userlist_userhits'] : '1';
		$config->showLatest = (isset($t['showLatest'])) ? $t['showLatest'] : '1';
		$config->latestCount = (isset($t['latestCount'])) ? $t['latestCount'] : '10';
		$config->latestCountPerPage = (isset($t['latestCountPerPage'])) ? $t['latestCountPerPage'] : '5';
		$config->latestCategory = (isset($t['latestCategory'])) ? $t['latestCategory'] : '';
		$config->latestSingleSubject = (isset($t['latestSingleSubject'])) ? $t['latestSingleSubject'] : '1';
		$config->latestReplySubject = (isset($t['latestReplySubject'])) ? $t['latestReplySubject'] : '1';
		$config->latestSubjectLength = (isset($t['latestSubjectLength'])) ? $t['latestSubjectLength'] : '100';
		$config->latestShowDate = (isset($t['latestShowDate'])) ? $t['latestShowDate'] : '1';
		$config->latestShowHits = (isset($t['latestShowHits'])) ? $t['latestShowHits'] : '1';
		$config->latestShowAuthor = (isset($t['latestShowAuthor'])) ? $t['latestShowAuthor'] : '1';
		$config->showStats = (isset($t['showStats'])) ? $t['showStats'] : '1';
		$config->showWhoisOnline = (isset($t['showWhoisOnline'])) ? $t['showWhoisOnline'] : '1';
		$config->showGenStats = (isset($t['showGenStats'])) ? $t['showGenStats'] : '1';
		$config->showPopUserStats = (isset($t['showPopUserStats'])) ? $t['showPopUserStats'] : '1';
		$config->PopUserCount = (isset($t['PopUserCount'])) ? $t['PopUserCount'] : '10';
		$config->showPopSubjectStats = (isset($t['showPopSubjectStats'])) ? $t['showPopSubjectStats'] : '1';
		$config->PopSubjectCount = (isset($t['PopSubjectCount'])) ? $t['PopSubjectCount'] : '10';
		$config->usernamechange = (isset($t['usernamechange'])) ? $t['usernamechange'] : '1';
		$config->version = (isset($t['version'])) ? $t['version'] : '1.0 Joos';
	}

	/**
	 * @static Просмотр и редактирование конфигурации
	 * @param $option
	 */
	public static function showConfig($option){
		$fbConfig = self::getInstance();
		$mainframe = self::mainframe();

		$lists = array();
		// the default view
		$list = array();
		$list[] = mosHTML::makeOption('flat', _COM_A_FLAT);
		$list[] = mosHTML::makeOption('threaded', _COM_A_THREADED);
		// build the html select list
		$lists['default_view'] = mosHTML::selectList($list, 'cfg_default_view', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->default_view);
		// source of avatar picture
		$avlist = array();
		$avlist[] = mosHTML::makeOption('fb', _FB_FIREBOARD);
		$avlist[] = mosHTML::makeOption('clexuspm', _FB_CLEXUS);
		$avlist[] = mosHTML::makeOption('cb', _FB_CB);
		// build the html select list
		$lists['avatar_src'] = mosHTML::selectList($avlist, 'cfg_avatar_src', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->avatar_src);
		// private messaging system to use
		$pmlist = array();
		$pmlist[] = mosHTML::makeOption('no', _COM_A_NO);
		$pmlist[] = mosHTML::makeOption('pms', _FB_MYPMS);
		$pmlist[] = mosHTML::makeOption('clexuspm', _FB_CLEXUS);
		$pmlist[] = mosHTML::makeOption('uddeim', _FB_UDDEIM);
		$pmlist[] = mosHTML::makeOption('jim', _FB_JIM);
		$pmlist[] = mosHTML::makeOption('missus', _FB_MISSUS);
		$lists['pm_component'] = mosHTML::selectList($pmlist, 'cfg_pm_component', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->pm_component);
		$lists['pm_component'] = mosHTML::selectList($pmlist, 'cfg_pm_component', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->pm_component);
		// Profile select
		$prflist = array();
		$prflist[] = mosHTML::makeOption('fb', _FB_FIREBOARD);
		$prflist[] = mosHTML::makeOption('clexuspm', _FB_CLEXUS);
		$prflist[] = mosHTML::makeOption('cb', _FB_CB);
		$lists['fb_profile'] = mosHTML::selectList($prflist, 'cfg_fb_profile', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->fb_profile);
		$yesno = array();
		$yesno[] = mosHTML::makeOption('0', _COM_A_NO);
		$yesno[] = mosHTML::makeOption('1', _COM_A_YES);
		$listitems[] = mosHTML::makeOption('0', _FB_SELECTTEMPLATE);
		if($dir = @opendir($mainframe->getCfg('absolute_path') . "/components/com_fireboard/template")){
			while(($file = readdir($dir)) !== false){
				if($file != ".." && $file != "."){
					if(is_dir($mainframe->getCfg('absolute_path') . "/components/com_fireboard/template" . "/" . $file)){
						if(!($file[0] == '.')){
							$filelist[] = $file;
						}
					}
				}
			}
			closedir($dir);
		}
		asort($filelist);
		while(list($key, $val) = each($filelist)){
			$listitems[] = mosHTML::makeOption($val, $val);
		}
		$lists['badwords'] = mosHTML::selectList($yesno, 'cfg_badwords', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->badwords);
		$lists['jmambot'] = mosHTML::selectList($yesno, 'cfg_jmambot', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->jmambot);
		$lists['disemoticons'] = mosHTML::selectList($yesno, 'cfg_disemoticons', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->disemoticons);
		$lists['template'] = mosHTML::selectList($listitems, 'cfg_template', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->template);
		$lists['templateimagepath'] = mosHTML::selectList($listitems, 'cfg_templateimagepath', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->templateimagepath);
		$lists['regonly'] = mosHTML::selectList($yesno, 'cfg_regonly', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->regonly);
		$lists['board_offline'] = mosHTML::selectList($yesno, 'cfg_board_offline', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->board_offline);
		$lists['pubwrite'] = mosHTML::selectList($yesno, 'cfg_pubwrite', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->pubwrite);
		$lists['useredit'] = mosHTML::selectList($yesno, 'cfg_useredit', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->useredit);
		$lists['showHistory'] = mosHTML::selectList($yesno, 'cfg_showHistory', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showHistory);
		$lists['joomlaStyle'] = mosHTML::selectList($yesno, 'cfg_joomlaStyle', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->joomlaStyle);
		$lists['showAnnouncement'] = mosHTML::selectList($yesno, 'cfg_showAnnouncement', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showAnnouncement);
		$lists['avatarOnCat'] = mosHTML::selectList($yesno, 'cfg_avatarOnCat', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->avatarOnCat);
		$lists['showLatest'] = mosHTML::selectList($yesno, 'cfg_showLatest', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showLatest);
		$lists['latestSingleSubject'] = mosHTML::selectList($yesno, 'cfg_latestSingleSubject', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->latestSingleSubject);
		$lists['latestReplySubject'] = mosHTML::selectList($yesno, 'cfg_latestReplySubject', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->latestReplySubject);
		$lists['latestShowDate'] = mosHTML::selectList($yesno, 'cfg_latestShowDate', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->latestShowDate);
		$lists['showChildCatIcon'] = mosHTML::selectList($yesno, 'cfg_showChildCatIcon', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showChildCatIcon);
		$lists['latestShowHits'] = mosHTML::selectList($yesno, 'cfg_latestShowHits', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->latestShowHits);
		$lists['showStats'] = mosHTML::selectList($yesno, 'cfg_showStats', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showStats);
		$lists['showWhoisOnline'] = mosHTML::selectList($yesno, 'cfg_showWhoisOnline', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showWhoisOnline);
		$lists['showPopSubjectStats'] = mosHTML::selectList($yesno, 'cfg_showPopSubjectStats', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showPopSubjectStats);
		$lists['showGenStats'] = mosHTML::selectList($yesno, 'cfg_showGenStats', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showGenStats);
		$lists['showPopUserStats'] = mosHTML::selectList($yesno, 'cfg_showPopUserStats', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showPopUserStats);
		$lists['allowsubscriptions'] = mosHTML::selectList($yesno, 'cfg_allowsubscriptions', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->allowsubscriptions);
		$lists['subscriptionschecked'] = mosHTML::selectList($yesno, 'cfg_subscriptionschecked', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->subscriptionschecked);
		$lists['allowfavorites'] = mosHTML::selectList($yesno, 'cfg_allowfavorites', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->allowfavorites);
		$lists['mailmod'] = mosHTML::selectList($yesno, 'cfg_mailmod', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->mailmod);
		$lists['mailadmin'] = mosHTML::selectList($yesno, 'cfg_mailadmin', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->mailadmin);
		$lists['showemail'] = mosHTML::selectList($yesno, 'cfg_showemail', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showemail);
		$lists['askemail'] = mosHTML::selectList($yesno, 'cfg_askemail', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->askemail);
		$lists['changename'] = mosHTML::selectList($yesno, 'cfg_changename', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->changename);
		$lists['allowAvatar'] = mosHTML::selectList($yesno, 'cfg_allowAvatar', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->allowAvatar);
		$lists['allowAvatarUpload'] = mosHTML::selectList($yesno, 'cfg_allowAvatarUpload', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->allowAvatarUpload);
		$lists['allowAvatarGallery'] = mosHTML::selectList($yesno, 'cfg_allowAvatarGallery', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->allowAvatarGallery);
		$lists['avatar_src'] = mosHTML::selectList($avlist, 'cfg_avatar_src', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->avatar_src);
		$ip_opt[] = mosHTML::makeOption('gd2', 'GD2');
		$ip_opt[] = mosHTML::makeOption('gd1', 'GD1');
		$ip_opt[] = mosHTML::makeOption('none', _FB_IMAGE_PROCESSOR_NONE);
		$lists['imageProcessor'] = mosHTML::selectList($ip_opt, 'cfg_imageProcessor', 'class="inputbox"', 'value', 'text', $fbConfig->imageProcessor);
		$lists['showstats'] = mosHTML::selectList($yesno, 'cfg_showstats', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showstats);
		$lists['showranking'] = mosHTML::selectList($yesno, 'cfg_showranking', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showranking);
		$lists['rankimages'] = mosHTML::selectList($yesno, 'cfg_rankimages', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->rankimages);
		$lists['username'] = mosHTML::selectList($yesno, 'cfg_username', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->username);
		$lists['showNew'] = mosHTML::selectList($yesno, 'cfg_showNew', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showNew);
		$lists['allowImageUpload'] = mosHTML::selectList($yesno, 'cfg_allowImageUpload', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->allowImageUpload);
		$lists['allowImageRegUpload'] = mosHTML::selectList($yesno, 'cfg_allowImageRegUpload', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->allowImageRegUpload);
		$lists['allowFileUpload'] = mosHTML::selectList($yesno, 'cfg_allowFileUpload', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->allowFileUpload);
		$lists['allowFileRegUpload'] = mosHTML::selectList($yesno, 'cfg_allowFileRegUpload', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->allowFileRegUpload);
		$lists['editMarkUp'] = mosHTML::selectList($yesno, 'cfg_editMarkUp', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->editMarkUp);
		$lists['discussBot'] = mosHTML::selectList($yesno, 'cfg_discussBot', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->discussBot);
		$lists['enableRSS'] = mosHTML::selectList($yesno, 'cfg_enableRSS', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->enableRSS);
		$lists['postStats'] = mosHTML::selectList($yesno, 'cfg_postStats', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->postStats);
		$lists['showkarma'] = mosHTML::selectList($yesno, 'cfg_showkarma', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->showkarma);
		$lists['cb_profile'] = mosHTML::selectList($yesno, 'cfg_cb_profile', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->cb_profile);
		$lists['enablePDF'] = mosHTML::selectList($yesno, 'cfg_enablePDF', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->enablePDF);
		$lists['enableRulesPage'] = mosHTML::selectList($yesno, 'cfg_enableRulesPage', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->enableRulesPage);
		$lists['rules_infb'] = mosHTML::selectList($yesno, 'cfg_rules_infb', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->rules_infb);
		$lists['enableHelpPage'] = mosHTML::selectList($yesno, 'cfg_enableHelpPage', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->enableHelpPage);
		$lists['help_infb'] = mosHTML::selectList($yesno, 'cfg_help_infb', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->help_infb);
		$lists['enableForumJump'] = mosHTML::selectList($yesno, 'cfg_enableForumJump', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->enableForumJump);
		$lists['userlist_online'] = mosHTML::selectList($yesno, 'cfg_userlist_online', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_online);
		$lists['userlist_avatar'] = mosHTML::selectList($yesno, 'cfg_userlist_avatar', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_avatar);
		$lists['userlist_name'] = mosHTML::selectList($yesno, 'cfg_userlist_name', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_name);
		$lists['userlist_username'] = mosHTML::selectList($yesno, 'cfg_userlist_username', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_username);
		$lists['userlist_group'] = mosHTML::selectList($yesno, 'cfg_userlist_group', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_group);
		$lists['userlist_posts'] = mosHTML::selectList($yesno, 'cfg_userlist_posts', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_posts);
		$lists['userlist_karma'] = mosHTML::selectList($yesno, 'cfg_userlist_karma', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_karma);
		$lists['userlist_email'] = mosHTML::selectList($yesno, 'cfg_userlist_email', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_email);
		$lists['userlist_usertype'] = mosHTML::selectList($yesno, 'cfg_userlist_usertype', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_usertype);
		$lists['userlist_joindate'] = mosHTML::selectList($yesno, 'cfg_userlist_joindate', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_joindate);
		$lists['userlist_lastvisitdate'] = mosHTML::selectList($yesno, 'cfg_userlist_lastvisitdate', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_lastvisitdate);
		$lists['userlist_userhits'] = mosHTML::selectList($yesno, 'cfg_userlist_userhits', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->userlist_userhits);
		$lists['usernamechange'] = mosHTML::selectList($yesno, 'cfg_usernamechange', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->usernamechange);
		$lists['reportmsg'] = mosHTML::selectList($yesno, 'cfg_reportmsg', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->reportmsg);
		$lists['captcha'] = mosHTML::selectList($yesno, 'cfg_captcha', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->captcha);
		$lists['mailfull'] = mosHTML::selectList($yesno, 'cfg_mailfull', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->mailfull);
		$lists['polls'] = mosHTML::selectList($yesno, 'cfg_polls', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->polls);
		$lists['fm'] = mosHTML::selectList($yesno, 'cfg_fm', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->fm);
		$lists['fm_guests'] = mosHTML::selectList($yesno, 'cfg_fm_guests', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->fm_guests);
		$lists['note'] = mosHTML::selectList($yesno, 'cfg_note', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->note);
		$lists['attach_guests'] = mosHTML::selectList($yesno, 'cfg_attach_guests', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->attach_guests);
		$lists['foto'] = mosHTML::selectList($yesno, 'cfg_foto', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->foto);
		$lists['gmap'] = mosHTML::selectList($yesno, 'cfg_gmap', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->gmap);
		$lists['puzzle'] = mosHTML::selectList($yesno, 'cfg_puzzle', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->puzzle);
		$lists['puzzle_numbers'] = mosHTML::selectList($yesno, 'cfg_puzzle_numbers', 'class="inputbox" size="1"', 'value', 'text', $fbConfig->puzzle_numbers);
		HTML_SIMPLEBOARD::showConfig($lists, $option);
	}

	/**
	 * @static Запись конфигурации
	 * @param $option
	 */
	public static function saveConfig($option){
		$database = FBJConfig::database();
		$fbConfig = FBJConfig::getInstance();
		foreach($_POST as $k => $v){
			if(strpos($k, 'cfg_') === 0){
				if(!get_magic_quotes_gpc()){
					$v = addslashes($v);
				}
				$k = (substr($k, 4));
				$sql = "REPLACE INTO #__fb_config (name, value) VALUES ('" . $k . "', '" . $v . "');";
				$database->setQuery($sql);
				$database->query();
			}
		}
		mosRedirect("index2.php?option=$option&task=showconfig", _FB_CFS);
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

