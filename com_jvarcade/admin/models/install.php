<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die('Restricted access');


class jvarcadeModelInstall extends Joomla\CMS\MVC\Model\BaseDatabaseModel {
	private $db;
	private $app;
	private $config;
	private $dispatcher;
	
	public function __construct() {
		parent::__construct();
		$this->db = Joomla\CMS\Factory::getDBO();
		$this->app = Joomla\CMS\Factory::getApplication();
		$this->config = Joomla\CMS\Factory::getConfig();
		$this->dispatcher = JDispatcher::getInstance();
	}
	
	public function doAcctualInstall($pkg) {
		
		if (!$pkg) {
			$this->app->enqueueMessage(JText::_('COM_JVARCADE_UPLOADARCHIVE_NOPACKAGE'), 'error');
			$this->app->redirect('index.php?option=com_jvarcade&view=game_upload');
			jexit();
		}
		
		$folderid = $this->app->input->getInt('folderid', 1);
		$published = $this->app->input->getInt('published', 0);
		$packages = array();
		$errormsg = array();
		
		$archives = JFolder::files($pkg['dir'], '\.zip|\.tar|\.tgz|\.gz|\.gzip|.tbz2|\.bz2|\.bzip2', false, false, array('.svn', 'CVS', '.DS_Store', '__MACOSX'), array('^\..*','.*~'));
		$bulk = count($archives) ? true : false;
		
		if ($bulk) {
			if ($archives && is_array($archives) && count($archives)) {
				$tmp_package = false;
				foreach ($archives as $archive) {
					$tmp_package = jvaHelper::unpack($pkg['dir'] . '/' . $archive);
					if (!$tmp_package) {
						$errormsg[] = $archive . ': ' . JText::_('COM_JVARCADE_UPLOADARCHIVE_NOPACKAGE');
					} else {
						$packages[] = $tmp_package;
					}
				}
			}
		} else {
			$packages[] = $pkg;
		}
		
		if ($packages && is_array($packages) && count($packages)) {
			foreach ($packages as $package) {

				// Detect game type
				$config = array();
				$package_type = jvaHelper::detectPackageType($package['dir']);
				if ($package_type) {
					$name = 'parseConfig' . ucfirst($package_type);
					$config = $this->$name($package['dir']);
				}
				
				// CHECKS
				
				// check if we have game file
				if (!isset($config['name']) || !$config['name']) {
					$errormsg[] = $package['packagefile'] . ': ' . JText::_('COM_JVARCADE_UPLOADARCHIVE_NOGNAME');
				}
				
				// check if the extensions are allowed
				$file_ext = substr(strrchr($config['filename'], '.'), 1);
				$image_ext = substr(strrchr($config['imagename'], '.'), 1);
				if (!count($errormsg) && !in_array($file_ext, array('bin', 'd64', 'dcr', 'gb', 'gbc', 'htm', 'html', 'nes', 'prg', 'sna', 'swf', 'z80'))) {
					$errormsg[] = $config['name'] . ': ' . JText::_('COM_JVARCADE_UPLOADARCHIVE_BADEXTGAME');
				}
				if (!count($errormsg) && !in_array($image_ext, array('bmp', 'gif', 'jpeg', 'jpg', 'png'))) {
					$errormsg[] = $config['name'] . ': ' . JText::_('COM_JVARCADE_UPLOADARCHIVE_BADEXTIMG');
				}
				
				if (!count($errormsg)) {
				
					// if there is already game with that name, we make a unique name
					$this->db->setQuery('SELECT id FROM #__jvarcade_games WHERE gamename = ' . $this->db->Quote($config['name']));
					$game_exists = (int)$this->db->loadResult();
					if ($game_exists) {
						$config['name'] = uniqid($config['name'] . '_');
					}
				
					// change filename and imagename to be unique as well
					$config['newfilename'] = $config['name'] . '.' . $file_ext;
					$config['newimagename'] = $config['name'] . '.' . $image_ext;
					
					// INSTALL
					
					$this->db->setQuery("INSERT INTO #__jvarcade_games " . 
							  "(" . $this->db->quoteName('gamename') . ", " . $this->db->quoteName('title') . ", " . $this->db->quoteName('description') . ", " . 
									$this->db->quoteName('height') . ", " . $this->db->quoteName('width') . ", " . $this->db->quoteName('filename') . ", " . $this->db->quoteName('imagename') . ", " . 
									$this->db->quoteName('background') . ", " . $this->db->quoteName('published') . ", " . $this->db->quoteName('reverse_score') . ", " . 
									$this->db->quoteName('scoring') . ", " . $this->db->quoteName('folderid') . ") " .
							"VALUES (" . $this->db->Quote($config['name']) . "," . $this->db->Quote($config['title']) . "," . $this->db->Quote($config['description']) . "," . 
										$this->db->Quote((int)$config['height']) . "," . $this->db->Quote((int)$config['width']) . "," . $this->db->Quote($config['newfilename']) . "," . $this->db->Quote($config['newimagename']) . "," . 
										$this->db->Quote($config['background']) . "," . $this->db->Quote((int)$published) . "," . $this->db->Quote((int)$config['reverse_score']) . "," . 
										$this->db->Quote((int)$config['scoring']) . "," . $this->db->Quote((int)$folderid) . ")"
					);
					if(!$this->db->execute()) {
						$errormsg[] = $config['name'] . ': ' . $this->db->getErrorMsg();
					} else {
						$gameid = $this->db->insertid();
					}
					
					if (!count($errormsg)) {
						$copyfiles = array(
							array('src' => $package['dir'] . '/' . $config['filename'], 'dest' => JVA_GAMES_INCPATH . $config['newfilename']),
							array('src' => $package['dir'] . '/' . $config['imagename'], 'dest' => JVA_IMAGES_INCPATH . 'games' . '/' . $config['newimagename']),
						);
						foreach ($copyfiles as $copyfile) {
							if (copy($copyfile['src'], $copyfile['dest'])) {
								@chmod($copyfile['dest'], 0644);
							} else {
								$errormsg[] = $config['name'] . ': ' . JText::sprintf('COM_JVARCADE_UPLOADARCHIVE_COPYERR', $copyfile['src'], $copyfile['dest']);
							}
						}
					}
					
					if (!count($errormsg)) {
						// Take care of gamedata folder if exists
						$gamedatasrc = $package['dir'] . '/' . 'gamedata' . '/' . $config['name'];
						$gamedatadest = JPATH_SITE . '/' . 'arcade' . '/' . 'gamedata' . '/' . $config['name'];
						if (JFolder::exists($gamedatasrc)) {
							JFolder::move($gamedatasrc, $gamedatadest);
						}
					}
					
					// cleanup
					if ($package['packagefile'] && is_file($package['packagefile'])) JFile::delete($package['packagefile']);
					if ($package['extractdir'] && is_dir($package['extractdir'])) JFolder::delete($package['extractdir']);
				}
			}
		}
		if(!count($errormsg)) {
		    //Trigger new game event
		    $this->dispatcher->trigger('onPUANewGame', array($config['title'], $config['description'], $config['newimagename'], (int)$folderid));
		}
		// GENERAL CLEANUP
		if ($pkg['packagefile'] && is_file($pkg['packagefile'])) JFile::delete($pkg['packagefile']);
		if ($pkg['extractdir'] && is_dir($package['extractdir'])) JFolder::delete($pkg['extractdir']);
		
		// Redirect, show messages
		
		$msg = (count($errormsg) ? implode('<br />', $errormsg) : JText::sprintf('COM_JVARCADE_UPLOADARCHIVE_SUCCESS'));
		$msg_type = count($errormsg) ? 'error' : 'message';
		$this->app->enqueueMessage($msg, $msg_type);
		$this->app->redirect('index.php?option=com_jvarcade&view=game_upload');
		jexit();
	}
	
