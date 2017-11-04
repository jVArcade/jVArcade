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

class jvarcadeViewHome extends Joomla\CMS\MVC\View\HtmlView {

	function display($tpl = null) {
		$mainframe = Joomla\CMS\Factory::getApplication();
		$doc = Joomla\CMS\Factory::getDocument();
		$user = Joomla\CMS\Factory::getUser();
		$this->user = $user;
		$task = $mainframe->input->get('view');
		$this->task = $task;
		$Itemid = $mainframe->input->get('Itemid');
		$this->Itemid = $Itemid;
		$sort_url = 'index.php?option=com_jvarcade&view=' . $task;

		$model = $this->getModel();
		$can_dload = $model->canDloadPerms($user);
		$this->can_dload = $can_dload;

		
		
		if ($this->config->get('title')) $doc->setTitle($this->config->get('title'));
		
		if ($this->layout == 'flat') {
			// FLAT MODE
			
			// Table ordering
			$filter_order = $mainframe->getUserStateFromRequest('com_jvarcade.' . $task . '.filter_order', 'filter_order', 'game_id', 'cmd' );
			$filter_order_Dir = $mainframe->getUserStateFromRequest('com_jvarcade.' . $task . '.filter_order_Dir', 'filter_order_Dir', '', 'word' );
			$filter_order_Dir = $filter_order_Dir ? $filter_order_Dir : 'DESC';
			// ensure filter_order has a valid value.
			if (!in_array($filter_order, array('game_id', 'title', 'numplayed', 'rating_name'))) {
				$filter_order = 'game_id';
			}
			$model->setOrderBy($filter_order);
			$model->setOrderDir($filter_order_Dir);
			$lists['order_Dir']	= $filter_order_Dir;
			$lists['order'] = $filter_order;
			$this->lists = $lists;		
			
			// Get actual data
			$games = $model->getAllGames();
			$title = JText::_('COM_JVARCADE_GAMES');
			
			// Pagination
			$pageNav = $model->getPagination();
			$this->pageNav = $pageNav;
			
			// Scores
			foreach ($games as $key => $game) {
				
				// get high scores
				if ($game['scoring']) {
					$games[$key]['highscore'] = array();
					if ($game['scoring']) {
						$highscore = $model->getHighestScore($game['id'], $game['reverse_score']);
						$highscore['score'] =  round($highscore['score'], 2);
						if (!isset($highscore['userid']) || !(int)$highscore['userid']) {
							$highscore['username'] = $this->config->get('guest_name');
						} elseif(!(int)$this->config->get('show_usernames')) {
							$highscore['username'] = $highscore['name'];
						}
					}
					// add the games data to the game array
					$games[$key]['highscore'] = $highscore;
				}
			}
		
			$this->games = $games;
			$this->tabletitle = $title;
			$this->sort_url = $sort_url;

		} else {
			// FOLDER MODE
			
			$all_folders = array();
			$tmp_folders = $model->getFoldersHome();
			foreach($tmp_folders as $tmp) {
				if (!isset($all_folders[$tmp['parentid']])) $all_folders[$tmp['parentid']] = array();
				if($model->folderPerms($user, $tmp['viewpermissions'])) {
					$all_folders[$tmp['parentid']][$tmp['id']] = $tmp;
				}
			}
			
			$folders = $all_folders[0];
			$folder_ids = array_keys($folders);
			
			// shall we display random games for each folder?
			if ($this->config->get('foldergames') == 1) {
			
				// get the random games
				$games = $model->getRandomGames($folder_ids);
				
				if (is_array($games) && is_array($games)) {
					foreach ($games as $game) {
						if (!array_key_exists('games', $folders[$game['folderid']])) {
							$folders[$game['folderid']]['games'] = array();
						}
						
						// get high scores
						if (($this->config->get('showscoresinfolders') == 1) && $game['scoring']) {
							$game['highscore'] = array();
							if ($game['scoring']) {
								$highscore = $model->getHighestScore($game['id'], $game['reverse_score']);
								$highscore['score'] =  round($highscore['score'], 2);
								if (!isset($highscore['userid']) || !(int)$highscore['userid']) {
									$highscore['username'] = $this->config->get('guest_name');
								} elseif(!(int)$this->config->get('show_usernames')) {
									$highscore['username'] = $highscore['name'];
								}
								$game['highscore'] = $highscore;
							}
						}
						
						// add the games data to the folder array
						$folders[$game['folderid']]['games'][] = $game;
					}
				}
			}
			
			$games_count = $model->getGamesCountByFolder();
				
			$this->folders = $folders;
			$this->all_folders = $all_folders;
			$this->games_count = $games_count;

		}
		
		parent::display($tpl);
	}
}
