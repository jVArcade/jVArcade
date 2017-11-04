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
			$install = '<div style="align:left;">';
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
							Joomla\CMS\Factory::getApplication()->enqueueMessage(JText::_('COM_JVARCADE_INSTALLER_UPGRADE_DEFAULT_FAILED'), 'error');
						} else {
							$install .= '<img src="'. JVA_IMAGES_SITEPATH. 'tick.png" align="absmiddle"/>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_DEFAULT_OK') .'<br />';
						}
        	} else {
			
					$alters = array();
					//if (count($alters)) {
						foreach ($alters as $query) {
							$db->setQuery($query);
						try {
        					$db->execute();
        				} catch (RuntimeException $e) {
        					$ec1 = $e->getCode();
        				}
						}
					//}
					if($ec1 == 1091) {
					
        			$install .= '<img src="'. JVA_IMAGES_SITEPATH. 'tick.png" align="absmiddle"/>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_COLUMNS_OK') .'<br />';
					}
        		//}
        			
        		
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
				$install .= '<img src="'. JVA_IMAGES_SITEPATH. 'tick.png" align="absmiddle"/>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_MOVEFOLDERS_OK') .'<br />';
			} else {
				$install .= '<img src="'. JVA_IMAGES_SITEPATH. 'red_x.png" align="absmiddle"/>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_MOVEFOLDERS_FAILED') .'<br />';
			}
		} elseif (JFolder::exists(JPATH_ROOT . '/images/jvarcade')) {
			JFile::copy(dirname(__FILE__) . '/site/images/tick.png', JPATH_ROOT . '/images/jvarcade/images/tick.png');
			JFile::copy(dirname(__FILE__) . '/site/images/cpanel/games2.png', JPATH_ROOT . '/images/jvarcade/images/cpanel/games2.png');
			JFile::copy(dirname(__FILE__) . '/site/images/cpanel/rss.png', JPATH_ROOT . '/images/jvarcade/images/cpanel/rss.png');
			JFile::copy(dirname(__FILE__) . '/site/images/cpanel/menu-contests.png', JPATH_ROOT . '/images/jvarcade/images/cpanel/menu-contests.png');
			JFile::copy(dirname(__FILE__) . '/site/images/contentrating/gamewarning.png', JPATH_ROOT . '/images/jvarcade/images/contentrating/gamewarning.png');
		}
		
		// (RE)CREATE THE CATCH FILES IN THE JOOMLA ROOT
		
		$install .= '<img src="'. JVA_IMAGES_SITEPATH. 'tick.png"/>' . JText::_('COM_JVARCADE_INSTALLER_UPGRADE_FILECOPY') .'<br />';
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
		
		echo $install;
		echo "</div><br /><br /><br />";
		
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
		
		
		
		
		
	}//end postflight function



}
?>