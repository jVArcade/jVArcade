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

class jvarcadeControllerUploadavatar extends Joomla\CMS\MVC\Controller\BaseController {
	
	public function upload(){
		
		$app = Joomla\CMS\Factory::getApplication();
		$userid = $app->input->get('id');
		$upload = $app->input->files->get('avatar');
		
		$fileExt = JFile::getExt($upload['name']);
		if (!in_array(strtolower($fileExt), array('bmp', 'gif', 'jpeg', 'jpg', 'png'))){
			$app->enqueueMessage(JText::sprintf('COM_JVARCADE_UPLOAD_AVATAR_PRE_ERR1') . $fileExt . JText::sprintf('COM_JVARCADE_UPLOAD_AVATAR_POST_ERR1'), 'Error');
			$app->redirect('index.php?option=com_jvarcade&view=uploadavatar&tmpl=component&id=' . $userid);
			exit;
		}
		
		list($imgwith, $imgheight) = @getimagesize($upload['tmp_name']);
		
		if (($imgwith > 256 || $imgheight > 256)) {
			$app->enqueueMessage(JText::_('COM_JVARCADE_UPLOAD_AVATAR_DIMS'), 'Error');
			$app->redirect('index.php?option=com_jvarcade&view=uploadavatar&tmpl=component&id=' . $userid);
			exit;
		}
		
		$imgSearch = glob('images/jvarcade/images/avatars/' .$userid. '.*');
		if (isset($imgSearch[0])) {
			JFile::delete($imgSearch[0]);
		}
		
		$src = $upload['tmp_name'];
		$dest = 'images/jvarcade/images/avatars/' . $userid . '.' . $fileExt;
		
		if (!JFile::upload($src, $dest)) {
			$app->enqueueMessage(JText::_('COM_JVARCADE_UPLOAD_AVATAR_ERR2'), 'Error');
		} else {
			$app->enqueueMessage(JText::_('COM_JVARCADE_UPLOAD_AVATAR'));
		}
		$app->redirect('index.php?option=com_jvarcade&view=uploadavatar&tmpl=component&id=' . $userid);
	}
}
