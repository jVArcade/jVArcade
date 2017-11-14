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
<?php foreach ($this->tags as $tag): ?>
	<?php $size = $this->min_font_size + ($tag->count - $this->minimum_count) * ($this->max_font_size - $this->min_font_size) / $this->spread; ?>
	 <a style="font-size: <?php echo floor($size); ?>px" href="<?php echo Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&task=showtag&tag=' . htmlspecialchars($tag->tag, ENT_QUOTES, 'UTF-8') . $this->show_itemid); ?>" title="<?php echo $tag->tag . ' returned ' . $tag->count . ' hits'; ?>">
		<?php echo htmlspecialchars(stripslashes($tag->tag), ENT_QUOTES, 'UTF-8'); ?>
	 </a>
<?php endforeach; ?>
<?php if($this->can_tag): ?>
<br />
<br />
<form>
<input type="text" name="tagsub" size="11" maxlength="20" />&nbsp;
<input type="button" class="btn btn-success" value="Tag" onclick="jQuery.jva.saveTag(<?php echo $this->game_id; ?>, this.form.tagsub.value, <?php echo $this->Itemid; ?>);return false;" />
</form>
<?php endif; ?>
<?php if($this->status): ?>
<br />
<em><?php echo JText::_('COM_JVARCADE_TAGSAVED'); ?></em>
<?php endif; ?>