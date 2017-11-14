<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die();
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
<form action="index.php?option=com_jvarcade&view=contentratings" method="post" name="adminForm" id="adminForm" >
<table class="table table-striped">
			<tr>
				<th width="20"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.checkall'); ?></th>
				<th style="text-align: center;" class="title"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTENT_RATINGS_ID', 'id', $listDirn, $listOrder); ?></th>
				<th style="text-align: center;" class="title"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTENT_RATINGS_NAME', 'name', $listDirn, $listOrder); ?></th>
				<th style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTENT_RATINGS_WARNING_DISPLAYED', 'warningrequired', $listDirn, $listOrder); ?></th>
				<th style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('grid.sort', 'COM_JVARCADE_CONTENT_RATINGS_PUBLISHED', 'published', $listDirn, $listOrder); ?></th>
			</tr>
	<?php
			
			if (!empty($this->items)):
				foreach ($this->items as $i => $row):
					$checked = Joomla\CMS\HTML\HTMLHelper::_('grid.id', $i, $row->id, false, 'cid');
					$imgwarntag = Joomla\CMS\HTML\HTMLHelper::_('image','admin/icon-16-notice-note.png', '', array('border' => 0), true);
					$imgwarntag = ((int)$row->warningrequired ? $imgwarntag : '');
			?>
					<tr class="<?php echo "row$i"; ?>">
						<td style="text-align: center;"><?php echo $checked; ?></td>
						<td style="text-align: center;"><?php echo $row->id; ?></td>
						<td style="text-align: center;"><a href="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=contentrating&layout=edit&id=' . $row->id); ?>"><?php echo $row->name; ?></a></td>
						<td style="text-align: center;"><?php echo $imgwarntag; ?></td>
						<td style="text-align: center;"><?php echo Joomla\CMS\HTML\HTMLHelper::_('jgrid.published', $row->published, $i, 'contentratings.', true, 'cb'); ?></td>
					</tr>
			<?php endforeach;?>
			<?php endif;?>
			<tr>
				<td colspan="8" class="erPagination"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
</form>
