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
class jvarcadeToolbarHelper {
	
	public static function addSubmenu($vName = 'cpanel') {
	
		JHtmlSidebar::addEntry(
		JText::_('COM_JVARCADE_CPANEL'), 'index.php?option=com_jvarcade&view=cpanel', $vName == 'cpanel');
		
		JHtmlSidebar::addEntry(
		JText::_('COM_JVARCADE_MANAGE_SCORES'), 'index.php?option=com_jvarcade&view=scores', $vName == 'scores');
		
		JHtmlSidebar::addEntry(
		JText::_('COM_JVARCADE_MANAGE_FOLDERS'), 'index.php?option=com_jvarcade&view=folders', $vName == 'folders');
		
		JHtmlSidebar::addEntry(
		JText::_('COM_JVARCADE_MANAGE_GAMES'), 'index.php?option=com_jvarcade&view=games', $vName == 'games');
		
		JHtmlSidebar::addEntry(
		JText::_('COM_JVARCADE_UPLOAD_ARCHIVE'), 'index.php?option=com_jvarcade&view=game_upload', $vName == 'game_upload');
		
		JHtmlSidebar::addEntry(
		JText::_('COM_JVARCADE_MAINTENANCE'), 'index.php?option=com_jvarcade&view=maintenance', $vName == 'maintenance');
		
		JHtmlSidebar::addEntry(
		JText::_('COM_JVARCADE_CONTENT_RATINGS'), 'index.php?option=com_jvarcade&view=contentratings', $vName == 'content_ratings');
		
		JHtmlSidebar::addEntry(
		JText::_('COM_JVARCADE_CONTESTS'), 'index.php?option=com_jvarcade&view=contests', $vName == 'contests');
		
		JHtmlSidebar::addEntry(
		JText::_('COM_JVARCADE_SUPPORT'), 'http://jvarcade.com/forum/jvarcade-support', $vName == 'support');
	
	}
	
}
?>
