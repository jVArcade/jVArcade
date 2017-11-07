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

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.archive.archive');
		
class com_jvarcadeInstallerScript {			
		
    function preflight($type, $parent) {
	
		}//End Preflight
		
		
		function install($parent) {
			$app = Joomla\CMS\Factory::getApplication();
			require_once JPATH_ROOT . '/components/com_jvarcade/include/define.php';
			$backendPath = JPATH_ROOT . '/administrator/components/com_jvarcade/';
			$frontendPath = JPATH_ROOT . '/components/com_jvarcade/';
			$table = '#__jvarcade_games';
			$db = Joomla\CMS\Factory::getDBO();
			?>
			<center><h1>Installation of jVArcade <?php echo JVA_VERSION; ?> </h1></center>
			<?php
			$db->setQuery('SELECT COALESCE(COUNT(*), 0) FROM ' . $db->quoteName($table));
			$records_exist = @$db->loadResult();
			if (!(int)$records_exist) {
					$query = file_get_contents(JPATH_ADMINISTRATOR . '/components/com_jvarcade/install/sql/install.defaults.sql');
        			$queries = $db->splitSql($query);
        				foreach ($queries as $querie) { 
            			$db->setQuery($querie);
            			$db->execute();
            			$error = $db->getErrorNum();
                    		
						}
						if ($error) {
						    $app->enqueueMessage('<i class="icon-remove"></i>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_DEFAULT_FAILED'), 'error');
						} else {
						    $app->enqueueMessage('<i class="icon-ok"></i>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_DEFAULT_OK') );
						}
        	}
        
		// Create /arcade/gamedata directory. This prevents menu item with alias arcade being created which breaks gamedata rewrite rules
		
		if (!JFolder::exists(JPATH_ROOT . '/arcade')) {
			@JFolder::create(JPATH_ROOT . '/arcade', 0775);
			@JFolder::create(JPATH_ROOT . '/arcade/gamedata', 0775);
		}
		
		
		// ONLY FOR FRESH INSTALL - MOVE FOLDERS
		
		if (!JFolder::exists(JPATH_ROOT . '/images/jvarcade')) {

			$movefolders = array(
				array($frontendPath . 'images', JPATH_ROOT . '/images/jvarcade/images'),
				array($frontendPath . 'games', JPATH_ROOT . '/images/jvarcade/games'),
			);
			JFolder::create(JPATH_ROOT . '/images/jvarcade');
			foreach ($movefolders as $folder) {
				if (!JFolder::exists($folder[1])) {
					$mvres = JFolder::move($folder[0], $folder[1]);
				}
			}
			if ($mvres === true) {
				$app->enqueueMessage('<i class="icon-ok"></i>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_MOVEFOLDERS_OK'));
			} else {
			    $app->enqueueMessage('<i class="icon-remove"></i>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_MOVEFOLDERS_FAILED'), 'error');
			}
		} elseif (JFolder::exists(JPATH_ROOT . '/images/jvarcade')) {
			JFile::copy(dirname(__FILE__) . '/site/images/tick.png', JPATH_ROOT . '/images/jvarcade/images/tick.png');
			JFile::copy(dirname(__FILE__) . '/site/images/cpanel/games2.png', JPATH_ROOT . '/images/jvarcade/images/cpanel/games2.png');
			JFile::copy(dirname(__FILE__) . '/site/images/cpanel/menu-contests.png', JPATH_ROOT . '/images/jvarcade/images/cpanel/menu-contests.png');
			JFile::copy(dirname(__FILE__) . '/site/images/contentrating/gamewarning.png', JPATH_ROOT . '/images/jvarcade/images/contentrating/gamewarning.png');
			
			$app->enqueueMessage('<i class="icon-ok"></i>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_FILECOPY'));
		}
		
		// (RE)CREATE THE CATCH FILES IN THE JOOMLA ROOT
		
		
		$copyfiles = array(
			JPATH_ROOT . '/arcade/index.html' => '<html><body bgcolor="#FFFFFF"></body></html>',
			JPATH_ROOT . '/arcade/gamedata/index.html' => '<html><body bgcolor="#FFFFFF"></body></html>',
			JPATH_ROOT . '/newscore.php' => '<?php require_once \'./index.php\';',
			JPATH_ROOT . '/arcade.php' => '<?php require_once \'./index.php\';',
			
		);
		foreach ($copyfiles as $filename => $content) {
			if(JFile::exists($filename)) @JFile::delete($filename);
			file_put_contents($filename, $content);
		}
		
		
		$plugin_installer = new Joomla\CMS\Installer\Installer;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_jvarcade/install/plugins/plg_system_jvarcade';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='jvarcade' AND folder='system'";
			$db->setQuery( $q );
			$db->execute();				
			$app->enqueueMessage('<i class="icon-ok"></i> JVArcade System plugin installed and enabled successfully','message');
		} else $error++;
		
		$plugin_installer = new Joomla\CMS\Installer\Installer;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_jvarcade/install/plugins/plg_search_jvarcade';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='jvarcade' AND folder='search'";
			$db->setQuery( $q );
			$db->execute();				
			$app->enqueueMessage('<i class="icon-ok"></i> JVArcade Search plugin installed and enabled successfully','message');
		} else $error++;
		
		$plugin_installer = new Joomla\CMS\Installer\Installer;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_jvarcade/install/plugins/plg_jvarcade_atari';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='atari' AND folder='jvarcade'";
			$db->setQuery( $q );
			$db->execute();				
			$app->enqueueMessage('<i class="icon-ok"></i> JVArcade Atari2600 Emulator plugin installed and enabled successfully','message');
		} else $error++;
		
		$plugin_installer = new Joomla\CMS\Installer\Installer;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_jvarcade/install/plugins/plg_jvarcade_c64';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='c64' AND folder='jvarcade'";
			$db->setQuery( $q );
			$db->execute();				
			$app->enqueueMessage('<i class="icon-ok"></i> JVArcade Commodore 64 emulator plugin installed and enabled successfully','message');
		} else $error++;
		
		$plugin_installer = new Joomla\CMS\Installer\Installer;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_jvarcade/install/plugins/plg_jvarcade_gameboy';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='gameboy' AND folder='jvarcade'";
			$db->setQuery( $q );
			$db->execute();				
			$app->enqueueMessage('<i class="icon-ok"></i> JVArcade Nintendo Gameboy emulator plugin installed and enabled successfully','message');
		} else $error++;
		
		$plugin_installer = new Joomla\CMS\Installer\Installer;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_jvarcade/install/plugins/plg_jvarcade_nes';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='nes' AND folder='jvarcade'";
			$db->setQuery( $q );
			$db->execute();				
			$app->enqueueMessage('<i class="icon-ok"></i> JVArcade Nintendo Nes and Famicom emulator plugin installed and enabled successfully','message');
		} else $error++;
		
			
			
	}//end install function
	
	function update($parent) {
		$this->install($parent);
	}
	
	function uninstall($parent) {
		
		
		
		
	}//end uninstall function
	
	
	function postflight ($type, $parent) {
	    
	    //Remove old files no longer needed due to code overhaul
	    $controllerPath = JPATH_ROOT . '/administrator/components/com_jvarcade/controllers/';
	    $modelPath = JPATH_ROOT . '/administrator/components/com_jvarcade/models/';
	    $viewPath = JPATH_ROOT . '/administrator/components/com_jvarcade/views/';
		$oldfiles = array(
		    JPATH_ADMINISTRATOR . '/manifests/packages/pkg_jvarcade.xml', JPATH_ROOT . '/tmp/jva-version-compare.txt', JPATH_ROOT . '/crossdomain.xml',
		    $controllerPath . 'content_ratings.php', $controllerPath . 'edit_contentrating.php', $controllerPath . 'edit_contest.php', $controllerPath . 'edit_folder.php',
		    $controllerPath . 'edit_game.php', $controllerPath . 'manage_folders.php', $controllerPath . 'manage_games.php', $controllerPath . 'manage_scores.php',
		    $modelPath . '/forms/filter_manage_games.xml', $modelPath . '/forms/filter_manage_scores.xml', $modelPath . 'content_ratings.php', $modelPath . 'edit_contentrating.php',
		    $modelPath . 'edit_contest.php', $modelPath . 'edit_folder.php', $modelPath . 'edit_game.php', $modelPath . 'manage_folders.php', $modelPath . 'manage_games.php',
		    $modelPath . 'manage_scores.php',
		);
		
		foreach ($oldfiles as $file) {
		    if(JFile::exists($file)) @JFile::delete($file);
		}
		
		$oldfolders = array(
		    JPATH_ADMINISTRATOR . '/manifests/packages/jvarcade', $viewPath . 'content_ratings', $viewPath . 'edit_contentrating', $viewPath . 'edit_contest',
		    $viewPath . 'edit_folder', $viewPath . 'edit_game', $viewPath . 'manage_folders', $viewPath . 'manage_games', $viewPath . 'manage_scores', $viewPath . 'rss',
		    $viewPath . 'settings',
		    
		);
		
		foreach ($oldfolders as $folder) {
		  if(JFolder::exists($folder)) @JFolder::delete($folder);
		}
		//Migrate settings from old #__jvarcade_settings table to component paramaters in #__extensions table
		$db = Joomla\CMS\Factory::getDBO();
		$table = '#__jvarcade_settings';
		try {
		      $db->setQuery('SELECT COALESCE(COUNT(*), 0) FROM ' . $db->quoteName($table));
		      $records_exist = @$db->loadResult();
		      if ((int)$records_exist) {
		    
		          $query = $db->getQuery(true);
		          $query->delete('#__jvarcade_settings')->where('optname = load_jquery');
		          $db->execute();
		    
		          $query = $db->getQuery(true);
		          $query->select(array('optname', 'value'))
		          ->from($table);
		          $db->setQuery($query);
		          $res = $db->loadObjectList();
		          $obj = new stdClass();
		       if (count($res)) {
		        foreach ($res as $row) {
		            $optname = $row->optname;
		            $obj->$optname = $row->value;
		        }
		       }
		       $obj->TagPerms = ["1","2","3","4","5","6","7","8","9"];
		       $obj->DloadPerms = ["1","2","3","4","5","6","7","8","9"];
		       $obj->profile_scores = "5";
		       $obj->profile_faves = "5";
		       $globals = json_encode($obj);
		   
		      //Remove #__jvarcade_settings table if it exists
		      $db->dropTable('#__jvarcade_settings', true);
		      } 
		      
		} catch (Exception $e) {//Set default settings for new installation
		    $globals = '{"date_format":"Y-m-d","time_format":"H:i:s","guest_name":"jVArcadeGuest",'
                          . '"installed_charset":"UTF-8","table_max":"100","allow_gview":"1",'
                          . '"allow_gplay":"1","allow_gsave":"1","leaderboard":"1","faves":"1",'
                          . '"display_onlysingleurl":"1","tagcloud":"1","TagPerms":["1","9","6","7","2","3","4","5","8"],'
                          . '"TagLimit":"0","updatelb":"15","max_faves":"10","contentrating":"1","game_modal":"0",'
                          . '"enable_dload":"1","DloadPerms":["1","9","6","7","2","3","4","5","8"],"title":"jVArcade",'
                          . '"template":"default","scoreundergame":"1","foldergames":"1","rate":"1","showstats":"1",'
                          . '"showscoresinfolders":"1","homepage_view":"default","homepage_order":"1","homepage_order_dir":"1",'
                          . '"foldercols":"1","GamesPerPage":"2","display_max":"20","bookmarks":"1","specialfolders":"1","report":"1",'
                          . '"roundcorners":"1","randgamecount":"3","truncate_title":"50","alias_folder":"","alias_popular":"",'
                          . '"alias_newest":"","alias_contests":"","alias_leaderboard":"","alias_favourite":"","alias_random":"",'
                          . '"show_usernames":"1","comments":"0","scorelink":"0","show_avatar":"1","communitybuilder_itemid":"7",'
                          . '"aup_itemid":"8","profile_scores":"5","profile_faves":"5"}';
		}
		
		$query = $db->getQuery(true);
		$query->update($db->quoteName('#__extensions'));
		$query->set($db->quoteName('params') . ' = ' . $db->quote($globals));
		$query->where($db->quoteName('element') . ' = ' . $db->quote('com_jvarcade'));
		$db->setQuery($query);
		$db->execute();
	}//end postflight function



}
?>