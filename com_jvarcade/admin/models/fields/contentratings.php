<?php
/**
 * @package		jVArcade
 * @version		2.13
 * @date		2016-02-18
 * @copyright		Copyright (C) 2007 - 2014 jVitals Digital Technologies Inc. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvitals.com
 */

defined('JPATH_BASE') or die;

Joomla\CMS\Form\FormHelper::loadFieldClass('list');



class JFormFieldContentratings extends JFormFieldList
{
    /**
     * The form field type.
     *
     * @var		string
     * @since   1.6
     */
    protected $type = 'contentratings';
    
    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   1.6
     */
    
    public function getRatingsList() {
        $this->dbo = Joomla\CMS\Factory::getDbo();
        $this->dbo->setQuery('SELECT id AS value, name As text FROM #__jvarcade_contentrating ORDER BY id');
        $options = $this->dbo->loadObjectList();
        
        array_unshift($options, Joomla\CMS\HTML\HTMLHelper::_('select.option', '0', JText::_('COM_JVARCADE_GAMES_CONTENTRATING')));
        
        return $options;
    }
    
    public function getOptions()
    {
        $options = $this->getRatingsList();
        
        return array_merge(parent::getOptions(), $options);
    }
    
}
?>