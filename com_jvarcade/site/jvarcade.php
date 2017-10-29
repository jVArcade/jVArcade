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
defined('_JEXEC') or die;

require_once (JPATH_COMPONENT . '/include/init.php');


$controller = Joomla\CMS\MVC\Controller\BaseController::getInstance('jvarcade');
$input = Joomla\CMS\Factory::getApplication()->input;

// Create the controller
$controller->execute($input->get('view', 'home'));
$controller->redirect();

?>
