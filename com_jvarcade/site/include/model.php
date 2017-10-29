<?php
/**
 * @package		jVArcade
 * @version		2.14
 * @date		2016-03-12
 * @copyright		Copyright (C) 2007 - 2014 jVitals Digital Technologies Inc. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvitals.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');

class jvarcadeModelCommon extends JModelList {

	protected $config = null;
	protected $global_conf = null;
	protected $dbo = null;
	protected $user = null;
	protected $pagination = null;
	protected $orderby = null;
	protected $orderdir = null;

	public function __construct() {
	
		parent::__construct();
		$this->dbo = JFactory::getDbo();
		$this->user = JFactory::getUser();
		$this->config = JComponentHelper::getParams('com_jvarcade');
		$this->global_conf = JFactory::getConfig();
 
        // Get pagination request variables
		$input = JFactory::getApplication()->input;
		$limit = $this->config->get('GamesPerPage');
        $limitstart = $input->get('limitstart', 0, '', 'int');
 
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
 
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
	}
	
	public function getTotal() {
		$this->dbo->setQuery('SELECT FOUND_ROWS();');
		return (int)$this->dbo->loadResult();
	}
	
	public function getPagination() {
		// Load the content if it doesn't already exist
		if (empty($this->pagination)) {
			jimport('cms.pagination.pagination');
			$this->pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->pagination;
	}
	
	public function setOrderBy($orderby) {
		$this->orderby = $orderby;
	}

	public function setOrderDir($orderdir) {
		$this->orderdir = $orderdir;
	}

	public function getConf() {
		if (!$this->config) {
		    JComponentHelper::getParams('com_jvarcade');
		}
		return $this->config;
	}
	
	public function getTimezone() {
		$my = JFactory::getUser();
		$app = JFactory::getApplication();
		// TIMEZONE - if user is logged in we use the user timezone, if guest - we use timezone in global settings
		$timezone = ((int)$my->guest ? $app->getCfg('offset') : $my->getParam('timezone', $app->getCfg('offset')));
			
			
	   return $timezone;
	}

}

?>
