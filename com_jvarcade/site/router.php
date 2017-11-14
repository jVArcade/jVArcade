<?php
/**
 * @package		jVArcade
 * @copyright   Copyright (C) 2017 jVArcade.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv3 or later
 * @link		https://jvarcade.com
 */



// no direct access
defined('_JEXEC') or die;

$JVersion = new Joomla\CMS\Version();
$version = $JVersion->getShortVersion();
 
if (version_compare($version, '3.3.0', 'lt')) {
	interface JComponentRouterInterface {
		public function build(&$query);
		public function parse(&$segments);
	}
	function JvarcadeBuildRoute(&$query) {
		$router = new JvarcadeRouter;
		$query = $router->preprocess($query);
		return $router->build($query);
	}
	function JvarcadeParseRoute($segments) {
		$router = new JvarcadeRouter;
		return $router->parse($segments);
	}
 }
 

// TODO: may be extend the new JComponentRouterBasic class in 5.3.0

class JvarcadeRouter implements JComponentRouterInterface {
	protected $dbo;
	protected $app;
	protected $config;
	
	public function __construct() {
		$this->dbo = Joomla\CMS\Factory::getDBO();
		$this->app = Joomla\CMS\Factory::getApplication();
		$this->config = Joomla\CMS\Component\ComponentHelper::getParams('com_jvarcade');
	}
	
	public function build(&$query) {
		$segments = array();
		$task = '';
		$aliases = $this->getAlias();
		
		if(isset($query['view'])) {
			$task = $query['view'];
			$segments[] = (is_array($aliases) && count($aliases) && isset($aliases[$task])) ? $aliases[$task] : $query['view'];
			unset($query['view']);
		}
		
		if (($task == 'game' || $task == 'scores' || $task == 'contestdetail' || $task == 'folder') && isset($query['id'])) {
			$id = (int)$query['id'];
			switch($task) {
				case 'game':
				case 'scores':
					$sql = 'SELECT title from #__jvarcade_games WHERE id = ' . $id;
					break;
				case 'contestdetail':
					$sql = 'SELECT name from #__jvarcade_contest WHERE id = ' . $id;
					break;
				case 'folder':
					$sql = 'SELECT coalesce(NULLIF( alias,\'\'), name) as name from #__jvarcade_folders WHERE id = ' . $id;
					break;
			}
			$this->dbo->setQuery($sql);
			$title = $this->dbo->loadResult();
			$title = $title ? $this->makeAlias($title) : '';
			$title = $title ? 'id:' . $id . ':' . $title : 'id:' . $id ;
			$segments[] = $title;
			unset($query['id']);
		}
		
		if (($task == 'profile') && isset($query['uid'])) {
			$id = (int)$query['uid'];
			$sql = 'SELECT username from #__users WHERE id =' . $id;
			$this->dbo->setQuery($sql);
			$name = $this->dbo->loadResult();
			$name = $name ? $this->makeAlias($name) : '';
			$name = $name ? 'uid:' . $id . ':' . $name : 'uid:' . $id;
			$segments[] = $name;
			unset($query['uid']);
		}
		
		if (($task == 'favourite') && isset($query['uid'])) {
		    $id = (int)$query['uid'];
		    $sql = 'SELECT username from #__users WHERE id =' . $id;
		    $this->dbo->setQuery($sql);
		    $name = $this->dbo->loadResult();
		    $name = $name ? $this->makeAlias($name) : '';
		    $name = $name ? 'uid:' . $id . ':' . $name : 'uid:' . $id;
		    $segments[] = $name;
		    unset($query['uid']);
		}
		
		if ($task == 'showtag') {
			$tag = isset($query['tag']) ? (string)$query['tag'] : '';
			$this->dbo->setQuery('SELECT id from #__jvarcade_tags WHERE tag = ' . $this->dbo->Quote($tag));
			$tag_id = (int)$this->dbo->loadResult();
			$tag = $tag ? $this->makeAlias($tag) : '';
			$tag = 'tag:' . $tag_id . ':' . $tag;
			$segments[] = $tag;
			unset($query['tag']);
		}
		
		if(isset($query['start'])) {
			$segments[] = 'start:' . $query['start'];
			unset($query['start']);
		}
		
		if(isset($query['filter_order'])) {
			$segments[] = 'ord:' . $query['filter_order'];
			unset($query['filter_order']);
		}
		
		if(isset($query['filter_order_Dir'])) {
			$segments[] = 'dir:' . $query['filter_order_Dir'];
			unset($query['filter_order_Dir']);
		}
		
		unset($query['view']);
		return $segments;
	}

