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

class jvarcadeViewContests extends Joomla\CMS\MVC\View\HtmlView {
	

	function display($tpl = null) {
		
	    $app = Joomla\CMS\Factory::getApplication();
		
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filter_order = $app->getUserStateFromRequest('jvarcade.contests.filter_order', 'filter_order', 'id', 'cmd' );
		$this->filter_order_Dir = $app->getUserStateFromRequest('jvarcade.contests.filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
		    throw new Exception(implode("\n", $errors), 500);
		}
		
		$this->addToolBar();
		
		$this->addSidebar('contests');
		
		parent::display($tpl);
	}
	protected function addSidebar() {
		$this->sidebar = JHtmlSidebar::render();
	}
	protected function addToolBar() {
	    JToolBarHelper::title(JText::_('COM_JVARCADE_CONTESTS'), 'jvacontests');
	    JToolBarHelper::addNew('contest.add', JText::_('COM_JVARCADE_CONTESTS_ADD'));
	    JToolBarHelper::editList('contest.edit', JText::_('COM_JVARCADE_CONTESTS_EDIT'));
	    JToolBarHelper::deleteList(JText::_('COM_JVARCADE_CONTESTS_ASK_DELETE'), 'contests.delete', JText::_('COM_JVARCADE_CONTESTS_DELETE'));
	    JToolBarHelper::publishList('contests.publish', JText::_('COM_JVARCADE_CONTESTS_PUBLISH'));
	    JToolBarHelper::unpublishList('contests.unpublish', JText::_('COM_JVARCADE_CONTESTS_UNPUBLISH'));
	    jvarcadeToolbarHelper::addSubmenu($this->getName());
	}
	
}
