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

class jvarcadeModelGames extends Joomla\CMS\MVC\Model\ListModel {
	
	public function __construct($config = array()) {
	
		$this->dbo = Joomla\CMS\Factory::getDBO();
		$this->app = Joomla\CMS\Factory::getApplication();
	
		if(empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'g.id',
					'g.title',
					'g.numplayed',
					'g.scoring',
					'f.name',
					'g.published'
			);
		}
	
		parent::__construct($config);
	}
	
	protected function getListQuery(){
		// Initialize variables
		$query = $this->dbo->getQuery(true);
		// Create the base statement
		$query->select(array('SQL_CALC_FOUND_ROWS g.*', $this->dbo->quoteName('f.name')))
		->from($this->dbo->quoteName('#__jvarcade_games', 'g'))
		->leftJoin($this->dbo->quoteName('#__jvarcade_folders', 'f') . 'ON f.id = g.folderid');
		
		//Filter by Search
		$search = $this->getState('filter.search');
		
		if (!empty($search))
		{
			$like = $this->dbo->quote('%' . $search . '%');
			$query->where('g.title LIKE ' . $like);
		}
		
		//Filter by folders
		if ($folderId = $this->getState('filter.folders'))
		{
			$query->where('f.id = ' . $this->dbo->quote($folderId));
		}
		
		$orderCol = $this->state->get('list.ordering', 'g.id');
		$orderDirn = $this->state->get('list.direction', 'asc');
		
		$query->order($this->dbo->escape($orderCol) . ' ' . $this->dbo->escape($orderDirn));
		
		return $query;
		
	}
	
}