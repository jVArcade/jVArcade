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
defined('_JEXEC') or die;

class jvarcadeViewList extends Joomla\CMS\MVC\View\HtmlView {
	
	function display($tpl = null) {
		
		$mainframe = Joomla\CMS\Factory::getApplication();
		$pathway = $mainframe->getPathway();
		$doc = Joomla\CMS\Factory::getDocument();
		$user = Joomla\CMS\Factory::getUser();
		$pro_user = Joomla\CMS\Factory::getUser($mainframe->input->get('uid') ?: null);
		$task = $mainframe->input->get('view');
		$this->task = $task;
		$Itemid = $mainframe->input->get('Itemid');
		$this->Itemid = $Itemid;
		$model = $this->getModel();
		$sort_url = 'index.php?option=com_jvarcade&view=' . $task;
		$can_view = 1;
		$subfolders = 1;
		
		$can_dload = $model->canDloadPerms($user);
		$this->can_dload = $can_dload;

		

		// Table ordering
		switch ($task) {
			case 'popular':
				$filter_order = $mainframe->input->get('filter_order', 'numplayed');
				$filter_order_Dir = $mainframe->input->get('filter_order_Dir', 'DESC');
				$filter_order_Dir = $filter_order_Dir ? $filter_order_Dir : 'DESC';
				break;
			case 'newest':
				$filter_order = $mainframe->input->get('filter_order', 'game_id');
				$filter_order_Dir = $mainframe->input->get('filter_order_Dir', 'DESC');
				$filter_order_Dir = $filter_order_Dir ? $filter_order_Dir : 'DESC';
				break;
			case 'favourite':
			case 'folder':
            case 'random':
			case 'showtag':
				$filter_order = $mainframe->getUserStateFromRequest('com_jvarcade.' . $task . '.filter_order', 'filter_order', 'title', 'cmd' );
				$filter_order_Dir = $mainframe->getUserStateFromRequest('com_jvarcade.' . $task . '.filter_order_Dir', 'filter_order_Dir', '', 'word' );
				$filter_order_Dir = $filter_order_Dir ? $filter_order_Dir : 'ASC';
				break;
		}
		
		// ensure filter_order has a valid value.
		if (!in_array($filter_order, array('game_id', 'title', 'numplayed', 'rating_name'))) {
			$filter_order = 'title';
		}
		$model->setOrderBy($filter_order);
		$model->setOrderDir($filter_order_Dir);
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order'] = $filter_order;
		$this->lists = $lists;		
		
		// Get actual data
		$description = '';
		
		switch ($task) {
			case 'popular':
				$games = $model->getPopularGames();
				$title = JText::_('COM_JVARCADE_POPULAR_GAMES');
				break;
			case 'newest':
				$games = $model->getNewestGames();
				$title = JText::_('COM_JVARCADE_NEWEST_GAMES');
				break;
			case 'favourite':
			    $games = $mainframe->input->get('uid') ? $model->getFavouriteGames($pro_user->id) : $model->getFavouriteGames($user->id);
				$title = $mainframe->input->get('uid') ? JText::_ ($pro_user->username . ' Favourites') : JText::_('COM_JVARCADE_MY_FAVORITES');
				break;
			case 'folder':
				$folder_id = (int)$mainframe->input->get('id');
				$games = $model->getFolderGames($folder_id);
				$description = $games[0]['description'];
				$title = isset($games[0]) ? $games[0]['folder_name'] : '';
				$this->folder_id = $folder_id;
				$sort_url .= '&id=' . $folder_id;
				break;
            case 'random':
                $all_folders = array();
                $tmp_folders = $model->getFolders();
                foreach($tmp_folders as $tmp) {
                    if (!isset($all_folders[$tmp['parentid']])) $all_folders[$tmp['parentid']] = array();
                    if($model->folderPerms($user, $tmp['viewpermissions'])) {
                        $all_folders[$tmp['parentid']][$tmp['id']] = $tmp;
                    }
                } 
                $folders = $all_folders[0];
                $folder_ids = array_keys($folders);
                $games = $model->getPagedRandomGames($folder_ids);
                $title = JText::_('COM_JVARCADE_RANDOM_GAMES');
                break; 
			case 'showtag':
				$tag = $mainframe->input->get('tag');
				$games = $model->getGamesByTag($tag);
				$this->tag = $tag;
				$title = $tag;
				$description = $tag;
				$sort_url .= '&tag=' . $tag;
				break;
		}
		
		// Pagination
		
		$pageNav = $model->getPagination();
		$this->pageNav = $pageNav;
		
		if ($task == 'folder') {
			if (isset($games[0])) $can_view = $model->folderPerms($user, $games[0]['viewpermissions']);
			$subfolders = $model->getFolders($folder_id);
			$parents = $model->getParents($folder_id);
			$doctitle = array();
			foreach($parents as $parent) {
				$pathway->addItem($parent['name'], Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=folder&id=' . $parent['id']));
				$doctitle[] = $parent['name'];
			}
			$doc->setTitle(($this->config->get('title') ? $this->config->get('title') . ' - ' : '') . implode(' > ', $doctitle));
		} else {
			$pathway->addItem($title);
			$doc->setTitle(($this->config->get('title') ? $this->config->get('title') . ' - ' : '') . $title);
		}
		if ($description) $doc->setDescription($description);
		
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
		$this->user = $user;
		$this->can_view = $can_view;
		$this->subfolders = $subfolders;
		$this->config = $this->config;
		
		parent::display($tpl);
	}
}
