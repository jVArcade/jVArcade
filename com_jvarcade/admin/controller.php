<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die;



class jvarcadeController extends Joomla\CMS\MVC\Controller\BaseController {
    
    protected $default_view='cpanel';
	
	public function display($cachable = false, $urlparams = false)
	{
		
		$vName = $this->input->get('view', 'cpanel');
		
		switch ($vName)
		{
				
			case 'scores':
				$vLayout = $this->input->get('layout', 'default', 'string');
				$mName = 'scores';
				
				break;
				
			case 'folders':
				$vLayout = $this->input->get('layout', 'default', 'string');
				$mName = 'folders';
				
				break;
			
			
			case 'folder':
				$vName = 'folder';
				$vLayout = $this->input->get('layout', 'edit', 'string');
				$mName = 'folder';
				
				break;
				
			case 'games':
				$vLayout = $this->input->get('layout', 'default', 'string');
				$mName = 'games';
				
				break;
			
			case 'game':
				$vName = 'game';
				$vLayout = $this->input->get('layout', 'edit', 'string');
				$mName = 'game';
				
				break;
				
			case 'contests':
				$vLayout = $this->input->get('layout', 'default', 'string');
				$mName = 'contests';
				
				break;
				
			case 'contest':
				$vName = 'contest';
				$vLayout = $this->input->get('layout', 'edit', 'string');
				$mName = 'contest';
				
				break;
			
			case 'addgametocontest':
				$vName = 'contestlink';
				$vLayout = $this->input->get('layout', 'default', 'string');
				$mName = 'AdminCommon';
				
				break;
				
			case 'addcontestgames':
				$vName = 'contestlink';
				$vLayout = $this->input->get('layout', 'contestgames', 'string');
				$mName = 'AdminCommon';
				
				break;
				
			case 'showcontestgames':
				$vName = 'contestlink';
				$vLayout = $this->input->get('layout', 'games', 'string');
				$mName = 'AdminCommon';
				
				break;
				
			case 'showgamecontests':
				$vName = 'contestlink';
				$vLayout = $this->input->get('layout', 'contests', 'string');
				$mName = 'AdminCommon';
				
				break;
				
			case 'game_upload':
				$vLayout = $this->input->get('layout', 'default', 'string');
				$mName = 'game_upload';
				
				break;
				
			case 'maintenance':
				$vLayout = $this->input->get('layout', 'default', 'string');
				$mName = 'AdminCommon';
				
				break;

			case 'contentratings':
				$vLayout = $this->input->get('layout', 'default', 'string');
				$mName = 'contentratings';
				
				break;
				
			case 'contentrating':
				$vName = 'contentrating';
				$vLayout = $this->input->get('layout', 'edit', 'string');
				$mName = 'contentrating';
				
				break;
				
			case 'cpanel':
			default:
				$vName = 'cpanel';
				$vLayout = $this->input->get('layout', 'default', 'string');
				$mName = 'AdminCommon';
				
				break;
			
				
		}
		
		$document = Joomla\CMS\Factory::getDocument();
		$vType    = $document->getType();
		
		// Get/Create the view
		$view = $this->getView($vName, $vType);
		$view->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR . '/views/' . strtolower($vName) . '/tmpl');
		
		// Get/Create the model
		if ($model = $this->getModel($mName))
		{
			// Push the model into the view (as default)
			$view->setModel($model, true);
		}
		
		// Set the layout
		$view->setLayout($vLayout);
		
		// Display the view
		$view->display();
		
		return $this;
	}

	public function savegametocontest() {
		$app = Joomla\CMS\Factory::getApplication();
		$game_ids = $app->input->getString('game_ids', '');
		$contest_ids = $app->input->getString('contest_ids', '');
		if ($game_ids && $contest_ids) {
			$game_ids = explode(',', $game_ids);
			Joomla\Utilities\ArrayHelper::toInteger($game_ids);
			$contest_ids = explode(',', $contest_ids);
			Joomla\Utilities\ArrayHelper::toInteger($contest_ids);
			$model = $this->getModel('AdminCommon');
			if($model->addGameToContest($game_ids, $contest_ids)) {
				echo JText::_('COM_JVARCADE_CONTESTSLINK_SAVE_SUCCESS');
			} else {
				echo JText::_('COM_JVARCADE_CONTESTSLINK_SAVE_ERROR');
			}
		} else {
			echo JText::_('COM_JVARCADE_CONTESTSLINK_SAVE_EMPTY');
		}
		exit;
	}
	
	public function deletegamefromcontest() {
		$app = Joomla\CMS\Factory::getApplication();
		$game_ids = $app->input->getString('game_id', '');
		$contest_ids = $app->input->getString('contest_id', '');
		if ($game_ids && $contest_ids) {
			$game_ids = explode(',', $game_ids);
			Joomla\Utilities\ArrayHelper::toInteger($game_ids);
			$contest_ids = explode(',', $contest_ids);
			Joomla\Utilities\ArrayHelper::toInteger($contest_ids);
			$model = $this->getModel('AdminCommon');
			if($model->deleteGameFromContest($game_ids, $contest_ids)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			echo 0;
		}
		exit;		
	}
	
	public function domaintenance() {
		$app = Joomla\CMS\Factory::getApplication();
		$service = $app->input->getWord('service', '');
		$context = $app->input->getWord('context', '');
		$gameid = $app->input->getInt('gameid', 0);
		$contestid = $app->input->getInt('contestid', 0);
		$model = $this->getModel('AdminCommon');
		$jsonDATA = $model->doMaintenance($service, $context, $gameid, $contestid);
		$app->input->set('tmpl', 'component');
		$app->input->set('format', 'raw');
		$doc = Joomla\CMS\Factory::getDocument();
		$doc->setMimeEncoding('application/json', false);
		echo json_encode($jsonDATA);
		exit;
	}

	public function domigration() {
		$app = Joomla\CMS\Factory::getApplication();
		$step = $app->input->getInt('step', 0);
		$model = $this->getModel('Migration');
		$jsonDATA = $model->doMigration($step);
		$app->input->set('tmpl', 'component');
		$app->input->set('format', 'raw');
		$doc = Joomla\CMS\Factory::getDocument();
		$doc->setMimeEncoding('application/json', false);
		echo json_encode($jsonDATA);
		exit;
	}
		
}

?>
