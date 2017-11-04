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
defined('_JEXEC') or die;

?>

		<div class="pu_bookmarks">
		<?php if ($this->config->get('bookmarks') == 1) : ?>
			<!-- AddToAny BEGIN --> 
				<a class="a2a_dd" href="https://www.addtoany.com/share_save">
						<img src="//static.addtoany.com/buttons/share_save_171_16.png" width="171" height="16" border="0" alt="Share"/>
				</a> 
				<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script> 
			<!-- AddToAny END -->
		<?php endif;?>
		</div>
	