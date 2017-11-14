<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');

class jvarcadeModelCommon extends Joomla\CMS\MVC\Model\ListModel {

	protected $config = null;
	protected $global_conf = null;
	protected $dbo = null;
	protected $user = null;
	protected $pagination = null;
	protected $orderby = null;
	protected $orderdir = null;

	public function __construct() {
	
		parent::__construct();
		$this->dbo = Joomla\CMS\Factory::getDbo();
		$this->user = Joomla\CMS\Factory::getUser();
		$this->config = Joomla\CMS\Component\ComponentHelper::getParams('com_jvarcade');
		$this->global_conf = Joomla\CMS\Factory::getConfig();
 
        // Get pagination request variables
		$input = Joomla\CMS\Factory::getApplication()->input;
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
			$this->pagination = new Joomla\CMS\Pagination\Pagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
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
		    Joomla\CMS\Component\ComponentHelper::getParams('com_jvarcade');
		}
		return $this->config;
	}
	
	public function getTimezone() {
		$my = Joomla\CMS\Factory::getUser();
		$app = Joomla\CMS\Factory::getApplication();
		// TIMEZONE - if user is logged in we use the user timezone, if guest - we use timezone in global settings
		$timezone = ((int)$my->guest ? $app->getCfg('offset') : $my->getParam('timezone', $app->getCfg('offset')));
			
			
	   return $timezone;
	}

}

?>
