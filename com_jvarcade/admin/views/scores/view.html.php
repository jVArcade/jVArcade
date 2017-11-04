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

class jvarcadeViewScores extends Joomla\CMS\MVC\View\HtmlView {

	function display($tpl = null) {
	
		$app = Joomla\CMS\Factory::getApplication();
		
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filter_order = $app->getUserStateFromRequest('jvarcade.scores.filter_order', 'filter_order', 'p.date', 'cmd' );
		$this->filter_order_Dir = $app->getUserStateFromRequest('jvarcade.scores.filter_order_Dir', 'filter_order_Dir', 'desc', 'word' );
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
		    throw new Exception(implode("\n", $errors), 500);
		}
		
		$this->addToolBar();

		$this->addSidebar('scores');
		parent::display($tpl);
	}
	
	protected function addSidebar() {
		$this->sidebar = JHtmlSidebar::render();
	}
	
	protected function addToolBar(){
	    JToolBarHelper::title(JText::_('COM_JVARCADE_MANAGE_SCORES'), 'jvascores');
	    JToolBarHelper::deleteList(JText::_('COM_JVARCADE_SCORES_ASK_DELETE'), 'scores.delete', JText::_('COM_JVARCADE_SCORES_DELETE'));
	    JToolBarHelper::publishList('scores.publish', JText::_('COM_JVARCADE_SCORES_PUBLISH'));
	    JToolBarHelper::unpublishList('scores.unpublish', JText::_('COM_JVARCADE_SCORES_UNPUBLISH'));
	    jvarcadeToolbarHelper::addSubmenu($this->getName());
	}
}
