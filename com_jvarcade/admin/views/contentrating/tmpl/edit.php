<?php
/**
 * @package		jVArcade
 * @version		2.13
 * @date		2016-02-18
 * @copyright		Copyright (C) 2007 - 2014 jVitals Digital Technologies Inc. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvitals.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');
Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip');
?>
<form enctype="multipart/form-data" action="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=contentrating&layout=edit&id=' . (int) $this->item->id); ?>" name="adminForm" id="adminForm" method="post">
	<div class="form-horizontal">
      <fieldset class="adminform">
          <div class="row-fluid">
             <div class="span6">
				<div class="control-group">
					<div class="control-label">
						<label for="imagename"><?php echo JText::_('COM_JVARCADE_CONTENT_RATINGS_IMAGE'); ?></label>
					</div>
					<div class="controls">
						<img src="<?php echo JVA_IMAGES_SITEPATH . 'contentrating/' . $this->item->imagename; ?>" />
					</div>
				</div>
				<?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                <?php endforeach; ?>
             </div>
          </div>  
	 </fieldset>
	</div>
<input type="hidden" name="task" value="" />
<?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
</form>
