<?php
/**
 * @package		jVArcade
 * @version		2.15
 * @date		1-11-2017
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		http://jvarcade.com
 */

defined('_JEXEC') or die;

class jvarcadeViewUploadavatar extends Joomla\CMS\MVC\View\HtmlView {
	
	public function display($tpl=null){
		$app = Joomla\CMS\Factory::getApplication();
		$this->user_id = (int)$app->input->get('id');
 
		// Display the view
		parent::display($tpl);
	}
}
