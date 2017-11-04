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
defined('_JEXEC') or die;

require_once (JPATH_COMPONENT . '/include/init.php');


$controller = Joomla\CMS\MVC\Controller\BaseController::getInstance('jvarcade');
$controller->execute(Joomla\CMS\Factory::getApplication()->input->get('task'));
$controller->redirect();

?>
