<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */

defined('_JEXEC') or die;

class jvarcadeViewProfile extends Joomla\CMS\MVC\View\HtmlView {
	
	
	public function display($tpl=null) {
		$app = Joomla\CMS\Factory::getApplication();
		$model = $this->getModel();
		$games_model = $this->getModel('Games');
		$pathway = $app->getPathway();
		$doc = Joomla\CMS\Factory::getDocument();
		
		$user_id = (int)$app->input->get('uid');
		$userToProfile = Joomla\CMS\Factory::getUser($user_id);
		$this->userToProfile = $userToProfile;

		$currentUser = Joomla\CMS\Factory::getUser();
		$this->user = $currentUser;
		
		$can_dload = $games_model->canDloadPerms($currentUser);
		$this->can_dload = $can_dload;

		//Score Related
		$userLatestScores = $model->getUserScores($user_id);
		$this->userLatestScores = $userLatestScores;
		$this->totalScores = count($userLatestScores);
		
		$scores = $model->getScores();
		$highscores = array();
		foreach ($scores as $score) {
			if (!isset($highscores[$score['gameid']])) $highscores[$score['gameid']] = array();
			// get high scores
			if (!count($highscores[$score['gameid']])) {
				if ($score['scoring']) {
					$highscores[$score['gameid']] = $model->getHighestScore($score['gameid'], $score['reverse_score']);
					$highscores[$score['gameid']]['score'] =  round($highscores[$score['gameid']]['score'], 2);
					
				}
			}
		}
		$this->highscores = $highscores;
		
		$counts = array();
		foreach ($highscores as $key=>$subarr){
			if (isset($counts[$subarr['userid']])){
				$counts[$subarr['userid']]++;
			}else $counts[$subarr['userid']] = 1;
		}
		if (isset($counts[$user_id])) {
			$this->totalHighScores = $counts[$user_id];
		}else
			$this->totalHighScores = 0;
		
		//Leaderboard
		$leaderboard = $model->getLeaderboard(0);
		$leaderboard = json_decode(json_encode($leaderboard), true);
		$place = array_search($user_id, array_column($leaderboard, 'userid'));
		$this->lbPos = (in_array($place, array(0,1,2)) ? '<img src="' . JVA_IMAGES_SITEPATH . 'icons/medal_' . ($place+1) . '.gif" border="0" alt="" />'  : $place+1);
		$this->lbPoints = $leaderboard[$place]['points'];
		
		//Online
		$useronline = false;
		$check = $model->checkOnline($user_id);
		if ($check) {
			$useronline = true;
		}
		$this->useronline = $useronline;
		
		$this->config = $this->config;
		
		$this->faves = $model->getProfileFavourites($userToProfile->id);
		foreach ($this->faves as $key => $game) {
			
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
				$this->faves[$key]['highscore'] = $highscore;
			}
		}
		
		$title = JText::_('COM_JVARCADE_PROFILE_TITLE') . ' - ' . $this->userToProfile->username;
		$pathway->addItem($title);
		$doc->setTitle(($this->config->get('title') ? $this->config->get('title') . ' - ' : '') . $title);
		
		
		parent::display($tpl);
	}
	
	
}