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

	<?php if ($this->pageNav->getPagesLinks()) : ?>

	<div id="pagenav">
		<ul class="pagination pagination-sm">
			<?php echo $this->pageNav->getPagesLinks(); ?>
			
		</ul>
		<?php echo $this->pageNav->getPagesCounter(); ?>
	</div>
	<?php endif; ?>
	