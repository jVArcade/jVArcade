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
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="adminForm" id="customFldForm" method="post">
	<input type="hidden" name="field_save" value="1" />
	<input type="hidden" name="option" value="com_jvarcade" />
	<input type="hidden" name="task" value="savegametocontest" />
	<input type="hidden" name="contest_id" id="contest_id" value="<?php echo $this->contest_id;?>" />
	<div class="row-fluid">
		<div class="span6">
			<h6><?php echo JText::_('COM_JVARCADE_CONTESTSLINKGAMES'); ?></h6>
			<fieldset class="form-horizontal">
				<div class="control-group">
					<div class="control-label">
						<label for="gameslist"><?php echo JText::_('COM_JVARCADE_GAMES'); ?></label>
					</div>
					<div class="controls">
						<?php echo $this->gameslist; ?>
					</div>
				</div>
			</fieldset>
			<input type="button" onclick="jQuery.jva.addContestGames();" value="<?php echo JText::_('COM_JVARCADE_CONTESTSLINK_ADD'); ?>" class="btn btn-primary">
		</div>
	</div>
</form>
