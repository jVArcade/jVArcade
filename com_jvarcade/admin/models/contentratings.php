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
defined('_JEXEC') or die;

class jvarcadeModelContentratings extends Joomla\CMS\MVC\Model\ListModel {
	
	public function __construct($config = array()) {
	
		$this->dbo = Joomla\CMS\Factory::getDBO();
		$this->app = Joomla\CMS\Factory::getApplication();
	
		if(empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'id',
					'name',
					'warningrequired',
					'published'
			);
		}
	
		parent::__construct($config);
	}
	
	protected function getListQuery(){
		// Initialize variables
		$query = $this->dbo->getQuery(true);
		// Create the base statement
		$query->select('SQL_CALC_FOUND_ROWS *')->from('#__jvarcade_contentrating');
	
		// Add the list ordering clause
		$orderCol = $this->state->get('list.ordering', 'id');
		$orderDirn = $this->state->get('list.direction', 'asc');
	
		$query->order($this->dbo->escape($orderCol) . ' ' . $this->dbo->escape($orderDirn));
	
		return $query;
	}
	
}
