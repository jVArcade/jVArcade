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

class jvarcadeViewMaintenance extends Joomla\CMS\MVC\View\HtmlView {

	function display($tpl = null) {
		$app = Joomla\CMS\Factory::getApplication();
		$task = $app->input->get('task', 'maintenance');
		$this->task = $task;
		
		JToolBarHelper::title(JText::_('COM_JVARCADE_MAINTENANCE'), 'jvamaintenance');
		jvarcadeToolbarHelper::addSubmenu($this->getName());
		$this->addSidebar('maintenance');
		
		
		parent::display($tpl);
	}
	protected function addSidebar() {
		$this->sidebar = JHtmlSidebar::render();
	}
}
