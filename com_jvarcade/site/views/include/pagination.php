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

?>

	<?php if ($this->pageNav->getPagesLinks()) : ?>

	<div id="pagenav">
		<ul class="pagination pagination-sm">
			<?php echo $this->pageNav->getPagesLinks(); ?>
			
		</ul>
		<?php echo $this->pageNav->getPagesCounter(); ?>
	</div>
	<?php endif; ?>
	