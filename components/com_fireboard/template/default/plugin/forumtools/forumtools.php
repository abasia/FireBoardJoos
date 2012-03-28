<?php
/**
 * @version $Id: forumtools.php 462 2007-12-10 00:05:53Z fxstein $
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
$fbConfig = FBJConfig::getInstance();
?>
<script type="text/javascript">
	jQuery(document).ready(function () {
		jQuery("#jrftsw").click(function () {
			jQuery(".forumtools_contentBox").slideToggle("fast");
			return false;
		});
	});
</script>
<div id="fb_ft-cover">
	<div id="forumtools_control">
		<a href="#" id="jrftsw" class="forumtools" style="color:#FFFFFF;"><?php echo _FB_FORUMTOOLS;?></a>
	</div>
	<div class="forumtools_contentBox" id="box1">
		<div class="forumtools_content" id="subBox1">
			<ul>
				<li>
					<?php
					echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=post&amp;do=reply&amp;catid=' . $catid) . '">' . _GEN_POST_NEW_TOPIC . '</a>';
					?>
				</li>
				<?php
				if($func == "view"){
					if($fbConfig->enablePDF){
						?>
						<li>
							<?php
							echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;id=' . $id . '&amp;catid=' . $catid . '&amp;func=fb_pdf') . '">' . _GEN_PDF . '</a>';
							?>
						</li>
						<?php
					}
				}
				?>
				<li>
					<?php
					if($my->id != 0){
						echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=markThisRead&amp;catid=' . $catid) . '">' . _GEN_MARK_THIS_FORUM_READ . '</a>';
					}
					?>
				</li>
				<?php
				if($my->id != 0){
					echo ' <li>';
					if($view == "flat"){
						echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;view=threaded&amp;id=' . $id . '&amp;catid=' . $catid) . '" >';
						echo _GEN_THREADED_VIEW;
						echo '</a>';
					} else{
						echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;id=' . $id . '&amp;view=flat&amp;catid=' . $catid) . '" >';
						echo _GEN_FLAT_VIEW;
						echo "</a>";
					}
					echo ' </li>';
				}
				?>
				<li>
					<?php
					echo ' <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=latest') . '" >' . _GEN_LATEST_POSTS . '</a>';
					?>
				</li>
				<?php
				if($fbConfig->enableRulesPage){
					if($fbConfig->rules_infb){
						echo '<li>';
						echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=rules') . '" >';
						echo _GEN_RULES;
						echo '</a></li>';
					} else{
						echo '<li>';
						echo '<a href="' . $fbConfig->rules_link . '" >';
						echo _GEN_RULES;
						echo '</a></li>';
					}
				}
				if($fbConfig->enableHelpPage){
					if($fbConfig->help_infb){
						echo '<li>';
						echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=faq') . '" >';
						echo _GEN_HELP;
						echo '</a></li>';
					} else{
						echo '<li>';
						echo '<a href="' . $fbConfig->help_link . '" >';
						echo _GEN_HELP;
						echo '</a></li>';
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>