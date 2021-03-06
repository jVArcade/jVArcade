<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');
Joomla\CMS\HTML\HTMLHelper::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->filter_order);
$listDirn = $this->escape($this->filter_order_Dir);
?>
<?php if(!empty( $this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else : ?>
<div id="j-main-container">
<?php endif;?>
<form action="index.php?option=com_jvarcade&view=contests" method="post" name="adminForm" id="adminForm">
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="20"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.checkall'); ?></th>
				<th style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTESTS_ID', 'id', $listDirn, $listOrder); ?></th>
				<th style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTESTS_NAME', 'name', $listDirn, $listOrder); ?></th>
				<th style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTESTS_START', 'startdatetime', $listDirn, $listOrder); ?></th>
				<th style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTESTS_END', 'enddatetime', $listDirn, $listOrder); ?></th>
				<th style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTESTS_GAMECOUNT', 'maxplaycount', $listDirn, $listOrder); ?></th>
				<th style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTESTS_PUBLISHED', 'published', $listDirn, $listOrder); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php
			if (!empty($this->items)):
				foreach ($this->items as $i => $row):
					$checked = Joomla\CMS\HTML\HTMLHelper::_('grid.id', $i, $row->id, false, 'cid');
					?>
					<tr class="<?php echo "row$i"; ?>">
						<td style="text-align: center;"><?php echo $checked; ?></td>
						<td style="text-align: center;"><?php echo $row->id; ?></td>
						<td style="text-align: center;"><a href="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=contest&layout=edit&id=' . $row->id); ?>"><?php echo $row->name; ?></a></td>
						<td style="text-align: center;"><?php echo jvaHelper::formatDate($row->startdatetime); ?></td>
						<td style="text-align: center;"><?php echo jvaHelper::formatDate($row->enddatetime); ?></td>
						<td style="text-align: center;"><?php echo $row->maxplaycount; ?></td>
						<td style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('jgrid.published', $row->published, $i, 'contests.', true, 'cb'); ?></td>
					</tr>
			<?php endforeach;?>
			<?php endif;?>
			<tr>
				<td colspan="8" class="erPagination"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
</form>
