<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');


class jvarcadeModelGame extends Joomla\CMS\MVC\Model\AdminModel {
	
	public function __construct($config = array()){
	    
	    $config['event_after_save'] = 'onJvaGameSave';
	    $config['event_after_delete'] = 'onJvaGameDelete';
	    
	    parent::__construct($config);
	}
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
	public function getTable($type = 'Game', $prefix = 'jvarcadeTable', $config = array())
	{
	    return Joomla\CMS\Table\Table::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
	    // Get the form.
	    $form = $this->loadForm(
	        'com_jvarcade.game',
	        'game',
	        array(
	            'control' => 'jform',
	            'load_data' => $loadData
	        )
	        );
	    
	    if (empty($form))
	    {
	        return false;
	    }
	    
	    return $form;
	}
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
	    // Check the session for previously entered form data.
	    $data = Joomla\CMS\Factory::getApplication()->getUserState(
	        'com_jvarcade.edit.game.data',
	        array()
	        );
	    
	    if (empty($data))
	    {
	        $data = $this->getItem();
	    }
	    
	    return $data;
	    
	}
	
	public function save($data) {
	    new JvaFileHandler(JDispatcher::getInstance(), $this);
	    $this->input = Joomla\CMS\Factory::getApplication()->input;
	    $files = $this->input->files->get('jform');
	    $data['image'] = $files['image'];
	    $data['file'] = $files['file'];
	    return parent::save($data);
	    
	}
	
	public function delete(&$pks){
	    new JvaFileHandler(JDispatcher::getInstance(), $this);
	    return parent::delete($pks);
	}
	
	
}