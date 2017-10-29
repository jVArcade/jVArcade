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
Joomla\CMS\HTML\HTMLHelper::_('formbehavior.chosen', 'select');
Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip');
?>
<form enctype="multipart/form-data" action="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=game&layout=edit&id=' . (int) $this->item->id); ?>" name="adminForm" id="adminForm" method="post">
	<input type="hidden" name="task" value="" />
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.startTabSet', 'jveditgame', array('active' => 'game_edit'));?>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.addTab', 'jveditgame', 'game_edit', JText::_('Edit Game')); ?>
	<div class="form-horizontal">
        <fieldset class="adminform">
            <div class="row-fluid">
                <div class="span6">
                		<div class="control-group">
							<div class="control-label">
								<label for="imagename"><?php echo JText::_('COM_JVARCADE_GAMES_IMAGE'); ?></label>
							</div>
							<div class="controls">
								<img src="<?php echo JVA_IMAGES_SITEPATH . 'games/' . $this->item->imagename; ?>" />
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
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.addTab', 'jveditgame', 'contestforgame', JText::_('COM_JVARCADE_CONTESTSLINK_CONTESTSFORGAME')); ?>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.renderModal', 'contestForGame', array('url' => Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=addgametocontest&tmpl=component&cid=' . $this->item->id, false), 'title' => 'Add Game To Contest', 'height' => '300', 'width' => '300'));?>
		<div class="row-fluid">
				<fieldset class="form-horizontal">
					
					<input class="btn btn-primary" type="button" onclick="jQuery.jva.showAddToContestPopup();" value="<?php echo JText::_('COM_JVARCADE_CONTESTSLINK_ADDTOCONTESTS'); ?>" >
					<input class="btn btn-primary" type="button" onclick="jQuery.jva.deleteGameFromContestMulti(<?php echo $this->item->id; ?>, 'game');" value="<?php echo JText::_('COM_JVARCADE_CONTESTSLINK_REMOVESELECTED'); ?>" >
					<div class="clr"></div>
					<div id="gamecontests"></div>
					<script type="text/javascript">
							jQuery(document).ready(function(){
							jQuery.jva.showGameContests(<?php echo $this->item->id; ?>);
								});
					</script>
					
				</fieldset>
		</div>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.endTab'); ?>
	<?php endif; ?>
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('bootstrap.addTab', 'jveditgame', 'maintenance', JText::_('COM_JVARCADE_MAINTENANCE_GAME')); ?>
	<div class="row-fluid">
		<div class="span6">
			<fieldset class="form-horizontal">
				<input class="btn btn-primary hasTooltip" type="button" onclick="jQuery.jva.doMaintenance('deleteallscores','game',<?php echo $this->item->id; ?>);" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_GAME_DELETEALLSCORES'); ?>">
				<div class="clr" style="margin-top:10px;"></div>
				<input class="btn btn-primary hasTooltip" type="button" onclick="jQuery.jva.doMaintenance('deleteguestscores','game',<?php echo $this->item->id; ?>);" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_GAME_DELETEGUESTSCORES'); ?>" >
				<div class="clr" style="margin-top:10px;"></div>
				<input class="btn btn-primary hasTooltip" type="button" onclick="jQuery.jva.doMaintenance('deletezeroscores','game',<?php echo $this->item->id; ?>);" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_GAME_DELETEZEROSCORES'); ?>" >
				<div class="clr" style="margin-top:10px;"></div>
				<input class="btn btn-primary hasTooltip" type="button" onclick="jQuery.jva.doMaintenance('clearallratings','game',<?php echo $this->item->id; ?>);" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_GAME_CLEARALLRATINGS'); ?>" >
				<div class="clr" style="margin-top:10px;"></div>
				<input class="btn btn-primary hasTooltip" type="button" onclick="jQuery.jva.doMaintenance('deletealltags','game',<?php echo $this->item->id; ?>);" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_GAME_DELETEALLTAGS'); ?>" >
				<div class="clr" style="margin-top:10px;"></div>
				<input class="btn btn-primary hasTooltip" type="button" onclick="jQuery.jva.clearMaintenance();" value="<?php echo JText::_('COM_JVARCADE_MAINTENANCE_CLEARMESSAGES'); ?>" >
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
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
</form>
