<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die;

JLoader::register("jvarcadeToolbarHelper", JPATH_COMPONENT_ADMINISTRATOR ."/sidebar.php");
JLoader::register("JvaFileHandler", JPATH_COMPONENT_ADMINISTRATOR ."/helpers/filehandler.php");

require_once (dirname(__FILE__) . '/model.php');
//require_once (dirname(__FILE__) . '/models/migration.php');
require_once (JPATH_ROOT . '/components/com_jvarcade/include/define.php');
require_once (JVA_HELPERS_INCPATH . 'helper.php');

// Load the puarcade plugins
$dispatcher = JDispatcher::getInstance();
Joomla\CMS\Plugin\PluginHelper::importPlugin('jvarcade', null, true, $dispatcher);

$model =  new jvarcadeModelAdminCommon();
$config = $model->getConf();
$tz_obj = $model->getAdminTimezone();

define('COM_JVARCADE_DATE_FORMAT', $config->get('date_format'));
define('COM_JVARCADE_TIME_FORMAT', $config->get('time_format'));
define('COM_JVARCADE_TIMEZONE', $tz_obj->timezone);

$document = Joomla\CMS\Factory::getDocument();
$document->addStyleSheet(Joomla\CMS\Uri\Uri::root() . 'administrator/components/com_jvarcade/css/'. 'style.css');

// Javascript includes and declarations
Joomla\CMS\HTML\HTMLHelper::_('jquery.framework');
Joomla\CMS\HTML\HTMLHelper::_('script', 'com_jvarcade/jquery.jva.js', false, true);

$jsconstants  = 'var JVA_HOST_NAME = \'' . Joomla\CMS\Uri\Uri::base() . '\';' . "\n";
$jsconstants .= 'var JVA_AJAX_URL = \'' . Joomla\CMS\Uri\Uri::base() . '\';' . "\n";
$jsconstants .= 'var JVA_CONTESTLINK_ADDGAME_URL = \'' . Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=addgametocontest&tmpl=component&',false) . '\';' . "\n";
$jsconstants .= 'var JVA_CONTESTLINK_ADDCONTESTGAMES_URL = \'' . Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=addcontestgames&tmpl=component&',false) . '\';' . "\n";
$jsconstants .= 'var JVA_MAIN_URL = JVA_HOST_NAME + \'index.php\';' . "\n";
$jsconstants .= 'var JVA_MAX_MIGRATION_STEPS = 12;' . "\n";
$jsconstants .= 'var COM_JVARCADE_CONTESTSLINK_DELETE_WARNING = \'' . JText::_('COM_JVARCADE_CONTESTSLINK_DELETE_WARNING') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_CONTESTSLINK_GAME_EMPTY = \'' . JText::_('COM_JVARCADE_CONTESTSLINK_GAME_EMPTY') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_CONTESTSLINK_SAVE_EMPTY = \'' . JText::_('COM_JVARCADE_CONTESTSLINK_SAVE_EMPTY') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_VALIDATION_ERROR = \'' . JText::_('COM_JVARCADE_VALIDATION_ERROR') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_CONTESTS_NAME_EMPTY = \'' . JText::_('COM_JVARCADE_CONTESTS_NAME_EMPTY') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_CONTESTS_START_EMPTY = \'' . JText::_('COM_JVARCADE_CONTESTS_START_EMPTY') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_CONTESTS_END_LOWER_START = \'' . JText::_('COM_JVARCADE_CONTESTS_END_LOWER_START') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_DESC_DELETEALLSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_DESC_DELETEALLSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_DESC_DELETEGUESTSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_DESC_DELETEGUESTSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_DESC_DELETEZEROSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_DESC_DELETEZEROSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_DESC_DELETEBLANKSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_DESC_DELETEBLANKSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_DESC_CLEARALLRATINGS = \'' . JText::_('COM_JVARCADE_MAINTENANCE_DESC_CLEARALLRATINGS') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_DESC_DELETEALLTAGS = \'' . JText::_('COM_JVARCADE_MAINTENANCE_DESC_DELETEALLTAGS') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_DESC_RECALCULATELEADERBOARD = \'' . JText::_('COM_JVARCADE_MAINTENANCE_DESC_RECALCULATELEADERBOARD') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_DESC_SUPPORTDIAGNOSTICS = \'' . JText::_('COM_JVARCADE_MAINTENANCE_DESC_SUPPORTDIAGNOSTICS') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_GAME_DESC_DELETEALLSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_GAME_DESC_DELETEALLSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_GAME_DESC_DELETEGUESTSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_GAME_DESC_DELETEGUESTSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_GAME_DESC_DELETEZEROSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_GAME_DESC_DELETEZEROSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_GAME_DESC_CLEARALLRATINGS = \'' . JText::_('COM_JVARCADE_MAINTENANCE_GAME_DESC_CLEARALLRATINGS') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_GAME_DESC_DELETEALLTAGS = \'' . JText::_('COM_JVARCADE_MAINTENANCE_GAME_DESC_DELETEALLTAGS') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_CONTEST_DESC_DELETEALLSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_CONTEST_DESC_DELETEALLSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_CONTEST_DESC_DELETEGUESTSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_CONTEST_DESC_DELETEGUESTSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_CONTEST_DESC_DELETEZEROSCORES = \'' . JText::_('COM_JVARCADE_MAINTENANCE_CONTEST_DESC_DELETEZEROSCORES') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_CONTEST_DESC_RECALCULATELEADERBOARD = \'' . JText::_('COM_JVARCADE_MAINTENANCE_CONTEST_DESC_RECALCULATELEADERBOARD') . '\';' . "\n";
$jsconstants .= 'var COM_JVARCADE_MAINTENANCE_MIGRATION_FAILURE = \'' . JText::_('COM_JVARCADE_MAINTENANCE_MIGRATION_FAILURE') . '\';' . "\n";
$document->addScriptDeclaration($jsconstants);


$controller = Joomla\CMS\MVC\Controller\BaseController::getInstance('jvarcade');
$controller->execute(Joomla\CMS\Factory::getApplication()->input->get('task'));
$controller->redirect();

