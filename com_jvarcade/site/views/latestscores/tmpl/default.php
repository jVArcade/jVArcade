<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die;

?>
<div id="puarcade_wrapper">
	
	<?php include_once(JVA_TEMPLATES_INCPATH . 'menu.php'); ?>
	
	<div class="pu_heading" style="text-align: center;"><?php echo $this->tabletitle ?></div>
	<div class="pu_ListContainer">
		<table class="pu_ListHeader">
			<tr>
				<th width="20%" colspan="2" style="text-align: center;">
					<?php echo Joomla\CMS\HTML\HTMLHelper::_('jvarcade.html.sort', 'COM_JVARCADE_GAME', 'g.title', @$this->lists['order_Dir'], @$this->lists['order'], $this->sort_url); ?>
				</th>
				<th width="20%" colspan="2" style="text-align: center;">
					<?php echo Joomla\CMS\HTML\HTMLHelper::_('jvarcade.html.sort', 'COM_JVARCADE_USER', (!(int)$this->config->get('show_usernames') ? 'u.name' : 'u.username'), @$this->lists['order_Dir'], @$this->lists['order'], $this->sort_url); ?>
				</th>
				<th width="10%" style="text-align: center;">
					<?php echo Joomla\CMS\HTML\HTMLHelper::_('jvarcade.html.sort', 'COM_JVARCADE_SCORE', 'p.score', @$this->lists['order_Dir'], @$this->lists['order'], $this->sort_url); ?>
				</th>
				<th width="30%" style="text-align: center;">
					<?php echo Joomla\CMS\HTML\HTMLHelper::_('jvarcade.html.sort', 'COM_JVARCADE_DATE', 'p.date', @$this->lists['order_Dir'], @$this->lists['order'], $this->sort_url); ?>
				</th>
				<th width="20%" style="text-align: center;">
					<?php echo JText::_('COM_JVARCADE_HIGH_SCORE'); ?>
				</th>
			</tr>
		</table>
	</div>
	
	<div id="FlashTable">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<?php foreach ($this->scores as $score) : ?>
		<?php $alt = htmlspecialchars(stripslashes($score['title'])); ?>
			<tr class="sectiontableentry">
				<td width="10%">
					<a href="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=game&id=' . $score['gameid'], false); ?>">
						<img src="<?php echo JVA_IMAGES_SITEPATH . 'games/' . $score['imagename']; ?>" border="0" height="50" width="50" alt="<?php echo $alt;?>" class="hasTooltip" data-original-title="<strong><?php echo $alt; ?></strong>" />
					</a>
				</td>
				<td width="10%">
					<a href="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=game&id=' . $score['gameid'], false); ?>" class="hasTooltip" data-original-title="<strong><?php echo $alt; ?></strong></br><?php echo html_entity_decode($score['description'], ENT_QUOTES, 'UTF-8'); ?>">
						<b><?php echo jvaHelper::truncate(stripslashes($score['title']), (int)$this->config->get('truncate_title')); ?></b>
					</a>
				</td>
				<td width="10%" style="text-align: center;">
				<?php if ($this->config->get('show_avatar') == 1) : ?>
					<?php echo jvaHelper::showAvatar($score['userid']); ?>
				<?php endif; ?>
				</td>
				<td width="10%" style="text-align: center;">
					<?php echo jvaHelper::userlink((int)$score['userid'], (!(int)$this->config->get('show_usernames') ? $score['name'] : $score['username'])); ?>
				</td>
				<td width="10%">
					<center><?php echo $score['score']; ?></center>
				</td>
				<td width="30%">
					<center><?php echo jvaHelper::formatDate($score['date']); ?></center>
				</td>
				<td width="20%">
					<center>
					<?php if (array_key_exists($score['gameid'], $this->highscores) && count($this->highscores[$score['gameid']]) && (int)$this->highscores[$score['gameid']]['score']) : ?>
						<?php if($this->highscores[$score['gameid']]['score'] == $score['score']) : ?>
							<img src="<?php echo JVA_IMAGES_SITEPATH . 'cpanel/menu-contests.png'; ?>" border="0" align="left" alt="" />
						<?php endif; ?>
						<b><?php echo JText::_('COM_JVARCADE_HIGH_SCORE') ?> : <?php echo $this->highscores[$score['gameid']]['score'] ?></b><br/>
						<b><?php echo JText::_('COM_JVARCADE_SCORE_BY') ?> :<?php echo $this->highscores[$score['gameid']]['username'] ?></b><br/>
						<a href="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=scores&id=' . $score['gameid'], false) ?>">[<?php echo JText::_('COM_JVARCADE_ALL_SCORES')?>]</a>
					<?php endif; ?>
					</center>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>

	<table id="pufooter" class="pu_Listfooter"><tr><td>&nbsp;</td></tr></table>
	
	<?php include_once(JVA_TEMPLATES_INCPATH . 'pagination.php'); ?>
	
	<?php include_once(JVA_TEMPLATES_INCPATH . 'footer.php'); ?>
	
</div>
