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

class jvarcadeModelFolders extends Joomla\CMS\MVC\Model\ListModel {
	
public function __construct($config = array()) {
		
		$this->dbo = Joomla\CMS\Factory::getDBO();
		$this->app = Joomla\CMS\Factory::getApplication();
		
		if(empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'f.name',
					'f.published',
					'f.permissions',
					'parentname'
			);
		}
		
		parent::__construct($config);
	}
	
	protected function getListQuery(){
		// Initialize variables
		$query = $this->dbo->getQuery(true);
		// Create the base statement
		$query->select(array('SQL_CALC_FOUND_ROWS f.*', $this->dbo->quoteName('p.name', 'parentname')))
		->from($this->dbo->quoteName('#__jvarcade_folders', 'f'))
			->leftJoin($this->dbo->quoteName('#__jvarcade_folders', 'p') . 'ON p.id = f.parentid');
		
		// Add the list ordering clause
		$orderCol = $this->state->get('list.ordering', 'f.name');
		$orderDirn = $this->state->get('list.direction', 'desc');
		
		$query->order($this->dbo->escape($orderCol) . ' ' . $this->dbo->escape($orderDirn));

		return $query;
	}
	
	public function getAcl() {
		$query = 'SELECT id, title as name FROM #__usergroups';
		$this->dbo->setQuery($query);
		return $this->dbo->loadAssocList('id');
	}
	
}