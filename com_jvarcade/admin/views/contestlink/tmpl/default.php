<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<style>
.control-label {width: 30%!important;}
</style>
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="adminForm" id="adminForm" method="post">
	<input type="hidden" name="field_save" value="1" />
	<input type="hidden" name="option" value="com_jvarcade" />
	<input type="hidden" name="task" value="savegametocontest" />
	<input type="hidden" name="game_ids" id="game_ids" value="<?php echo $this->game_ids;?>" />
	<div class="row-fluid">
		<div class="span6">
		<h6><?php echo JText::_('COM_JVARCADE_CONTESTSLINK'); ?></h6>
		<fieldset class="form-horizontal">
			<div class="control-group">
				<div class="control-label">
					<label for="game_titles"><?php echo JText::_('COM_JVARCADE_GAMES_TITLE'); ?></label>
				</div>
				<div class="controls">
					<?php echo $this->game_titles; ?>
				</div>
			</div>
		</fieldset>
		<fieldset class="form-horizontal">
			<div class="control-group">
				<div class="control-label">
					<label for="contestlist"><?php echo JText::_('COM_JVARCADE_CONTESTS'); ?></label>
				</div>
				<div class="controls">
					<?php echo $this->contestlist; ?>
				</div>
			</div>
		</fieldset>
		<input type="button" onclick="jQuery.jva.addGameToContest();" value="<?php echo JText::_('COM_JVARCADE_CONTESTSLINK_ADD'); ?>" class="btn btn-primary">
		</div>
	</div>
</form>
