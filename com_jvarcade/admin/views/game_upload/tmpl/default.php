<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');

Joomla\CMS\HTML\HTMLHelper::_('behavior.multiselect');
Joomla\CMS\HTML\HTMLHelper::_('formbehavior.chosen', 'select');
Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip');
?>
<script>
  jQuery(document).ready(function() {
	  
	jQuery('#install_package_but').on("click", function(e){
		    e.preventDefault();
		    jQuery('#adminForm').attr('action', "<?php echo Joomla\CMS\Uri\Uri::base(); ?>index.php?option=com_jvarcade&task=game_upload.installUpload").submit();
		});

	jQuery('#install_directory_but').on("click", function(e){
		    e.preventDefault();
		    jQuery('#adminForm').attr('action', "<?php echo Joomla\CMS\Uri\Uri::base(); ?>index.php?option=com_jvarcade&task=game_upload.installFolder").submit();
		});
});
</script>
<style>
.control-label {width: 30%!important;}
</style>
	<div class="row-fluid">
		<?php if(!empty( $this->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
		<?php endif;?>
			<div class="row-fluid">
				<div class="span6">
				<form enctype="multipart/form-data" action="/" name="adminForm" id="adminForm" method="post">
				<table>
				<th><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_CHOOSE'); ?></th>
				</table>
					
					<fieldset class="form-horizontal">
					<div class="control-group">
							<div class="control-label">
								<label class="hasTooltip" data-original-title="<strong><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_FOLDER'); ?></strong>"><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_FOLDER'); ?></label>
							</div>
							<div class="controls">
								<?php echo $this->list_folders();?><br>
							</div>
					</div>
					</fieldset>
					<fieldset class="form-horizontal">
					<div class="control-group">
							<div class="control-label">
								<label class="hasTooltip" data-original-title="<strong><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_PUBLISHED'); ?></strong>"><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_PUBLISHED'); ?></label>
							</div>
							<div class="controls">
								<?php echo Joomla\CMS\HTML\HTMLHelper::_('jvarcade.html.booleanlist',  'published', 'size="1"', $this->published, 'JYES', 'JNO', 'publish');?>
							</div>
					</div>
					</fieldset>
					<hr>
					<table class="adminform">
						<tr><th><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_UPLOAD_FILE'); ?></th></tr>
						<tr><td><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_FILE_DESC'); ?></td></tr>
					</table>
			<table class="adminform">
				<tr>
					<td>
						<input class="input_box" id="install_package" name="install_package[]" type="file" size="35" />
						<button class="btn btn-primary" type="submit" id="install_package_but" ><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_UPLOAD_BUTTON'); ?></button>
					</td>
				</tr>
			</table>
			<hr>
				<table class="adminform">
				<tr><th><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_INSTALL_FROM_DIR'); ?></th></tr>
				<tr><td><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_INSTALL_FROM_DIR_DESC'); ?></td></tr>
				</table>

			
			<table class="adminform">
				<tr>
					<td>
						<input type="text" id="install_directory" name="install_directory" class="input_box" size="70" value="<?php echo $this->tmp_path; ?>" />
						<button class="btn btn-primary" type="submit" id="install_directory_but"><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_INSTALL_BUTTON'); ?></button>
					</td>
				</tr>
			</table>
			</form>

		</div>
	
	<div class="span6" style="float:right;">
		<fieldset class="adminform">
		<legend><?php echo JText::_('COM_JVARCADE_UPLOADARCHIVE_LEGEND_TITLE'); ?></legend>
		<?php echo $this->legend; ?>
		</fieldset>
	</div>
	<div class="clr"></div>
	</div>
</div>

