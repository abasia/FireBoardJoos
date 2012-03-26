<?php
/**
* @version $Id: announcement.php 63 2007-04-17 21:23:17Z danialt $
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
	global $_MAMBOTS;
    class desc{ var $annsdescription = ""; }
    class sdesc{ var $anndescription = ""; }
$do         =mosGetParam($_REQUEST, "do", "");
$id         =intval(mosGetParam($_REQUEST, "id", ""));
$user_fields=@explode(',', $fbConfig['AnnModId']);
if (in_array($my->id, $user_fields) || $my->usertype == 'Administrator' || $my->usertype == 'Super Administrator')
    {
    $is_editor=true;
    }
else
    {
    $is_editor=false;
    }
?>
<?php
if ($do == "read")
    {
    $database->setQuery("SELECT id,title,sdescription,description,created ,published,showdate FROM #__fb_announcement  WHERE id='$id' AND published = 1 ");
    $anns=$database->loadObjectList();
    foreach ($anns as $ann)
        {
        $annID          =$ann->id;
        $anntitle       =$ann->title;
		
        $annsdescription    = $ann->sdescription;
             $row = new sdesc();
             $row->text = $annsdescription;
             $_MAMBOTS->loadBotGroup( 'content' );
             $params = new mosParameters( '' );
             $_MAMBOTS->trigger( 'onPrepareContent', array( &$row, &$params, 0 ), true );
             $sdescription = $row->text;
			 $anndescription     = $ann->description;
             $row = new desc();
             $row->text = $anndescription;
             $_MAMBOTS->loadBotGroup( 'content' );
             $params = new mosParameters( '' );
             $_MAMBOTS->trigger( 'onPrepareContent', array( &$row, &$params, 0 ), true );
             $description = $row->text;
	        $anncreated     =$ann->created;
    	    $annpublished   =$ann->published;
        	$annshowdate    =$ann->showdate;
        }
    if ($annpublished > 0)
        {
$is_user   =(strtolower($my->usertype) <> '');
$showlink  =sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=show&amp;Itemid='.$Itemid.'');
$addlink   =sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=add&amp;Itemid='.$Itemid.'');
$readlink  =sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=read&amp;id='.$annID.'&amp;Itemid='.$Itemid.'');
$editlink  =sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=edit&amp;id='.$annID.'&amp;Itemid='.$Itemid.'');
$deletelink=sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=delete&amp;id='.$annID.'&amp;Itemid='.$Itemid.'');
?>
        <table class = "<?php echo $boardclass; ?>forum-cat forumann" cellpadding = "0" cellspacing = "0" border = "0"
               width = "100%">
            <thead>
                <tr>
                    <th>
                        <div class = "cat-title">
                            <h3> <?php echo $mosConfig_sitename; ?> <?php echo _ANN_ANNOUNCEMENTS; ?> </h3>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class = "forumreadann"><div class="cat-title" style="background: url('<? echo "$mosConfig_live_site/components/com_fireboard/template/$fb_cur_template"; ?>/images/menu-bar.gif') repeat-x center;border:1px solid #878787;padding-left:8px;width:961px;"><h3><?php echo $anntitle; ?></h3></div>
                        <?php
                        if ($annshowdate > 0)
                            {
                        ?>
                            <div class = "anncreated"> <?php echo $anncreated; ?></div>
                        <?php
                            }
                        ?>
                        <div>
<?php echo $sdescription."<br />".$description; ?>
                        </div>
                        <?php
                        if ($is_editor)
                            {
                        ?>
                            <div>
<div id="bof-annmenu"> <a href = "<?php echo $editlink; ?>"><?php echo _ANN_EDIT; ?> </a> | <a href = "<?php echo $deletelink; ?>"><?php echo _ANN_DELETE; ?> </a> | <a href = "<?php echo $addlink; ?>"><?php echo _ANN_ADD; ?> </a> | <a href = "<?php echo $showlink; ?>"><?php echo _ANN_CPANEL; ?> </a> </div>
                            </div>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
<?php
        }
    else
        {
        }
    }
if ($is_editor)
    {
    if ($do == "show")
        {
$addlink=sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=add&amp;Itemid='.$Itemid.'');
?>
        <div style = "padding:5px; background:#373737; text-align:right;">
            <a href = "<?php echo $addlink;?>"><?php echo _ANN_ADD; ?></a>
        </div>
        <table width = "100%" border = "0" cellspacing = "0" cellpadding = "0">
            <tr class = "sectiontableheader">
                <th><?php echo _ANN_ID; ?>
                </th>
                <th><?php echo _ANN_DATE; ?>
                </th>
                <th><?php echo _ANN_TITLE; ?>
                </th>
                <th><?php echo _ANN_PUBLISH; ?>
                </th>
                <th><?php echo _ANN_EDIT; ?>
                </th>
                <th><?php echo _ANN_DELETE; ?>
                </th>
            </tr>
            <?php
            $query ="SELECT id, title, created, published FROM #__fb_announcement" . "\n "
                . "\n ORDER BY created DESC ";
            $database->setQuery($query);
            $rows=$database->loadObjectList();
            $tabclass=array
                (
                "sectiontableentry1",
                "sectiontableentry2"
                );
            $k   =0;
            if (count($rows) > 0)
                {
                foreach ($rows as $row)
                    {
        $deletelink=sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=delete&amp;id='.$row->id.'&amp;Itemid='.$Itemid.'');
        $editlink  =sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=edit&amp;id='.$row->id.'&amp;Itemid='.$Itemid.'');
                    $k = 1 - $k;
            ?>
                    <tr class = "<?php echo $tabclass[$k];?>">
                        <td>
                            #<?php echo $row->id; ?>
                        </td>
                        <td><?php echo $row->created; ?>
                        </td>
                        <td><?php echo $row->title; ?>
                        </td>
                        <td>
                            <?php
                            if ($row->published > 0)
                                {
                                echo _ANN_PUBLISHED;
                                }
                            else
                                {
                                echo _ANN_UNPUBLISHED;
                                }
                            ?>
                        </td>
                        <td><div id="bof-annmenu">
                            <a href = "<?php echo $editlink;?>"><?php echo _ANN_EDIT; ?></a>
                        </div></td>
                        <td><div id="bof-annmenu">
                            <a href = "<?php echo $deletelink;?>"><?php echo _ANN_DELETE; ?></a>
                        </div></td>
                    </tr>
            <?php
                    }
                }
            ?>
        </table>
<?php
        }
    if ($do == "doadd")
        {
		$showlink  =sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=show&amp;Itemid='.$Itemid.'');
        mosMakeHtmlSafe($_POST);
        $title       =mosGetParam($_REQUEST, "title", "");
		$description =$_REQUEST['description'];
		$sdescription =$_REQUEST['sdescription'];
        $created     =mosGetParam($_REQUEST, "created", "");
        $published    =mosGetParam($_REQUEST, "published", 0);
        $showdate    =mosGetParam($_REQUEST, "showdate", "");
        $query1="INSERT INTO #__fb_announcement VALUES ('', '$title', '$sdescription', '$description', '$created', '$published', '$ordering','$showdate')";
        $database->setQuery($query1);
        if ($database->query())
            {
            mosRedirect($showlink, _ANN_SUCCESS_ADD);
            }
        }
    if ($do == "add")
        {
        $mainframe->addCustomHeadTag("<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".$mosConfig_live_site."/includes/js/calendar/calendar-mos.css\" title=\"green\" />\n");
?>
<script language = "javascript" type = "text/javascript" src = "<?php echo $mosConfig_live_site;?>/includes/js/calendar/calendar_mini.js">
</script>
<script language = "javascript" type = "text/javascript" src = "<?php echo $mosConfig_live_site;?>/includes/js/calendar/lang/calendar-en.js">
</script>
<form action = "<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=announcement&amp;do=add'); ?>" method = "post" name = "addform">
<div align="center">
<table class="bof-postmessage" width="100%" align="center"><tr><td>
<div align="center">
	<strong><?php echo _ANN_TITLE; ?>:</strong>
    <br/>
    <input type = "text" name = "title" size = "40" maxlength = "150"/>
    <br/>
    <strong><?php echo _ANN_SORTTEXT; ?>:</strong>
    <br/>
				<?php
				editorArea( 'textarea1','', 'sdescription', '550', '200', '70', '15' ) ;
				if ($is_editor){
					initEditor();
				} 
				?>
    <br/>
    <hr/>
    <strong><?php echo _ANN_LONGTEXT; ?></strong>
    <br/>
				<?php
				editorArea( 'textarea2','', 'description', '550', '300', '70', '15' ) ;
				if ($is_editor){
					initEditor();
				} 
				?>
    <br/>
    <strong><?php echo _ANN_DATE; ?>:</strong>
    <input type = "text" name = "created" id = "anncreated" size = "40" maxlength = "150" value = "<?php echo _CURRENT_SERVER_TIME ;?>"/>
    <input type = "reset" class = "button" value = "..." onclick = "return showCalendar('anncreated', 'y-mm-dd');"/>
    <br/>
    <strong><?php echo _ANN_PUBLISH; ?></strong>
    <select name = "published">
        <option value = "1"><?php echo _ANN_YES; ?></option>
        <option value = "0"><?php echo _ANN_NO; ?></option>
    </select>
    <br/>
    <strong><?php echo _ANN_SHOWDATE; ?></strong>
    <select name = "showdate">
        <option value = "1"><?php echo _ANN_YES; ?></option>
        <option value = "0"><?php echo _ANN_NO; ?></option>
    </select>
	 :</strong>
  <input type = "text" name = "ordering" size = "5" value = "0"/>
    <br/>
    <INPUT TYPE = 'hidden' NAME = "do" value = "doadd">
    <input name = "submit" type = "submit" value = "<?php echo _ANN_SAVE; ?>"/>
	</div>
</td></tr></table>
</div>
</form>
<?php
        }
    if ($do == "doedit")
        {
			$showlink  =sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=show');
	        mosMakeHtmlSafe($_POST);
	        $title       =mosGetParam($_REQUEST, "title", "");
			$description =$_REQUEST['description'];
			$sdescription =$_REQUEST['sdescription'];
	        $created     =mosGetParam($_REQUEST, "created", "");
	        $published    =mosGetParam($_REQUEST, "published", 0);
	        $showdate    =mosGetParam($_REQUEST, "showdate", "");
	        $database->setQuery("UPDATE #__fb_announcement SET title='$title', description='$description', sdescription='$sdescription',  created='$created', published='$published', showdate='$showdate' WHERE id='$id'");
        if ($database->query())
            {
            mosRedirect($showlink, _ANN_SUCCESS_EDIT);
            }
        }
    if ($do == "edit")
        {
        $database->setQuery("SELECT * FROM #__fb_announcement WHERE id='$id'");
        $anns=$database->loadObjectList();
        if (count($anns) > 0)
            {
            foreach ($anns as $ann)
                {
                $annID          = $ann->id;
                $anntitle       =$ann->title;
                $annsdescription=$ann->sdescription;
                $anndescription =$ann->description;
                $anncreated     =$ann->created;
                $annpublished   =$ann->published;
                $annordering    =$ann->ordering;
                $annshowdate    =$ann->showdate;
                }
            }
        $mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" media="all" href="'.$mosConfig_live_site.'/includes/js/calendar/calendar-mos.css" title="green" />');
?>
<script language = "javascript" type = "text/javascript" src = "<?php echo $mosConfig_live_site;?>/includes/js/calendar/calendar_mini.js">
</script>
<script language = "javascript" type = "text/javascript" src = "<?php echo $mosConfig_live_site;?>/includes/js/calendar/lang/calendar-en.js">
</script>
<script type = "text/javascript">
    function validate_form()
        {
        valid = true;
        if (document.editform.title.value == "")
            {
            alert("<?php echo _AFB_NOTIT;?>");

            valid = false;
            }

        if (document.editform.sdescription.value == "")
            {
            alert("<?php echo _AFB_NOTEXT;?>");
            valid = false;
            }
        return valid;
        }
</script>
<form action = "<?php echo sefRelToAbs(JB_LIVEURL.'&amp;func=announcement&amp;do=show'); ?>"
      method = "post"
      name = "editform"
      onSubmit = "return validate_form ( );">
<div align="center">
<table class="bof-postmessage" width="100%"><tr><td>
<div align="center">
    <strong>#<?php echo $annID; ?> | </strong>
    <br/>
    <strong><?php echo _ANN_TITLE; ?>:</strong>
    <br/>
    <input type = "text" name = "title" size = "40" maxlength = "150" value = "<?php echo $anntitle ;?>"/>
    <br/>
    <strong><?php echo _ANN_SORTTEXT; ?>:</strong>
    <br/>
				<?php
				editorArea( 'textarea1',$annsdescription, 'sdescription', '550', '200', '70', '15' ) ;
				if ($is_editor){
					initEditor();
				} 
				?>
    <br/>
    <hr/>
    <strong><?php echo _ANN_LONGTEXT; ?>:</strong>
    <br/>
				<?php
				editorArea( 'textarea2',$anndescription, 'description', '550', '300', '70', '15' ) ;
				if ($is_editor){
					initEditor();
				} 
				?>
    <br/>
    <strong><?php echo _ANN_DATE; ?>:</strong>
    <input type = "text" name = "created" id = "anncreated" size = "40" maxlength = "150" value = "<?php echo $anncreated ;?>"/> 
    <input type = "reset" class = "button" value = "..." onclick = "return showCalendar('anncreated', 'y-mm-dd');"/>
    <br/>
    <strong><?php echo _ANN_SHOWDATE; ?>: &nbsp;&nbsp;&nbsp;</strong>
    <select name = "showdate">
        <option value = "1"
                <?php echo ($annshowdate == 1 ? 'selected="selected"' : ''); ?>><?php echo _ANN_YES; ?></option>
        <option value = "0"
                <?php echo ($annshowdate == 0 ? 'selected="selected"' : ''); ?>><?php echo _ANN_NO; ?></option>
    </select>
    <br/>
    <strong><?php echo _ANN_PUBLISH; ?>: &nbsp;&nbsp;&nbsp;</strong>
    <select name = "published">
        <option value = "1"
                <?php echo ($annpublished == 1 ? 'selected="selected"' : ''); ?>><?php echo _ANN_YES; ?></option>
        <option value = "0"
                <?php echo ($annpublished == 0 ? 'selected="selected"' : ''); ?>><?php echo _ANN_NO; ?></option>
    </select>
    <br/>
    <INPUT TYPE = 'hidden' NAME = "do" value = "doedit"/>
    <INPUT TYPE = 'hidden' NAME = "id" value = "<?php echo $annID ;?>"/>
    <input name = "submit" type = "submit" value = "<?php echo _ANN_SAVE; ?>"/>
    <br/>
    <br/>
    <br/>
	</div>
	</td></tr></table>
	</div>
</form>
<?php
        }
    if ($do == "delete")
        {
			$showlink  =sefRelToAbs('index.php?option=com_fireboard&amp;func=announcement&amp;do=show&amp;Itemid='.$Itemid.'');
        	$query1="DELETE FROM #__fb_announcement WHERE id=$id ";
	        $database->setQuery($query1);
	        $database->query();
	        if ($database->query())
            {
    	        mosRedirect($showlink, _ANN_DELETED);
            }
        }
    }	
?>