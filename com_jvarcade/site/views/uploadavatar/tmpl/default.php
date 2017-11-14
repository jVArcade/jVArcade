<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */


defined('_JEXEC') or die;
Joomla\CMS\HTML\HTMLHelper::_('stylesheet', 'template.css', array('version' => 'auto', 'relative' => true));
?>


<div class="row-fluid">
<div class="span2">
<?php echo jvaHelper::showProfileAvatar($this->user_id); ?>
</div>

	<div class="span10">
				
					<h4><?php echo JText::_('COM_JVARCADE_UPLOAD_AVATAR_LEDGEND'); ?></h4>
					<h4><?php echo JText::_('COM_JVARCADE_UPLOAD_AVATAR_DIMS'); ?></h4>
					<hr>
				
				
					<form enctype="multipart/form-data" action="index.php?option=com_jvarcade&task=uploadavatar.upload" method="post">
						<input class="input_box" name="avatar" type="file" size="35" />
						<button class="btn btn-primary" type="submit" ><?php echo JText::_('COM_JVARCADE_UPLOAD_AVATAR_MODAL_TITLE');?></button>
						<input type="hidden" name="id" value="<?php echo $this->user_id; ?>" />
					</form>
				
				
	</div>
</div>

