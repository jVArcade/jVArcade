<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');

class jvarcadeModelProfile extends jvarcadeModelCommon {
	
	public function getUserScores($user_id) {
		$query = 'SELECT b.score, b.date, c.title, c.imagename, c.description, c.id FROM #__jvarcade AS b, #__jvarcade_games AS c WHERE b.userid ='
				. $user_id .' AND b.gameid = c.id ORDER BY b.date DESC LIMIT ' . $this->config->get('profile_scores');
		$this->dbo->setQuery($query);
		$user_scores = $this->dbo->loadAssocList();
		return $user_scores;
	}
	
	public function getProfileFavourites($user_id) {
	    $query = 'SELECT SQL_CALC_FOUND_ROWS g.*, g.id as game_id, g.description as game_desc, c.imagename as rating_image, c.name as rating_name, c.description as rating_desc ' .
	   	    ' FROM #__jvarcade_games g ' .
	   	    ' LEFT JOIN #__jvarcade_contentrating c' .
	   	    '	ON g.contentratingid = c.id' .
	   	    ' JOIN #__jvarcade_faves f' .
	   	    '	ON g.id = f.gid AND f.userid = ' . $this->dbo->Quote($user_id) .
	   	    ' WHERE g.' . $this->dbo->quoteName('published') . ' = ' . $this->dbo->Quote(1) .
	   	    ' ORDER BY game_id DESC LIMIT ' . $this->config->get('profile_faves');
	    $this->dbo->setQuery($query);
	    $faves = $this->dbo->loadAssocList();
	    return $faves;
	}
	
	public function getScores() {
		$query = 'SELECT SQL_CALC_FOUND_ROWS p.*, g.id as gameid, g.gamename, g.title, g.imagename, g.scoring, g.reverse_score, u.id as userid, u.username, u.name
				FROM #__jvarcade p
					LEFT JOIN #__jvarcade_games g ON p.gameid = g.id
					LEFT JOIN #__users u ON u.id = p.userid
				WHERE p.published = ' . $this->dbo->Quote(1);
		$this->dbo->setQuery($query);
		return  $this->dbo->loadAssocList();
	}
	
	public function getHighestScore($game_id, $reverse, $userid = null) {
		$order = $reverse ? 'ASC' : 'DESC' ;
		$this->dbo->setQuery('SELECT p.id, p.score, p.userid, u.name, u.username' .
				' FROM #__jvarcade p' .
				' LEFT JOIN #__users u ON p.userid = u.id' .
				' WHERE ' . $this->dbo->quoteName('gameid') . ' = ' . $this->dbo->Quote($game_id) .
				(!is_null($userid) ? ' AND ' . $this->dbo->quoteName('userid') . ' = ' . $this->dbo->Quote((int)$userid) : '') .
				' AND ' . $this->dbo->quoteName('published') . ' = ' . $this->dbo->Quote(1) .
				' ORDER BY p.score ' . $order .
				' LIMIT 1');
		return $this->dbo->loadAssoc();
	}
	
	public function checkOnline($user_id) {
		$query = 'SELECT userid FROM #__session WHERE client_id = 0 AND userid = ' . $user_id;
		$this->dbo->setQuery($query);
		return $this->dbo->loadRow();
	}
	
	public function getLeaderboard($contest_id = 0) {
			$sql = 'SELECT l.*, u.name, u.username FROM #__jvarcade_leaderboard l LEFT JOIN #__users u ON l.userid = u.id
				WHERE l.contestid = ' . (int)$contest_id . '
					AND ((l.userid IS NOT NULL AND u.id IS NOT NULL)
						OR (l.userid = 0 AND u.id IS NULL))
				ORDER BY l.points DESC';
			$this->dbo->setQuery($sql);
			return $this->dbo->loadObjectList();
	}
	

}

?>