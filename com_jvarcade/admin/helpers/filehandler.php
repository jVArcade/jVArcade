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

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class JvaFileHandler extends JEvent {
    
    private $model = null;
    
    public function __construct(&$subject, $model) {
        parent::__construct($subject);
        
        $this->model = $model;
        $this->app = Joomla\CMS\Factory::getApplication();
        $this->dbo = Joomla\CMS\Factory::getDbo();
        $this->dispatcher = JDispatcher::getInstance();
    }
    
    function onJvaGameSave($context, $table, $isNew, $data) {

        if ($context = 'com_jvarcade.game') {
            $gameid = $table->id;
            $imgfile = $data['image'];
            $gamefile = $data['file'];
            
            // Process game image upload
            if ((int)$gameid && is_array($imgfile) && $imgfile['size'] > 0) {
                
                list($imgwith, $imgheight) = @getimagesize($imgfile['tmp_name']);
                
                if (!$uploaderr && $imgfile['error']) {
                    $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR', $imgfile['name']);
                }
                if (!$uploaderr && (strpos($imgfile['type'], 'image') === false)) {
                    $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_NOT_IMAGE', $imgfile['name']);
                }
                if (!$uploaderr && ($imgwith > 50 || $imgheight > 50)) {
                    $uploaderr = JText::_('COM_JVARCADE_UPLOAD_BIGGER_DIMS2');
                }
                if (!$uploaderr) {
                    jimport('joomla.filesystem.file');
                    $uploaded = JFile::upload($imgfile['tmp_name'], JVA_IMAGES_INCPATH . 'games/' . $gameid . '_' . $imgfile['name']);
                    if ($uploaded) {
                        $this->dbo->setQuery('UPDATE #__jvarcade_games SET ' .
                            $this->dbo->quoteName('imagename') . ' = ' . $this->dbo->Quote($gameid . '_' . $imgfile['name']) .
                            ' WHERE ' . $this->dbo->quoteName('id') . ' = ' . (int)$gameid);
                            if (!$this->dbo->execute()) $this->getDBerr();
                    } else {
                        $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR_MOVING', $imgfile['name']);
                    }
                }
                if ($uploaderr) {
                    $this->app->enqueueMessage($uploaderr, 'error');
                    $this->app->redirect(Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=game&layout=edit&id=' . $gameid, false));
                }
            }
            // Process game file upload
            if ((int)$gameid && is_array($gamefile) && $gamefile['size'] > 0) {
                
                if (!$uploaderr2 && $gamefile['error']) {
                    $uploaderr2 = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR', $gamefile['name']);
                }
                if (!$uploaderr2) {
                    jimport('joomla.filesystem.file');
                    $uploaded = JFile::upload($gamefile['tmp_name'], JVA_GAMES_INCPATH . $gamefile['name']);
                    if ($uploaded) {
                        $this->dbo->setQuery('UPDATE #__jvarcade_games SET ' .
                            $this->dbo->quoteName('filename') . ' = ' . $this->dbo->Quote($gamefile['name']) .
                            ' WHERE ' . $this->dbo->quoteName('id') . ' = ' . (int)$gameid);
                            if (!$this->dbo->execute()) $this->getDBerr();
                    } else {
                        $uploaderr2 = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR_MOVING', $gamefile['name']);
                    }
                }
                if ($uploaderr2) {
                    $this->app->enqueueMessage($uploaderr2, 'error');
                    $this->app->redirect(Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=game&layout=edit&id=' . $gameid, false));
                }
            }
        }
    }
    
    function onJvaGameDelete($context, $table){
        
        if($context = 'com_jvarcade.game'){
            if (JFile::exists(JVA_GAMES_INCPATH . '/' . $table->filename)) @JFile::delete(JVA_GAMES_INCPATH . $table->filename);
            if (JFile::exists(JVA_IMAGES_INCPATH . 'games/' . $table->imagename)) @JFile::delete(JVA_IMAGES_INCPATH . 'games/' . $table->imagename);
            if (JFolder::exists(JPATH_SITE . '/arcade/gamedata/' . $table->gamename)) {
                @JFolder::delete(JPATH_SITE . '/arcade/gamedata/' . $table->gamename);
            }
            
            $query = "DELETE FROM #__jvarcade WHERE " . $this->dbo->quoteName('gameid') . " = " . $table->id;
            $this->dbo->setQuery($query);
            
            if ($this->dbo->execute()) {
                $this->dbo->setQuery("DELETE FROM #__jvarcade_contestgame WHERE " . $this->dbo->quoteName('gameid') . " = " . $table->id);
                $this->dbo->execute();
                $this->dbo->setQuery("DELETE FROM #__jvarcade_contestscore WHERE " . $this->dbo->quoteName('gameid') . " = " . $table->id);
                $this->dbo->execute();
                $this->dbo->setQuery("DELETE FROM #__jvarcade_faves WHERE " . $this->dbo->quoteName('gid') . " = " . $table->id);
                $this->dbo->execute();
                $this->dbo->setQuery("DELETE FROM #__jvarcade_gamedata WHERE " . $this->dbo->quoteName('gameid') . " = " . $table->id);
                $this->dbo->execute();
                $this->dbo->setQuery("DELETE FROM #__jvarcade_lastvisited WHERE " . $this->dbo->quoteName('gameid') . " = " . $table->id);
                $this->dbo->execute();
                $this->dbo->setQuery("DELETE FROM #__jvarcade_ratings WHERE " . $this->dbo->quoteName('gameid') . " = " . $table->id);
                $this->dbo->execute();
                $this->dbo->setQuery("DELETE FROM #__jvarcade_tags WHERE " . $this->dbo->quoteName('gameid') . " = " . $table->id);
                $this->dbo->execute();
                
            }
        }
    }
    
    function onJvaFolderSave($context, $table, $isNew, $data) {
        
        if ($context = 'com_jvarcade.folder') {
            $imgfile = $data['image'];
            $folderid = $table->id;
            if ((int)$folderid && is_array($imgfile) && $imgfile['size'] > 0) {
                
                $imgext = substr($imgfile['name'], strrpos($imgfile['name'], '.'));
                list($imgwith, $imgheight) = @getimagesize($imgfile['tmp_name']);
                
                if (!$uploaderr && $imgfile['error']) {
                    $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR', $imgfile['name']);
                }
                if (!$uploaderr && (strpos($imgfile['type'], 'image') === false)) {
                    $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_NOT_IMAGE', $imgfile['name']);
                }
                if (!$uploaderr && ($imgwith > 64 || $imgheight > 64)) {
                    $uploaderr = JText::_('COM_JVARCADE_UPLOAD_BIGGER_DIMS');
                }
                if (!$uploaderr) {
                    jimport('joomla.filesystem.file');
                    $uploaded = JFile::upload($imgfile['tmp_name'], JVA_IMAGES_INCPATH . 'folders/' . $folderid . $imgext);
                    if ($uploaded) {
                        $this->dbo->setQuery('UPDATE #__jvarcade_folders SET ' .
                            $this->dbo->quoteName('imagename') . ' = ' . $this->dbo->Quote($folderid . $imgext) .
                            ' WHERE ' . $this->dbo->quoteName('id') . ' = ' . (int)$folderid);
                            $this->dbo->execute();
                    } else {
                        $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR_MOVING', $imgfile['name']);
                    }
                }
                if ($uploaderr) {
                    $this->app->enqueueMessage($uploaderr, 'error');
                    $this->app->redirect(Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=folder&layout=edit&id=' . $folderid, false));
                }
            }
        }
    }
    
    function onJvaContestSave($context, $table, $isNew, $data) {
        
        if ($conext = 'com_jvarcade.contest') {
            $imgfile = $data['image'];
            $contestid = $table->id;
            // Process contest image upload
            if ((int)$contestid && is_array($imgfile) && $imgfile['size'] > 0) {
                
                list($imgwith, $imgheight) = @getimagesize($imgfile['tmp_name']);
                
                if (!$uploaderr && $imgfile['error']) {
                    $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR', $imgfile['name']);
                }
                if (!$uploaderr && (strpos($imgfile['type'], 'image') === false)) {
                    $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_NOT_IMAGE', $imgfile['name']);
                }
                if (!$uploaderr && ($imgwith > 150 || $imgheight > 150)) {
                    $uploaderr = JText::_('COM_JVARCADE_UPLOAD_BIGGER_DIMS3');
                }
                if (!$uploaderr) {
                    jimport('joomla.filesystem.file');
                    $uploaded = JFile::upload($imgfile['tmp_name'], JVA_IMAGES_INCPATH . 'contests/' . $contestid . '_' . $imgfile['name']);
                    if ($uploaded) {
                        $this->dbo->setQuery('UPDATE #__jvarcade_contest SET ' .
                            $this->dbo->quoteName('imagename') . ' = ' . $this->dbo->Quote($contestid . '_' . $imgfile['name']) .
                            ' WHERE ' . $this->dbo->quoteName('id') . ' = ' . (int)$contestid);
                            $this->dbo->execute();
                    } else {
                        $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR_MOVING', $imgfile['name']);
                    }
                }
                if ($uploaderr) {
                    $this->app->enqueueMessage($uploaderr, 'error');
                    $this->app->redirect(Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=contest&layout=edit&id=' . $contestid, false));
                }
            }
            
            if ($isNew && $data['published']) {
                $this->dispatcher->trigger('onPUAContestStarted', array($contestid, $data['name'], $data['startdatetime'], $data['enddatetime']));
            }
        }
        
    }
    
    function onJvaContestDelete($context, $table) {
        
        $query = "DELETE FROM #__jvarcade_contestgame WHERE " . $this->dbo->quoteName('id') . " = " . $table->id;
        $this->dbo->setQuery($query);
        
        if ($this->dbo->execute()) {
            $this->dbo->setQuery("DELETE FROM #__jvarcade_contestmember WHERE " . $this->dbo->quoteName('contestid') . " = " . $table->id);
            $this->dbo->execute();
            $this->dbo->setQuery("DELETE FROM #__jvarcade_contestscore WHERE " . $this->dbo->quoteName('contestid') . " = " . $table->id);
            $this->dbo->execute();
            
            $this->dbo->setQuery("SELECT id FROM #__jvarcade_leaderboard WHERE " . $this->dbo->quoteName('contestid') . " = " . $table->id);
            $ids = $this->dbo->loadColumn();
            if (is_array($ids) && count($ids)) {
                $this->dbo->setQuery("DELETE FROM #__jvarcade_leaderboard WHERE " . $this->dbo->quoteName('id') . " = " . $table->id);
                $this->dbo->execute();
            }
        }
    }
    
    function onJvaContentratingSave($context, $table, $isNew, $data) {
        
        if ($conext = 'com_jvarcade.contentrating') {
            $imgfile = $data['image'];
            $contentratingid = $table->id;
            // Process image upload
            if ((int)$contentratingid && is_array($imgfile) && $imgfile['size'] > 0) {
                
                list($imgwith, $imgheight) = @getimagesize($imgfile['tmp_name']);
                
                if (!$uploaderr && $imgfile['error']) {
                    $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR', $imgfile['name']);
                }
                if (!$uploaderr && (strpos($imgfile['type'], 'image') === false)) {
                    $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_NOT_IMAGE', $imgfile['name']);
                }
                if (!$uploaderr && ($imgwith > 150 || $imgheight > 150)) {
                    $uploaderr = JText::_('COM_JVARCADE_UPLOAD_BIGGER_DIMS3');
                }
                if (!$uploaderr) {
                    jimport('joomla.filesystem.file');
                    $uploaded = JFile::upload($imgfile['tmp_name'], JVA_IMAGES_INCPATH . 'contentrating/' . $contentratingid . '_' . $imgfile['name']);
                    if ($uploaded) {
                        $this->dbo->setQuery('UPDATE #__jvarcade_contentrating SET ' .
                            $this->dbo->quoteName('imagename') . ' = ' . $this->dbo->Quote($contentratingid . '_' . $imgfile['name']) .
                            ' WHERE ' . $this->dbo->quoteName('id') . ' = ' . (int)$contentratingid);
                            $this->dbo->execute();
                    } else {
                        $uploaderr = JText::sprintf('COM_JVARCADE_UPLOAD_ERROR_MOVING', $imgfile['name']);
                    }
                }
                if ($uploaderr) {
                    $this->app->enqueueMessage($uploaderr, 'error');
                    $this->app->redirect(Joomla\CMS\Router\Route::_('index.php?option=com_jvarcade&view=contentrating&layout=edit&id=' . $contentratingid, false));
                }
            }
        
        }
    }
}