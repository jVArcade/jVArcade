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


class jvarcadeModelGame_upload extends Joomla\CMS\MVC\Model\BaseDatabaseModel {
	
	public function __construct() {
		parent::__construct();
		$this->dbo = Joomla\CMS\Factory::getDBO();
	

	}
	
	public function getFolderList() {
		$this->dbo->setQuery('SELECT id, name FROM #__jvarcade_folders ORDER BY id');
		return $this->dbo->loadObjectList();
	}
	
	
}
