<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');


class jvarcadeModelScore extends Joomla\CMS\MVC\Model\AdminModel {
    
    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $type    The table name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  Joomla\CMS\Table\Table  A Joomla\CMS\Table\Table object
     *
     * @since   1.6
     */
    public function getTable($type = 'Score', $prefix = 'jvarcadeTable', $config = array())
    {
        return Joomla\CMS\Table\Table::getInstance($type, $prefix, $config);
        
    }
    
    public function getForm($data = array(), $loadData = true){
        
    }
    
}