	public function parse(&$segments) {
		$vars = array();
		$segment_id = '';
		$segment_uid = '';
		$segment_tag = '';
		$segment_start = '';
		$segment_ord = '';
		$segment_dir = '';
		$aliases = $this->getAlias();
		$aliases = array_flip($aliases);
		
		if (isset($segments[0])) {
			// the first case is when we access a joomla menu and the first segment is not the task
		    if (strpos($segments[0], 'id:') !== false || strpos($segments[0], 'uid:') !== false || strpos($segments[0], 'tag:') !== false || strpos($segments[0], 'start:') !== false || strpos($segments[0], 'ord:') !== false || strpos($segments[0], 'dir:') !== false) {
				$vars['view'] = $this->getMenuQuery('view', 'home');
			} else { 
				$vars['view'] = (is_array($aliases) && count($aliases) && isset($aliases[$segments[0]])) ? $aliases[$segments[0]] : $segments[0];
			}
		}
		
		foreach($segments as $segment) {
			if (strpos($segment, 'id:') !== false) {
				$segment_id = $segment;
			}
			if (strpos($segment, 'uid:') !== false) {
			    $segment_uid = $segment;
			}
			if (strpos($segment, 'tag:') !== false) {
				$segment_tag = $segment;
			}
			if (strpos($segment, 'start:') !== false) {
				$segment_start = $segment;
			}
			if (strpos($segment, 'ord:') !== false) {
				$segment_ord = $segment;
			}
			if (strpos($segment, 'dir:') !== false) {
				$segment_dir = $segment;
			}
		}
		
		// if we access the page through a menu - we have to try to get the id from the menu link
		if(!$segment_id) $segment_id = 'id:' . $this->getMenuQuery('id', 0);

		if ($segment_id) {
			$id = explode(':', $segment_id);
			$vars['id'] = (int)$id[1];
		}
		if ($segment_uid) {
		    $id = explode(':', $segment_uid);
		    $vars['uid'] = (int)$id[1];
		}

		if ($segment_tag) {
			$tag = explode(':', $segment_tag);
			$tag_id = (int)$tag[1];
			$this->dbo->setQuery('SELECT tag from #__jvarcade_tags WHERE id = ' . (int)$tag_id);
			$tag_name = $this->dbo->loadResult();
			$vars['tag'] = $tag_name;
		}

		if ($segment_start) {
			$start = explode(':', $segment_start);
			$vars['limitstart'] = (int)$start[1];
		}

		if ($segment_ord) {
			$ord = explode(':', $segment_ord);
			$vars['filter_order'] = $ord[1];
		}

		if ($segment_dir) {
			$dir = explode(':', $segment_dir);
			$vars['filter_order_Dir'] = $dir[1];
		}

		return $vars;
	}
	
	public function preprocess($query) {
		return $query;
	}

	public function getMenuQuery($var, $def) {
		$menus = $this->app->getMenu();
		$menu = $menus->getActive();
		$query = is_object($menu) ? $menu->query : array();
		return ( (is_array($query) && count($query) && isset($query[$var])) ? $query[$var] : $def);
	}

	public function getAlias() {
		static $aliases;
		if (is_null($aliases) || !is_array($aliases) || !count($aliases)) {
			$aliases = array();
			$results = array(
			    'alias_folder' => $this->config->get('alias_folder'),
			    'alias_leaderboard' => $this->config->get('alias_leaderboard'),
			    'alias_popular' => $this->config->get('alias_popular'),
			    'alias_newest' => $this->config->get('alias_newest'),
			    'alias_contests' => $this->config->get('alias_contests'),
			    'alias_favourite' => $this->config->get('alias_favourtie'),
			    'alias_random' => $this->config->get('alias_random')
			);
			foreach($results as $result['optname'] => $result['value']) {
				if (isset($result['value']) && $result['value']) {
					$aliases[str_replace('alias_', '', $result['optname'])] = $this->makeAlias($result['value']);
				}
			}
		}
		return $aliases;
	}

	public function makeAlias($str) {
		return str_replace(array('-', ' '), array('', '-'), trim($str));
	}
}

