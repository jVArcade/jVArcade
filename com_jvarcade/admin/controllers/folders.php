<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die;



class jvarcadeControllerFolders extends Joomla\CMS\MVC\Controller\AdminController {
    
    public function getModel($name = 'Folder', $prefix = 'jvarcadeModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        
        return $model;
    }
	
}