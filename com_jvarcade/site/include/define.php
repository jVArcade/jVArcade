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

define('JVA_VERSION', '2.15');

// File system paths
@define('JVA_CSS_INCPATH', JPATH_ROOT . '/components/com_jvarcade/css/');
@define('JVA_HOMEVIEW_INCPATH', JPATH_ROOT . '/components/com_jvarcade/views/home/tmpl/');
@define('JVA_IMAGES_INCPATH', JPATH_ROOT . '/images/jvarcade/images/');
@define('JVA_MODELS_INCPATH', JPATH_ROOT . '/components/com_jvarcade/models/');
@define('JVA_HELPERS_INCPATH', JPATH_ROOT . '/components/com_jvarcade/helpers/');
@define('JVA_TEMPLATES_INCPATH', JPATH_ROOT . '/components/com_jvarcade/views/include/');
@define('JVA_GAMES_INCPATH', JPATH_ROOT . '/images/jvarcade/games/');

// Url paths
@define('JVA_CSS_SITEPATH', Joomla\CMS\Uri\Uri::root() . 'components/com_jvarcade/css/');
@define('JVA_IMAGES_SITEPATH', Joomla\CMS\Uri\Uri::root() . 'images/jvarcade/images/');
@define('JVA_GAMES_SITEPATH', Joomla\CMS\Uri\Uri::root() . 'images/jvarcade/games/');


$JVersion = new Joomla\CMS\Version();
$version = $JVersion->getShortVersion();
@define('JVA_JOOMLA_VERSION', $version);
