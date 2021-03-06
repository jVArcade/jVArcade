<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */

defined('_JEXEC') or die( 'Restricted access' );


class plgSystemJvarcade extends Joomla\CMS\Plugin\CMSPlugin {
	var $url = '';
	var $u = '';
	
	function __construct(&$subject, $config) {
		parent::__construct($subject, $config);
	}

	function onAfterInitialise() {
		$app = Joomla\CMS\Factory::getApplication();
		$redirect = false;
		
		// First check if the needed files are there. If not we create them and put content in them.
		// They might be missing if user have deleted them or if previous installation of PUArcade has been uninstalled.
		$scripts = array(
			'newscore.php' => '<?php require_once \'./index.php\';',
			'arcade.php' => '<?php require_once \'./index.php\';',
		);
		foreach ($scripts as $filename => $content) {
			if (!file_exists(JPATH_ROOT . '/' . $filename)) {
				file_put_contents(JPATH_ROOT . '/' . $filename, $content);
			}
		}
		
		
		/* SCORE SUBMITS */
		
		
		// Catch the score submits to /newscore.php
		if (strpos($_SERVER['REQUEST_URI'], 'newscore.php') !== false) {
			$redirect = true;
			$task = 'newscore';
		}
		
		// Catch the score submits to /arcade.php
		if (strpos($_SERVER['REQUEST_URI'], 'arcade.php') !== false) {
			$redirect = true;
			$task = 'arcade';
		}
		
		// Catch any non-standart score submits to /index.php
		if(!in_array($app->input->getWord('task', '' ), array('storepnscore', 'storescore', 'newscore', 'arcade', 'index'))
			&& ((strtolower($app->input->getWord('act', '' )) == 'arcade')
				//|| (strtolower($app->input->getWord('autocom', '')) == 'arcade')
				//|| (strtolower($app->input->getWord('module', '')) == 'pnflashgames')
				//|| (strtolower($app->input->getWord('arcade', '')) == 'storescore')
				//|| (strtolower($app->input->getWord('func', '')) == 'storescore')
			)
		) {
			$redirect = true;
			$task = 'v3';
		}
		
		if(!in_array($app->input->getWord('task', '' ), array('storepnscore', 'storescore', 'newscore', 'arcade', 'index'))
		&& ((strtolower($app->input->getWord('autocom', '' )) == 'arcade'))) {
			$redirect = true;
			$task = 'v32';
		}
		
		if(!in_array($app->input->getWord('task', '' ), array('storepnscore', 'storescore', 'newscore', 'arcade', 'index'))
		&& ((strtolower($app->input->getWord('module', '')) == 'pnflashgames'))) {
			$redirect = true;
			$task = 'pnflash';
		}
		// If we are good to go
		if ($redirect) {
		
			$params = array();
			
			// the absence of this parameter was causing issues in one case
			/*if ( !(isset($_POST['pn_modvalue']) || isset($_GET['pn_modvalue'])) && (strpos($_SERVER['HTTP_REFERER'], 'pn_modvalue') !== false) ) {
				$params[] = 'pn_modvalue=com_jvarcade';
			}*/
			
			// get all the POST and GET parameters and append them to the redirect url
			// skip huge parameters containing ### as they break the other parameters needed for the task detection
			foreach($_POST as $k => $v) {
				if (strpos($v, '####') === false) {
					$k = str_replace(array("\n", "\t", "\r"), ' ', strip_tags(trim($k)));
					$v = str_replace(array("\n", "\t", "\r"), ' ', strip_tags(trim($v)));
					$params[] = "$k=$v";
				}
				unset($_POST[$k]);
			}
			foreach($_GET as $k => $v) {
				if (strpos($v, '####') === false) {
					$k = str_replace(array("\n", "\t", "\r"), ' ', strip_tags(trim($k)));
					$v = str_replace(array("\n", "\t", "\r"), ' ', strip_tags(trim($v)));
					$params[] = "$k=$v";
				}
				unset($_GET[$k]);
			}
		
			$url = Joomla\CMS\Uri\Uri::root(true) . '/index.php?option=com_jvarcade&task=score.' . $task . '&' . implode('&', $params);
			
		if ($task == 'v3') {
			$parts = parse_url($url);
    		parse_str($parts['query'], $query);
			$app->redirect(Joomla\CMS\Uri\Uri::root(true) . '/index.php?option=com_jvarcade&task=score.' . $task . '&gname=' . $query['gname'] .'&gscore=' . $query['gscore']);
			jexit();
			
		}
		
		if ($task == 'v32') {
			$u = Joomla\CMS\Uri\Uri::getInstance($url);
			$u->delVar('autocom');
			$app->redirect($u->toString());
			jexit();
		}
			
		
		if ($task == 'arcade' || 'newscore' || 'pnflash') {
			$u = Joomla\CMS\Uri\Uri::getInstance($url);
			$u->delVar('module');
			$app->redirect($u->toString());
			jexit();
		}
			
				
		}

	}

	/**
	 * onPUAHealthCheck - function for system healthcheck purposes
	 * This function is to be used by the arcade - it will determine whether the plugin has been enabled.
	 */
	function onPUAHealthCheck() {
		echo 'Plugin Healthcheck - ' . get_class() . '<br/>';
	}

	/**
	 * onPUABeforeFlashGame    	-  	called just before the flash game is written to the screen
	 *
	 * function onPUABeforeFlashGame( $gameid, $gametitle, $userid, $username ) {
	 * }
	 */

	/**
	 * onPUAAfterFlashGame		-	called just after the flash game is written to the screen
	 *
	 * function onPUAAfterFlashGame( $gameid, $gametitle, $userid, $username ) {
	 * }
	 */

	/**
	 * onPUAHighScoreBeaten	-	called when a highscore for a game has been beaten
	 *
	 * function onPUAHighScoreBeaten( $gameid, $gamename, $olduserid, $oldusername, $newuserid, $newusername, $score ) {
	 * }
	 *
	 */

	/**
	 * onPUAScoreSaved    	-  	called when ever a new score has been saved
	 *
	 * function onPUAScoreSaved( $gameid, $gamename, $newuserid, $newusername, $score) {
	 * }
	 *
	 */

	/**
	 * onPUANewGame			-	called when a new game is uploaded
	 *
	 * function onPUANewGame( $gameid, $gamename, $description, $imagefile, $folderid) {
	 * }
	 *
	 */

	/**
	 * onPUAContestScoreSaved	-	called when a new score for a contest has been saved
	 *
	 * function onPUAContestScoreSaved( $gameid, $gamename, $userid, $username, $score, $contestid, $contestname) {
	 * }
	 *
	 */

	/**
	 * onPUAContestStarted		-	called when a new contest has been published (to advertise)
	 *
	 * function onPUAContestStarted( $contestid, $contestname, $startdatetime, $enddatetime) {
	 * }
	 *
	 */

	/**
	 * onPUAContestEnded		-	called when a contest has completed
	 *
	 * function onPUAContestEnded( $contestid, $contestname, $startdatetime, $enddatetime) {
	 * }
	 *
	 */

}

?>
