<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */

defined('JPATH_BASE') or die;

Joomla\CMS\Form\FormHelper::loadFieldClass('list');



class JFormFieldFolders extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since   1.6
	 */
	protected $type = 'folders';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   1.6
	 */
	
	public function getFolderList() {
		$this->dbo = Joomla\CMS\Factory::getDbo();
		$this->dbo->setQuery('SELECT id AS value, name As text FROM #__jvarcade_folders ORDER BY id');
		$options = $this->dbo->loadObjectList();

		array_unshift($options, Joomla\CMS\HTML\HTMLHelper::_('select.option', '0', JText::_('COM_JVARCADE_GAMES_FILTERBYFOLDER')));
		
		return $options;
	}
	
	public function getOptions()
	{
		$options = $this->getFolderList();

		return array_merge(parent::getOptions(), $options);
	}
	
}