	public function parseConfigMochi($dir) {
		$files = JFolder::files($dir, '\.json');
		$config = $dir . '/' . $files[0];
		$obj = json_decode(file_get_contents($config));
		return array(
			'name' => $obj->slug,
			'title' => $obj->name,
			'filename' => urldecode(basename($obj->swf_url)),
			'imagename' => basename($obj->thumbnail_url),
			'description' => $obj->description . '<br/>' . $obj->instructions,
			'width' => $obj->width,
			'height' => $obj->height,
			'author' => $obj->developer,
			'background' => '',
			'scoring' => 1,
			'reverse_score' => 0,
		);
	}
	
	public function parseConfigPnflash($dir) {
		$files = JFolder::files($dir, '\.ini');
		$config = $dir . '/' . $files[0];
		$arr = parse_ini_file($config);
		//$basename = basename(basename($files[0], '.ini'), '.INI');
		$game_files = JFolder::files($dir, '\.bin|\.d64|\.dcr|\.gb|\.gbc|\.htm|\.html|\.nes|\.prg|\.sna|\.swf|\.z80');
		reset($game_files);
		$game_file = current($game_files);
		$image_files = JFolder::files($dir, '\.bmp|\.gif|\.jpeg|\.jpg|\.png');
		reset($image_files);
		$image_file = current($image_files);
		
		return array(
			'name' => strtolower(str_replace(' ', '-', $arr['name'])),
			'title' => $arr['name'],
			'filename' => $game_file,
			'imagename' => $image_file,
			'description' => $arr['description'],
			'width' => $arr['width'],
			'height' => $arr['height'],
			'author' => $arr['author'],
			'background' => '#' . $arr['bgcolor'],
			'scoring' => 1,
			'reverse_score' => ((int)$arr['gameType'] == 2 ? 1: 0),
		);
	}
	
