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

class jvarcadeViewFolder extends Joomla\CMS\MVC\View\HtmlView {
    
    /**
     * The JForm object
     *
     * @var  JForm
     */
    protected $form;
    
	function display($tpl = null) {

		
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
		    throw new Exception(implode("\n", $errors), 500);
		}
		
		
		$this->addToolBar();	
		
		
		parent::display($tpl);
	}
	
	
	protected function addToolBar() {
	    $input = Joomla\CMS\Factory::getApplication()->input;
	    
	    // Hide Joomla Administrator Main menu
	    $input->set('hidemainmenu', true);
	    
	    $isNew = ($this->item->id == 0);
	    
	    if ($isNew)
	    {
	        $title = JText::_('COM_JVARCADE_FOLDERS_ADD') . ' ' . JText::_('COM_JVARCADE_FOLDERS_FOLDER');
	    }
	    else
	    {
	        $title = JText::_('COM_JVARCADE_FOLDERS_FOLDER') . ': ' . $this->item->name;
	    }
	    
	    JToolBarHelper::title($title, 'jvafolders');
	    JToolBarHelper::save('folder.save', JText::_('COM_JVARCADE_FOLDERS_SAVE'));
	    JToolBarHelper::cancel('folder.cancel', JText::_('COM_JVARCADE_FOLDERS_CANCEL'));
	    
	}
	
}
