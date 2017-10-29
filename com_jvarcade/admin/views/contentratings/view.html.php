<?php
/**
 * @package		jVArcade
* @version		2.13
* @date		2016-02-18
 * @copyright		Copyright (C) 2007 - 2014 jVitals Digital Technologies Inc. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvitals.com
 */



// no direct access
defined('_JEXEC') or die();

class jvarcadeViewContentratings extends Joomla\CMS\MVC\View\HtmlView {

	function display($tpl = null) {

		$app = Joomla\CMS\Factory::getApplication();
		
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filter_order = $app->getUserStateFromRequest('jvarcade.content_ratings.filter_order', 'filter_order', 'id', 'cmd' );
		$this->filter_order_Dir = $app->getUserStateFromRequest('jvarcade.content_ratings.filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
		    throw new Exception(implode("\n", $errors), 500);
		}
		
		$this->addToolBar();
		
		$this->addSidebar('contentratings');
		
		parent::display($tpl);
	}
	protected function addSidebar() {
		$this->sidebar = JHtmlSidebar::render();
	}
	
	protected function addToolBar(){
	    
	    JToolBarHelper::title(JText::_('COM_JVARCADE_CONTENT_RATINGS'), 'jvacontent');
	    JToolBarHelper::addNew('contentrating.add', JText::_('COM_JVARCADE_CONTENT_RATINGS_ADD'));
	    JToolBarHelper::editList('contentrating.edit', JText::_('COM_JVARCADE_CONTENT_RATINGS_EDIT'));
	    JToolBarHelper::deleteList(JText::_('COM_JVARCADE_CONTENT_RATINGS_ASK_DELETE'), 'contentratings.delete', JText::_('COM_JVARCADE_CONTENT_RATINGS_DELETE'));
	    JToolBarHelper::publishList('contentratings.publish', JText::_('COM_JVARCADE_CONTENT_RATINGS_PUBLISH'));
	    JToolBarHelper::unpublishList('contentratings.unpublish', JText::_('COM_JVARCADE_CONTENT_RATINGS_UNPUBLISH'));
	    jvarcadeToolbarHelper::addSubmenu($this->getName()); 
	    
	}
}
