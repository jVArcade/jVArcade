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
Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip');
Joomla\CMS\HTML\HTMLHelper::_('behavior.multiselect');
Joomla\CMS\HTML\HTMLHelper::_('formbehavior.chosen', 'select');
?>

<form enctype="multipart/form-data" action="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=contest&layout=edit&id=' . (int) $this->item->id); ?>" name="adminForm" id="adminForm" method="post">
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.startTabSet', 'jveditcontest', array('active' => 'contest_edit'));?>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.addTab', 'jveditcontest', 'contest_edit', JText::_('Edit Contest')); ?>
	<div class="form-horizontal">
        <fieldset class="adminform">
            <div class="row-fluid">
                <div class="span6">
				<div class="control-group">
					<div class="control-label">
						<label for="imagename"><?php echo JText::_('COM_JVARCADE_CONTESTS_IMAGE'); ?></label>
					</div>
					<div class="controls">
						<img src="<?php echo JVA_IMAGES_SITEPATH . ($this->item->imagename ? 'contests/' . $this->item->imagename : 'cpanel/contests.png') ; ?>" border="0" alt="" />
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
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.endTab'); ?>
	<?php if ((int)$this->item->id) : ?>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.addTab', 'jveditcontest', 'gameforcontest', JText::_('COM_JVARCADE_CONTESTSLINK_GAMESINCONTEST')); ?>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.renderModal', 'gameForContest', array('url' => Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=addcontestgames&tmpl=component&cid=' . $this->item->id,false), 'title' => 'Add Game To Contest', 'height' => '300', 'width' => '600'));?>
	<div class="row-fluid">
			<fieldset class="form-horizontal">
				
				<input type="button" onclick="jQuery.jva.showAddGamesPopup();" value="<?php echo JText::_('COM_JVARCADE_CONTESTSLINK_ADDGAMES'); ?>" class="btn btn-primary">
				<input type="button" onclick="jQuery.jva.deleteGameFromContestMulti(<?php echo $this->item->id; ?>, 'contest');" value="<?php echo JText::_('COM_JVARCADE_CONTESTSLINK_REMOVESELECTED'); ?>" class="btn btn-primary">
				<div class="clr"></div>
				<div id="contestgames"></div>
				<script type="text/javascript">
					jQuery(document).ready(function(){
					jQuery.jva.showContestGames(<?php echo $this->item->id; ?>);
						});
				</script>
				
			</fieldset>
	</div>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.endTab'); ?>
	<?php endif; ?>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.addTab', 'jveditcontest', 'maintenance', JText::_('COM_JVARCADE_MAINTENANCE_CONTEST')); ?>
	<div class="row-fluid">
		<div class="span6">
			<fieldset class="form-horizontal">
				<input type="button" onclick="jQuery.jva.doMaintenance('deleteallscores','contest',<?php echo $this->item->id; ?>);" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_CONTEST_DELETEALLSCORES'); ?>" class="btn btn-primary hasTooltip">
				<div class="clr" style="margin-top:10px;"></div>
				<input type="button" onclick="jQuery.jva.doMaintenance('deleteguestscores','contest',<?php echo $this->item->id; ?>);" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_CONTEST_DELETEGUESTSCORES'); ?>" class="btn btn-primary hasTooltip">
				<div class="clr" style="margin-top:10px;"></div>
				<input type="button" onclick="jQuery.jva.doMaintenance('deletezeroscores','contest',<?php echo $this->item->id; ?>);" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_CONTEST_DELETEZEROSCORES'); ?>" class="btn btn-primary hasTooltip">
				<div class="clr" style="margin-top:10px;"></div>
				<input type="button" onclick="jQuery.jva.doMaintenance('recalculateleaderboard','contest',<?php echo $this->item->id; ?>);" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_CONTEST_RECALCULATELEADERBOARD'); ?>" class="btn btn-primary hasTooltip">
				<div class="clr" style="margin-top:10px;"></div>
				<input type="button" onclick="jQuery.jva.clearMaintenance();" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_CLEARMESSAGES'); ?>" class="btn btn-primary hasTooltip">
				<div class="clr" style="margin-top:10px;"></div>
			</fieldset>
			<fieldset class="form-horizontal">
				<div id="maintenance-msg"></div>
			</fieldset>
			<div class="clr"></div>
		</div>
	</div>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.endTab'); ?>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.endTabSet');?>
	<input type="hidden" name="task" value="" />
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
</form>

