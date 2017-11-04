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

class jvarcadeViewContest extends Joomla\CMS\MVC\View\HtmlView {

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
        

        if ($isNew) {
                $title = JText::_('COM_JVARCADE_CONTESTS_NEWCONTEST');
                $this->form->setFieldAttribute('image', 'label', JText::_('COM_JVARCADE_CONTESTS_NEWIMAGE'));
                $this->form->setFieldAttribute('image', 'description', JText::_('COM_JVARCADE_CONTESTS_NEWIMAGE_DESC'));
            }
            else
            {
                $title = $this->item->name;
                $this->form->setFieldAttribute('image', 'label', JText::_('COM_JVARCADE_CONTESTS_CHIMAGE'));
                $this->form->setFieldAttribute('image', 'description', JText::_('COM_JVARCADE_CONTESTS_CHIMAGE_DESC'));
 
            }
		
		
		JToolBarHelper::title($title, 'jvacontests');
		JToolBarHelper::save('contest.save', JText::_('COM_JVARCADE_CONTESTS_SAVE'));
		JToolBarHelper::cancel('contest.cancel', JText::_('COM_JVARCADE_CONTESTS_CANCEL'));
		
		
	}
	
}
