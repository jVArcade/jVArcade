<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class jvarcadeViewLatestscores extends Joomla\CMS\MVC\View\HtmlView {
	
	function display($tpl = null) {
		
		$mainframe = Joomla\CMS\Factory::getApplication();
		$pathway = $mainframe->getPathway();
		$doc = Joomla\CMS\Factory::getDocument();
		$user = Joomla\CMS\Factory::getUser();
		$task = $mainframe->input->get('view');
		$this->task = $task;
		$Itemid = $mainframe->input->get('Itemid');
		$this->Itemid = $Itemid;
		$model = $this->getModel();
		$sort_url = 'index.php?option=com_jvarcade&view=' . $task;
		$subfolders = 1;
		
		// Table ordering
		$filter_order = $mainframe->input->get('filter_order', 'p.date');
		$filter_order_Dir = $mainframe->input->get('filter_order_Dir', 'DESC');
		$filter_order_Dir = $filter_order_Dir ? $filter_order_Dir : 'DESC';
		
		// ensure filter_order has a valid value.
		if (!in_array($filter_order, array('p.score', 'p.date', 'g.title', 'u.username', 'u.name'))) {
			$filter_order = 'p.date';
		}
		$model->setOrderBy($filter_order);
		$model->setOrderDir($filter_order_Dir);
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order'] = $filter_order;
		$this->lists = $lists;		
		
		// Get actual data
		$scores = $model->getLatestScores();
		$title = JText::_('COM_JVARCADE_LATEST_SCORES');
		
		// Pagination
		$pageNav = $model->getPagination();
		$this->pageNav = $pageNav;
		
		// Highest Scores
		$highscores = array();
		foreach ($scores as $score) {
			if (!isset($highscores[$score['gameid']])) $highscores[$score['gameid']] = array();
			// get high scores
			if (!count($highscores[$score['gameid']])) {
				if ($score['scoring']) {
					$highscores[$score['gameid']] = $this->games_model->getHighestScore($score['gameid'], $score['reverse_score']);
					$highscores[$score['gameid']]['score'] =  round($highscores[$score['gameid']]['score'], 2);
					if (!isset($highscores[$score['gameid']]['userid']) || !(int)$highscores[$score['gameid']]['userid']) {
						$highscores[$score['gameid']]['username'] = $this->config->get('guest_name');
					} elseif(!(int)$this->config->get('show_usernames')) {
						$highscores[$score['gameid']]['username'] = $highscores[$score['gameid']]['name'];
					}
				}
			}
		}
		$this->highscores = $highscores;
		
		$pathway->addItem($title);
		$doc->setTitle(($this->config->get('title') ? $this->config->get('title') . ' - ' : '') . $title);
		
		$this->scores = $scores;
		$this->tabletitle = $title;
		$this->sort_url = $sort_url;
		$this->user = $user;
		$this->subfolders = $subfolders;
		$this->config = $this->config;
		
		parent::display($tpl);
	}
}
