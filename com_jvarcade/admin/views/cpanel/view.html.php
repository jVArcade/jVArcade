<?php
/**
 * @package		jVArcade
 * @version		2.13
 * @date		2016-02-18
 * @copyright		Copyright (C) 2007 - 2014 jVitals Digital Technologies Inc. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvitals.com
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

class jvarcadeViewCpanel extends Joomla\CMS\MVC\View\HtmlView {

	function display($tpl = null) {
		
		$mainframe = Joomla\CMS\Factory::getApplication('site');
		$model = $this->getModel();
		
		$task = $mainframe->input->get('task', 'cpanel');
		$this->task = $task;
		
		// config
		$config = $model->getConf();
		$this->config = $config;
		
		// stats
		$games_count = $model->getGamesCount();
		$this->games_count = $games_count;
		$scores_count = $model->getScoresCount();
		$this->scores_count = $scores_count;
		$latest_scores = $model->getLatestScores();
		$this->latest_scores = $latest_scores;
		$latest_games = $model->getLatestGames();
		$this->latest_games = $latest_games;
		
		
		
		// plugin checks
		$sysplg_installed = Joomla\CMS\Plugin\PluginHelper::isEnabled('system', 'jvarcade');
		$this->sysplg_installed = $sysplg_installed;
		if (!$sysplg_installed) {
			$mainframe->enqueueMessage(JText::_('COM_JVARCADE_PLUGINS_WARNING'), 'error');
		}
		$plugins = Joomla\CMS\Plugin\PluginHelper::getPlugin('jvarcade');
		$this->plugins = $plugins;
		
		// changelog
		$changelog = $model->getChangeLog();
		$this->changelog = $changelog;
		
		JToolBarHelper::title(JText::_('COM_JVARCADE_CPANEL'), 'jvacpanel');
		JToolbarHelper::preferences('com_jvarcade', '' , '' ,  'Settings');
		
		$dashboard_buttons = array (
			'MANAGE_SCORES' => array(
				'link' => Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=scores'),
				'icon' => 'doc_48.png',
				'label' => JText::_('COM_JVARCADE_MANAGE_SCORES')
			),
			'MANAGE_FOLDERS' => array(
				'link' => Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=folders'),
				'icon' => 'folder.png',
				'label' => JText::_('COM_JVARCADE_MANAGE_FOLDERS')
			),
			'MANAGE_GAMES' => array(
				'link' => Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=games'),
				'icon' => 'games2.png',
				'label' => JText::_('COM_JVARCADE_MANAGE_GAMES')
			),
			'UPLOAD_ARCHIVE' => array(
				'link' => Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=game_upload'),
				'icon' => 'upload_zip.png',
				'label' => JText::_('COM_JVARCADE_UPLOAD_ARCHIVE')
			),
			'MAINTENANCE' => array(
				'link' => Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=maintenance'),
				'icon' => 'maintenance.png',
				'label' => JText::_('COM_JVARCADE_MAINTENANCE')
			),
			'CONTENT_RATINGS' => array(
				'link' => Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=contentratings'),
				'icon' => 'content_rating.png',
				'label' => JText::_('COM_JVARCADE_CONTENT_RATINGS')
			),
			'CONTESTS' => array(
				'link' => Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=contests'),
				'icon' => 'contests.png',
				'label' => JText::_('COM_JVARCADE_CONTESTS')
			),
			'SUPPORT' => array(
				'link' => 'http://jvarcade.com/forum/jvarcade-support',
				'icon' => 'user_48.png',
				'label' => JText::_('COM_JVARCADE_SUPPORT'),
				'target' => '_blank'
			),
		);
		$this->dashboard_buttons = $dashboard_buttons;
		
		parent::display($tpl);
	}
	

}
