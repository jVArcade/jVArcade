<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');

//jimport('joomla.application.component.view');

class jvarcadeViewContestlink extends Joomla\CMS\MVC\View\HtmlView {

	function display($tpl = null) {

		$model = $this->getModel();
		$app = Joomla\CMS\Factory::getApplication();
		$task = $app->input->get('view', 'addgametocontest');
		$this->task = $task;
		
		if ($task == 'addgametocontest') {
			
			$game_id = array_unique($app->input->get('cid', array(), 'array'));
			Joomla\Utilities\ArrayHelper::toInteger($game_id);
			$game_titles = $model->getGameTitles($game_id);
			$game_titles = implode(',', $game_titles);
			$this->game_titles = $game_titles;
			$this->game_ids = implode(',', $game_id);
			
			
			$contestobj = $model->getContests();
			foreach($contestobj as $obj ) {
				$contests[] = Joomla\CMS\HTML\HTMLHelper::_('select.option', $obj->id, $obj->name);
			}
			$contestlist = Joomla\CMS\HTML\HTMLHelper::_('select.genericlist', $contests, 'contestlist', 'size="9" multiple', 'value', 'text');
			$this->contestlist = $contestlist;

		} else if ($task == 'addcontestgames') {
			
			$contest_id = array_unique($app->input->get('cid', array(), 'array'));
			Joomla\Utilities\ArrayHelper::toInteger($contest_id);
			$this->contest_id = implode(',', $contest_id);
			
			$gamesobj = $model->getGameIdTitles();
			foreach($gamesobj as $obj ) {
				$games[] = Joomla\CMS\HTML\HTMLHelper::_('select.option', $obj->id, $obj->title);
			}
			$gameslist = Joomla\CMS\HTML\HTMLHelper::_('select.genericlist', $games, 'gameslist', 'size="9" multiple', 'value', 'text');
			$this->gameslist = $gameslist;
		}
		
		parent::display($tpl);
	}
}
