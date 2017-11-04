<?php
/**
 * @package		jVArcade
 * @version		2.15
 * @date		1-11-2017
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');

Joomla\CMS\HTML\HTMLHelper::_('formbehavior.chosen', 'select');
Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip');
?>
<img src="<?php echo JVA_IMAGES_SITEPATH . ($this->item->imagename ? 'folders/' . $this->item->imagename : 'cpanel/folder.png') ; ?>" border="0" alt="" />
<form enctype="multipart/form-data" action="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=folder&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <div class="row-fluid">
                <div class="span6">
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
