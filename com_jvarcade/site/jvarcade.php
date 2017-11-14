<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die;

require_once (JPATH_COMPONENT . '/include/init.php');


$controller = Joomla\CMS\MVC\Controller\BaseController::getInstance('jvarcade');
$controller->execute(Joomla\CMS\Factory::getApplication()->input->get('task'));
$controller->redirect();

?>
