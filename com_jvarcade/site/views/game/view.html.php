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

jimport('joomla.html.pagination');

class jvarcadeViewGame extends Joomla\CMS\MVC\View\HtmlView {
	
	var $comment_data;
	
	function display($tpl = null) {
		
		$app = Joomla\CMS\Factory::getApplication();
		$pathway = $app->getPathway();
		$doc = Joomla\CMS\Factory::getDocument();
		$user = Joomla\CMS\Factory::getUser();
		$this->user = $user;
		
		$model = $this->getModel();

		// vars
		$scheme = (strpos(Joomla\CMS\Uri\Uri::root(), 'https://') !== false) ? 'https://' : 'http://';
    	$this->scheme = $scheme;
		$sitename = $app->get('sitename');
		$this->sitename = $sitename;
		$folder_id = $app->input->getInt('fid', 0);
		$this->folder_id = $folder_id;

		// game
		$game_id = (int)$app->input->get('id');
		$game = $model->getGame($game_id);
		$game['current_vote'] = ($game['total_value'] > 0 && $game['total_votes'] > 0) ? round($game['total_value']/$game['total_votes'], 1) : 0;
		$this->game = $game;
		$model->increaseNumplayed($game_id);
		
		// Play permissions based on folder permissions 
		$can_play = $model->folderPerms($user, $game['viewpermissions']);
		$this->can_play = $can_play;
		
		// Download permissions
		
		$can_dload = $model->canDloadPerms($user);
		$this->can_dload = $can_dload;

		// bookmarks
		$uri = Joomla\CMS\Uri\Uri::getInstance();
		$prefix = $uri->toString(array('host', 'port'));
		$bookmark_url = Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=game&id=' . $game_id, false);
		if (!preg_match('#^/#', $bookmark_url)) {
			$bookmark_url = '/' . $bookmark_url;
		}
		$bookmark_url = $scheme . $prefix . $bookmark_url;
		$this->bookmark_url = $bookmark_url;
		
		// contests
		$contests = $this->scores_model->getContestsByGame($game['id'], 1);
		$this->contests = $contests;
		
		// stats
		$scorecount = $this->scores_model->gameScoreCount($game_id);
		$this->scorecount = $scorecount;
		$favoured = $model->getGameFavCount($game_id);
		$this->favoured = $favoured;
		$favoured_by_me = $model->getGameFavCount($game_id, $user->id);
		$this->favoured_by_me = $favoured_by_me;
		$my_fav_count = $model->getMyFavCount($user->id);
		$this->my_fav_count = $my_fav_count;
		$parents = $model->getParents((int)$game['folderid']);
		$folderpath = $this->buildFolders($parents);
		$this->folderpath = $folderpath;
		
		// page title and breadcrumbs
		$doc->setTitle(($this->config->get('title') ? $this->config->get('title') . ' - ' : '') . $game['title']);
		$doc->setDescription(strip_tags($game['description']));
		$this->buildPathway($pathway, $parents, $game['title']);
		
		// Comments
		$db	= Joomla\CMS\Factory::getDbo();
		$sql = "SELECT element as `option`, enabled FROM #__extensions WHERE `type` = 'component' AND element IN ('com_comment', 'com_jcomments', 'com_jacomment')";
		$db->setQuery($sql);
		$this->comment_data = $db->loadAssocList('option');
		
		// events
		$dispatcher = JEventDispatcher::getInstance();
		$result = $dispatcher->trigger('onPUABeforeFlashGame', array($game['id'], $game['title'], (int)$user->id, ((int)$user->id ? $user->username : $this->config->get('guest_name')) ));
		
		parent::display($tpl);
		$result = $dispatcher->trigger('onPUAAfterFlashGame', array($game['id'], $game['title'], (int)$user->id, ((int)$user->id ? $user->username : $this->config->get('guest_name')) ));
		
		$session = Joomla\CMS\Factory::getSession();
		$session->set('session_starttime', time(), 'jvarcade');
		//~ session_write_close();
		
	}
	
	function buildFolders($folders) {
		$folderpath = '<a href=' . Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=home') . '>' . stripslashes($this->config->get('title')) . '</a>';
		foreach ($folders as $folder) {
		$folderpath .= ' » <a href=' . Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=folder&id=' . $folder['id']) . '>' . $folder['name'] . '</a>';
		}
		return $folderpath;
		
	}
	
	function buildPathway(&$pathway, $folders, $title) {
		foreach ($folders as $folder) {
			$pathway->addItem($folder['name'], Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=folder&id=' . $folder['id']));
		}
		$pathway->addItem($title);
	}
	
	function displayContest(&$contest) {
		$return = '';
		
		// if there is no registration or there is and we are registered
		if (!$contest->islimitedtoslots || $contest->userid) {
			// deal with the maximum allowed plays per game in the contest (if any)
			if (!$contest->maxplaycount) {
				$return =  JText::sprintf('COM_JVARCADE_ELIGIBLE_YES', $contest->name);
			} elseif ($contest->maxplaycount && $contest->maxplaycount <= $contest->attemptnum) {
				$return =  JText::sprintf('COM_JVARCADE_ELIGIBLE_NO', $contest->name);
			} elseif ($contest->maxplaycount && $contest->maxplaycount > $contest->attemptnum) {
				$return =  JText::sprintf('COM_JVARCADE_ELIGIBLE_YES_COND', $contest->name, ($contest->maxplaycount - $contest->attemptnum), $contest->maxplaycount);
			}
		} else {
			// there is registration for the contest and we are not registered
			$return =  JText::sprintf('COM_JVARCADE_ELIGIBLE_NOTREGISTERED', $contest->name);
		}
		
		return $return;

	}
	
	function displayComments() {
		$start = '<div class="pu_heading" style="text-align: center;margin: 20px 0 20px 0;">' . JText::_('COM_JVARCADE_COMMENTS') . '</div><div id="comment-block">';
		$end = '</div>';
		if ($this->config->get('comments') == 1 && $this->componentEnabled($this->comment_data, 'com_comment')) {
			// CComment
			
			$path = JPATH_SITE . '/administrator/components/com_comment/plugins/com_jvarcade/jvarcade.php';
			if (file_exists($path)) {
				JLoader::discover('ccommentHelper', JPATH_SITE . '/components/com_comment/helpers');
				echo $start;
				echo CcommentHelperUtils::commentInit('com_jvarcade', $this->game);
				echo $end;
			}
		} elseif ($this->config->get('comments') == 2 && $this->componentEnabled($this->comment_data, 'com_jcomments')) {
			// JComments
			$jcommentspath = JPATH_SITE . '/components/com_jcomments/jcomments.php';
			$jcommentsplugin = JPATH_SITE . '/components/com_jcomments/plugins/com_jvarcade.plugin.php';
			if (file_exists($jcommentspath) && file_exists($jcommentsplugin)) {
				require_once($jcommentspath);
				echo $start;
				echo JComments::show($this->game['id'], 'com_jvarcade', $this->game['gamename']); 
				echo $end;
			}
		} elseif ($this->config->get('comments') == 3 && $this->componentEnabled($this->comment_data, 'com_jacomment')) {
			// JA Comment
			echo $start;
			echo '{jacomment contentid='.$this->game['id'].' option=com_jvarcade contenttitle='.$this->game['gamename'].'}';
			echo $end;
		}
		echo '';
	}
	
	function componentEnabled(&$comment_data, $name) {
		return (is_array($comment_data) && count($comment_data) && isset($comment_data[$name]) && isset($comment_data[$name]['enabled']) && (int)$comment_data[$name]['enabled']);
	}
}
