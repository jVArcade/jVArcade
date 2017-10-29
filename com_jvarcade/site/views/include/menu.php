<?php
/**
 * @package		jVArcade
 * @version		2.14
 * @date		2016-03-12
 * @copyright		Copyright (C) 2007 - 2014 jVitals Digital Technologies Inc. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvitals.com
 */



// no direct access
defined('_JEXEC') or die;

?>
	

	<?php if ($this->config->get('specialfolders') == 1) : ?>
	<div class="navbar">
		<div class="navbar-inner">
			<div class="visible-desktop">
				<ul class="nav">
				<?php if (($this->config->get('faves') == 1) && ((int)$this->user->get('id') > 0)) : ?>
				<li>
					<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/fav25.png" alt="" />
					<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=favourite');?>"><?php echo JText::_('COM_JVARCADE_MY_FAVORITES'); ?></a>
				</li>
				<?php endif; ?>
				<?php if ($this->config->get('leaderboard') == 1) : ?>
				<li>
					<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/leaderboard25.png" alt="" />
					<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=leaderboard');?>"><?php echo JText::_('COM_JVARCADE_LEADERBOARD'); ?></a>
				</li>
				<?php endif; ?>
				<li>
					<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/contest25.png" alt="" />
					<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=contests');?>"><?php echo JText::_('COM_JVARCADE_CONTESTS'); ?></a>
				</li>
				<li>
					<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/newest25.png" alt="" />
					<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=newest');?>"><?php echo JText::_('COM_JVARCADE_NEWEST_GAMES'); ?></a>
				</li>
				<li>
					<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/popular25.png" alt="" />
					<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=popular');?>"><?php echo JText::_('COM_JVARCADE_POPULAR_GAMES'); ?></a>
				</li>
				<li>
					<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/all25.png" alt="" />
					<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=home');?>"><?php echo JText::_('COM_JVARCADE_ALL'); ?></a>
				</li>
				</ul>
			</div>
			<div class="hidden-desktop">
				<div class="nav navbar-nav pull-left">
					<div>
						<a class="btn btn-link" data-target=".collapse" data-toggle="collapse"><i class="icon-large icon-list" aria-hidden="true"></i> <b class="caret"></b></a>
					</div>
					<div class="collapse">
						<ul class="nav">
							<?php if (($this->config->get('faves') == 1) && ((int)$this->user->get('id') > 0)) : ?>
							<li>
								<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/fav25.png" alt="" />
								<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=favourite');?>"><?php echo JText::_('COM_JVARCADE_MY_FAVORITES'); ?></a>
							</li>
							<?php endif; ?>
							<?php if ($this->config->get('leaderboard') == 1) : ?>
							<li>
								<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/leaderboard25.png" alt="" />
								<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=leaderboard');?>"><?php echo JText::_('COM_JVARCADE_LEADERBOARD'); ?></a>
							</li>
							<?php endif; ?>
							<li>
								<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/contest25.png" alt="" />
								<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=contests');?>"><?php echo JText::_('COM_JVARCADE_CONTESTS'); ?></a>
							</li>
							<li>
								<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/newest25.png" alt="" />
								<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=newest');?>"><?php echo JText::_('COM_JVARCADE_NEWEST_GAMES'); ?></a>
							</li>
							<li>
								<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/popular25.png" alt="" />
								<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=popular');?>"><?php echo JText::_('COM_JVARCADE_POPULAR_GAMES'); ?></a>
							</li>
							<li>
								<img src="<?php echo JVA_IMAGES_SITEPATH; ?>icons/all25.png" alt="" />
								<a href="<?php echo JRoute::_('index.php?option=com_jvarcade&view=home');?>"><?php echo JText::_('COM_JVARCADE_ALL'); ?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	