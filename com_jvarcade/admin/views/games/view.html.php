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
defined('_JEXEC') or die();


class jvarcadeViewGames extends Joomla\CMS\MVC\View\HtmlView {
	var $permnames = array();

	function display($tpl = null) {
	
		$app = Joomla\CMS\Factory::getApplication();
		
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->filter_order = $app->getUserStateFromRequest('jvarcade.games.filter_order', 'filter_order', 'g.id', 'cmd' );
		$this->filter_order_Dir = $app->getUserStateFromRequest('jvarcade.games.filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
		    throw new Exception(implode("\n", $errors), 500);
		}
		
		$this->addToolBar();
		
		$this->addSidebar('games');

		parent::display($tpl);
	}
	
	protected function addSidebar() {
		
		$this->sidebar = JHtmlSidebar::render();
	}
	
	protected function addToolBar() {
	    
	    JToolBarHelper::title(JText::_('COM_JVARCADE_MANAGE_GAMES'), 'jvagames');
	    JToolBarHelper::addNew('game.add', JText::_('COM_JVARCADE_GAMES_ADD'));
	    JToolBarHelper::editList('game.edit', JText::_('COM_JVARCADE_GAMES_EDIT'));
	    JToolBarHelper::deleteList(JText::_('COM_JVARCADE_GAMES_ASK_DELETE'), 'games.delete', JText::_('COM_JVARCADE_GAMES_DELETE'));
	    JToolBarHelper::publishList('games.publish', JText::_('COM_JVARCADE_GAMES_PUBLISH'));
	    JToolBarHelper::unpublishList('games.unpublish', JText::_('COM_JVARCADE_GAMES_UNPUBLISH'));
	    jvarcadeToolbarHelper::addSubmenu($this->getName());
	}
}
