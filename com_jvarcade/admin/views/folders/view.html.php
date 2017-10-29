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
defined('_JEXEC') or die('Restricted access');

class jvarcadeViewFolders extends Joomla\CMS\MVC\View\HtmlView {
	var $permnames = array();

	function display($tpl = null) {
		
		$app = Joomla\CMS\Factory::getApplication();
		
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filter_order = $app->getUserStateFromRequest('jvarcade.folders.filter_order', 'filter_order', 'f.name', 'cmd' );
		$this->filter_order_Dir = $app->getUserStateFromRequest('jvarcade.folders.filter_order_Dir', 'filter_order_Dir', 'desc', 'word' );
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
		    throw new Exception(implode("\n", $errors), 500);
		}
		
		$model = $this->getModel();
		$this->permnames = $model->getAcl();
		
		$this->addToolBar();
		
		$this->addSidebar('folders');
		
		parent::display($tpl);
	}
	protected function addSidebar() {
		$this->sidebar = JHtmlSidebar::render();
	}
	
	function showPerms($perms) {
		$permsarr = explode(',', $perms);
		$result = '';
		foreach ($permsarr as $perm) {
			if ((int)$perm == 0) $result .= 'Guest, ';
			if(array_key_exists($perm, $this->permnames)) {
				$result .= $this->permnames[$perm]['name'] . ', ';
			}
			
		}
		$result = rtrim($result,', ');
		return $result;
	}
	
	protected function addToolBar() {
	    JToolBarHelper::title(JText::_('COM_JVARCADE_MANAGE_FOLDERS'), 'jvafolders');
	    JToolBarHelper::addNew('folder.add', JText::_('COM_JVARCADE_FOLDERS_ADD'));
	    JToolBarHelper::editList('folder.edit', JText::_('COM_JVARCADE_FOLDERS_EDIT'));
	    JToolBarHelper::deleteList(JText::_('COM_JVARCADE_FOLDERS_ASK_DELETE'), 'folders.delete', JText::_('COM_JVARCADE_FOLDERS_DELETE'));
	    JToolBarHelper::publishList('folders.publish', JText::_('COM_JVARCADE_FOLDERS_PUBLISH'), true);
	    JToolBarHelper::unpublishList('folders.unpublish', JText::_('COM_JVARCADE_FOLDERS_UNPUBLISH'), true);
	    jvarcadeToolbarHelper::addSubmenu($this->getName());
	}
}
