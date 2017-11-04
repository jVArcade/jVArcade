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

require_once ('define.php');
require_once (JPATH_COMPONENT . '/controller.php');
require_once (JPATH_COMPONENT . '/controllers/score.php');
require_once ('model.php');
require_once (JVA_HELPERS_INCPATH . 'helper.php');

// Load jVArcade configuration
$conf = new jvarcadeModelCommon();
$config = $conf->getConf();

// define time/date formats
define('COM_JVARCADE_DATE_FORMAT', $config->get('date_format'));
define('COM_JVARCADE_TIME_FORMAT', $config->get('time_format'));
define('COM_JVARCADE_TIMEZONE', $conf->getTimezone());

// Javascript includes and declarations
$document = Joomla\CMS\Factory::getDocument();


$jsconstants = 'var JVA_HOST_NAME = \'' . Joomla\CMS\Uri\Uri::base() . '\';' . "\n";
$jsconstants .= 'var JVA_AJAX_URL = \'' . Joomla\CMS\Uri\Uri::base() . '\';' . "\n";
$jsconstants .= 'var JVA_AJAX_RATING_URL = JVA_HOST_NAME + \'index.php?option=com_jvarcade&task=rategame&format=raw&gid=\';' . "\n";
$jsconstants .= 'var JVA_MAIN_URL = JVA_HOST_NAME + \'index.php\';' . "\n";
$document->addScriptDeclaration($jsconstants);
Joomla\CMS\HTML\HTMLHelper::_('jquery.framework');
Joomla\CMS\HTML\HTMLHelper::_('script', 'com_jvarcade/jquery.jva.js', array('version' => 'auto', 'relative' => true));

// Load the puarcade plugins
$dispatcher = JDispatcher::getInstance();
Joomla\CMS\Plugin\PluginHelper::importPlugin('jvarcade', null, true, $dispatcher);

// Load styles
$css = (strlen($config->get('template')) && $config->get('template') && file_exists(JVA_CSS_INCPATH . $config->get('template') . '.css')) ? $config->get('template') : 'default' ;
$document->addStyleSheet(JVA_CSS_SITEPATH . $css . '.css');
if((int)$config->get('roundcorners')) {
	$document->addStyleSheet(JVA_CSS_SITEPATH . '/smoothness/round.corners.css');
}

?>
