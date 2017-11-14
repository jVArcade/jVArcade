<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class jvarcadeViewContestdetail extends Joomla\CMS\MVC\View\HtmlView {

	function display($tpl = null) {
		
		$mainframe = Joomla\CMS\Factory::getApplication();
		$pathway = $mainframe->getPathway();
		$doc = Joomla\CMS\Factory::getDocument();
		$task = $mainframe->input->get('view');
		$this->task = $task;
		$Itemid = $mainframe->input->get('Itemid');
		$this->Itemid = $Itemid;
		$model = $this->getModel();
		$contest_id = $mainframe->input->get('id', 0);
		$slotsleft = 0;	
		
		// Get actual data
		
		$contest = $model->getContest($contest_id);
		$this->contest = $contest;
		
		if ($contest_id && $contest) {
			
			$slotsleft = $this->contest->islimitedtoslots;
			
			// Get contest games and members (if registration)
			$games = $model->getContestGames($contest_id);
			$this->games = $games;
			if ($contest->islimitedtoslots) {
				$members = $model->getContestMembers($contest_id);
				$this->members = $members;
				if (is_array($members) && count($members)) {
					$slotsleft = ($this->contest->islimitedtoslots - count($members));
				}
			}
			
			// Get Leaderboard
			if ($model->checkUpdateLeaderBoard($contest_id)) {
				$model->regenerateLeaderBoard($contest_id);
			}
			$leaderboard = $model->getleaderBoard($contest_id);
			$this->leaderboard = $leaderboard;
			
			$contests_title = JText::_('COM_JVARCADE_CONTESTS');
			$title = $contest->name;
			
			$pathway->addItem($contests_title, Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=contests', false));
			$pathway->addItem($title);
			$doc->setTitle(($this->config->get('title') ? $this->config->get('title') . ' - ' : '') . $contests_title . ' - ' . $title);
			$doc->setDescription(strip_tags($contest->description));
			$this->tabletitle = $title;
		
		}
		
		$this->slotsleft = $slotsleft;

		$user = Joomla\CMS\Factory::getUser();
		$this->user = $user;
		
		parent::display($tpl);
	}
}