	public function parseConfigPnflashtxt($dir) {
		$files = JFolder::files($dir, '\.txt', false, false, array('.svn', 'CVS', '.DS_Store', '__MACOSX', 'contents.txt'));
		$config = $dir . '/' . $files[0];
		$string = file_get_contents($config);
		
		$game_title = preg_match('/(Game Name(.*)|Title(.*))/i', $string, $matches) ? trim(str_replace(array('Game Name:','Title:'), '', $matches[1])) : '';
		$game_name = strtolower(str_replace(' ', '-', $game_title));
		$game_desc = preg_match('~Description(.*)~i', $string, $matches) ? trim(str_replace(':', '', $matches[1])) : '';
		$game_desc2 = preg_match('~Desc:(.*)~i', $string, $matches) ? trim(str_replace(':', '', $matches[1])) : '';
		$game_desc = !$game_desc ? $game_desc2 : $game_desc;
		$game_type = preg_match('~Game Type(.*)~i', $string, $matches) ? trim(str_replace(':', '', $matches[1])) : '';
		$game_author = preg_match('~Authors Name(.*)~i', $string, $matches) ? trim(str_replace(':', '', $matches[1])) : '';
		$game_width = preg_match('~Width(.*)~i', $string, $matches) ? trim(str_replace(':', '', $matches[1])) : '';
		$game_height = preg_match('~Height(.*)~i', $string, $matches) ? trim(str_replace(':', '', $matches[1])) : '';
		$game_bgcolor = preg_match('~Color(.*)~', $string, $matches) ? trim(str_replace(':', '', $matches[1])) : '';
		
		//$basename = basename(basename($files[0], '.txt'), '.txt');
		$game_files = JFolder::files($dir, '\.bin|\.d64|\.dcr|\.gb|\.gbc|\.htm|\.html|\.nes|\.prg|\.sna|\.swf|\.z80');
		reset($game_files);
		$game_file = current($game_files);
		$image_files = JFolder::files($dir, '\.bmp|\.gif|\.jpeg|\.jpg|\.png');
		reset($image_files);
		$image_file = current($image_files);
		
		return array(
			'name' => $game_name,
			'title' => $game_title,
			'filename' => $game_file,
			'imagename' => $image_file,
			'description' => $game_desc,
			'width' => (int)$game_width,
			'height' => (int)$game_height,
			'author' => $game_author,
			'background' => $game_bgcolor,
			'scoring' => 1,
			'reverse_score' => ($game_type == 'Highest Score Wins' ? 1: 0),
		);

	}
	
	public function parseConfigIbpro($dir) {
		$files = JFolder::files($dir, '\.php');
		$file = $dir . '/' . $files[0];
		@require_once($file);
		$arr = $config;
		//$basename = basename(basename($files[0], '.php'), '.PHP');
		$game_files = JFolder::files($dir, '\.bin|\.d64|\.dcr|\.gb|\.gbc|\.htm|\.html|\.nes|\.prg|\.sna|\.swf|\.z80');
		reset($game_files);
		$game_file = current($game_files);
		$image_files = JFolder::files($dir, '\.bmp|\.gif|\.jpeg|\.jpg|\.png');
		reset($image_files);
		$image_file = current($image_files);
		
		return array(
			'name' => $arr['gname'],
			'title' => $arr['gtitle'],
			'filename' => $game_file,
			'imagename' => $image_file,
			'description' => ($arr['gwords'] ? $arr['gwords'] : ($arr['object'] ? $arr['object'] : '')),
			'width' => $arr['gwidth'],
			'height' => $arr['gheight'],
			'author' => '',
			'background' => '#' . $arr['bgcolor'],
			'scoring' => 1,
			'reverse_score' => 0,
		);
	}

}