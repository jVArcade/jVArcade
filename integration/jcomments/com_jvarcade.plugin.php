<?php
/**
 * @package		jVArcade
 * @version		2.15
 * @date		1-11-2017
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvarcade.com
 */

class jc_com_jvarcade extends JCommentsPlugin {
   
    
	function getObjectInfo($id, $language = null) {
		$db = Joomla\CMS\Factory::getDbo();
		$query = "SELECT title, id FROM #__jvarcade_games WHERE id = " . $id;
		$db->setQuery($query);
		$row = $db->loadObject();
		
		$info = new JCommentsObjectInfo();
		
		if (!empty($row)) {
			$db->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_jvarcade&view=home' and published = 1");
			$Itemid = $db->loadResult();
		
			if (!$Itemid) {
				$Itemid = self::getItemid('com_jvarcade');
			}
		
		$Itemid = $Itemid > 0 ? '&amp;Itemid='.$Itemid : '';
		
		$info->title = $row->title;
		$info->id = $row->id;
		$info->link = Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade'.$Itemid.'&view=game&id=' . $id);
		}
		return $info;
	}
	
	
}

?>
