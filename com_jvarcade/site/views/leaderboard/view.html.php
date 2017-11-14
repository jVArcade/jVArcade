<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die;

class jvarcadeViewLeaderboard extends Joomla\CMS\MVC\View\HtmlView {

	function display($tpl = null) {
		$mainframe = Joomla\CMS\Factory::getApplication();
		
		$pathway = $mainframe->getPathway();
		$doc = Joomla\CMS\Factory::getDocument();
		$task = $mainframe->input->get('view');
		$this->task = $task;
		$Itemid = $mainframe->input->get('Itemid');
		$this->Itemid = $Itemid;
		$model = $this->getModel();
		
		// Get Leaderboard
		if ($model->checkUpdateLeaderBoard(0)) {
			$model->regenerateLeaderBoard(0);
		}
		$leaderboard = $model->getleaderBoard(0);
		$this->leaderboard = $leaderboard;
		
		$title = JText::_('COM_JVARCADE_LEADERBOARD');
		$pathway->addItem($title);
		$doc->setTitle(($this->config->get('title') ? $this->config->get('title') . ' - ' : '') . $title);
		$this->tabletitle = $title;

		$user = Joomla\CMS\Factory::getUser();
		$this->user = $user;
		
		parent::display($tpl);
	}
}
