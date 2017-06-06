INSERT INTO `#__jvarcade_settings` (`optname`,`value`,`group`,`ord`,`type`,`description`) VALUES
			('date_format', 'Y-m-d', 'general', 1, 'text', 'COM_JVARCADE_OPTDESC_DATE_FORMAT'),
			('time_format', 'H:i:s', 'general', 2, 'text', 'COM_JVARCADE_OPTDESC_TIME_FORMAT'),
			('guest_name', 'jVArcadeGuest', 'general', 3, 'text', 'COM_JVARCADE_OPTDESC_GUEST_NAME'),
			('installed_charset', 'UTF-8', 'general', 4, 'text', 'COM_JVARCADE_OPTDESC_INSTALLED_CHARSET'),
			('table_max', '100', 'general', 5, 'text', 'COM_JVARCADE_OPTDESC_TABLE_MAX'),
			('allow_gview', '1', 'general', 6, 'yesno', 'COM_JVARCADE_OPTDESC_ALLOW_GVIEW'),
			('allow_gplay', '1', 'general', 7, 'yesno', 'COM_JVARCADE_OPTDESC_ALLOW_GPLAY'),
			('allow_gsave', '1', 'general', 8, 'yesno', 'COM_JVARCADE_OPTDESC_ALLOW_GSAVE'),
			('leaderboard', '1', 'general', 9, 'yesno', 'COM_JVARCADE_OPTDESC_LEADERBOARD'),
			('faves', '1', 'general', 10, 'yesno', 'COM_JVARCADE_OPTDESC_FAVES'),
			('display_onlysingleurl', '1', 'general', 11, 'yesno', 'COM_JVARCADE_OPTDESC_DISPLAY_ONLYSINGLEURL'),
			('tagcloud', '1', 'general', 12, 'yesno', 'COM_JVARCADE_OPTDESC_TAGCLOUD'),
			('TagPerms', '0,1,2,3,4,5,6,7,8,9', 'general', 13, 'multiselect', 'COM_JVARCADE_OPTDESC_TAGPERMS'),
			('TagLimit', '0', 'general', 14, 'text', 'COM_JVARCADE_OPTDESC_TAGLIMIT'),
			('updatelb', '15', 'general', 15, 'text', 'COM_JVARCADE_OPTDESC_UPDATELB'),
			('max_faves', '10', 'general', 16, 'text', 'COM_JVARCADE_OPTDESC_MAX_FAVES'),
			('contentrating', '1', 'general', 17, 'yesno', 'COM_JVARCADE_OPTDESC_CONTENTRATING'),
			('test_popup', '0', 'general', 18, 'yesno', 'COM_JVARCADE_OPTDESC_TEST_POPUP'),
			('window', '1', 'general', 19, 'select', 'COM_JVARCADE_OPTDESC_WINDOW'),
			('enable_dload', '1', 'general', 20, 'yesno', 'COM_JVARCADE_OPTDESC_ENABLE_DLOAD'),
			('DloadPerms', '0,1,2,3,4,5,6,7,8,9', 'general', 21, 'multiselect', 'COM_JVARCADE_OPTDESC_DLOADPERMS'),
			('comments', '0', 'integration', 1, 'radio', 'COM_JVARCADE_OPTDESC_COMMENTS'),
			('scorelink', '0', 'integration', 2, 'radio', 'COM_JVARCADE_OPTDESC_SCORELINK'),
			('show_avatar', '1', 'integration', 3, 'yesno', 'COM_JVARCADE_OPTDESC_SHOW_AVATAR'),
			('communitybuilder_itemid', '7', 'integration', 5, 'text', 'COM_JVARCADE_OPTDESC_COMMUNITYBUILDER_ITEMID'),
			('aup_itemid', '8', 'integration', 6, 'text', 'COM_JVARCADE_OPTDESC_AUP_ITEMID'),
			('title', 'jVArcade', 'frontend', 1, 'text', 'COM_JVARCADE_OPTDESC_TITLE'),
			('scoreundergame', '1', 'frontend', 2, 'yesno', 'COM_JVARCADE_OPTDESC_SCOREUNDERGAME'),
			('foldergames', '1', 'frontend', 3, 'yesno', 'COM_JVARCADE_OPTDESC_FOLDERGAMES'),
			('rate', '1', 'frontend', 4, 'yesno', 'COM_JVARCADE_OPTDESC_RATE'),
			('showstats', '1', 'frontend', 5, 'yesno', 'COM_JVARCADE_OPTDESC_SHOWSTATS'),
			('showscoresinfolders', '1', 'frontend', 6, 'yesno', 'COM_JVARCADE_OPTDESC_SHOWSCORESINFOLDERS'),
			('homepage_view', 'default', 'frontend', 7, 'select', 'COM_JVARCADE_OPTDESC_HOMEPAGE_VIEW'),
			('homepage_order', '1', 'frontend', 8, 'select', 'COM_JVARCADE_OPTDESC_HOMEPAGE_ORDER'),
			('homepage_order_dir', '1', 'frontend', 9, 'select', 'COM_JVARCADE_OPTDESC_HOMEPAGE_ORDER_DIR'),
			('foldercols', '1', 'frontend', 10, 'text', 'COM_JVARCADE_OPTDESC_FOLDERCOLS'),
			('GamesPerPage', '2', 'frontend', 11, 'text', 'COM_JVARCADE_OPTDESC_GAMESPERPAGE'),
			('display_max', '20', 'frontend', 12, 'text', 'COM_JVARCADE_OPTDESC_DISPLAY_MAX'),
			('bookmarks', '1', 'frontend', 13, 'yesno', 'COM_JVARCADE_OPTDESC_BOOKMARKS'),
			('specialfolders', '1', 'frontend', 14, 'yesno', 'COM_JVARCADE_OPTDESC_SPECIALFOLDERS'),
			('report', '1', 'frontend', 15, 'yesno', 'COM_JVARCADE_OPTDESC_REPORT'),
			('roundcorners', '1', 'frontend', 16, 'yesno', 'COM_JVARCADE_OPTDESC_ROUNDCORNERS'),
			('randgamecount', '3', 'frontend', 17, 'text', 'COM_JVARCADE_OPTDESC_RANDGAMECOUNT'),
			('template', 'default', 'frontend', 18, 'select', 'COM_JVARCADE_OPTDESC_TEMPLATE'),
			('truncate_title', '50', 'frontend', 19, 'text', 'COM_JVARCADE_OPTDESC_TRUNCATE_TITLE'),
			('alias_folder', '', 'frontend', 20, 'text', 'COM_JVARCADE_OPTDESC_ALIAS_FOLDER'),
			('alias_popular', '', 'frontend', 21, 'text', 'COM_JVARCADE_OPTDESC_ALIAS_POPULAR'),
			('alias_newest', '', 'frontend', 22, 'text', 'COM_JVARCADE_OPTDESC_ALIAS_NEWEST'),
			('alias_contests', '', 'frontend', 23, 'text', 'COM_JVARCADE_OPTDESC_ALIAS_CONTESTS'),
			('alias_leaderboard', '', 'frontend', 24, 'text', 'COM_JVARCADE_OPTDESC_ALIAS_LEADERBOARD'),
			('alias_favourite', '', 'frontend', 25, 'text', 'COM_JVARCADE_OPTDESC_ALIAS_FAVOURITE'),
			('alias_random', '', 'frontend', 26, 'text', 'COM_JVARCADE_OPTDESC_ALIAS_RANDOM'),
			('show_usernames', '1', 'frontend', 27, 'yesno', 'COM_JVARCADE_OPTDESC_SHOW_USERNAMES'),
			('load_jquery', '1', 'frontend', 28, 'yesno', 'COM_JVARCADE_OPTDESC_LOAD_JQUERY');
			
INSERT INTO `#__jvarcade_folders` (`name`,`description`,`published`,`imagename`,`viewpermissions`) VALUES 
	('Classic Games','This is a sample folder.  You can use it if you like, or remove it.','1','folder.gif','0,1,2,3,4,5,6,7,8,9');
	
INSERT INTO `#__jvarcade_games` (`gamename`,`title`,`height`,`width`,`description`,`numplayed`,`imagename`,`filename`,`background`,`published`,`reverse_score`,`folderid`) VALUES 
	('neave_frogger', 'Frogger', 484, 448, 'Enter your description for Neave Frogger here.', 0, 'neave_frogger.png', 'neave_frogger.swf', '#000000', 1, 0, 1),
	('Neave_snake', 'Snake', 400, 500, 'Enter your description for Neave_Snake here.', 0, 'neave_snake.gif', 'neave_snake.swf', '#FFFFFF', 1, 0, 1),
	('Invaders', 'Invaders', 400, 500, 'Enter you Invaders description here.', 0, 'invaders.gif', 'invaders.swf', '#FFFFFF', 1, 0, 1),
	('Simon', 'Simon', 400, 500, 'Enter your Simon description here.', 0, 'simon.gif', 'simon.swf', '#000000', 1, 0, 1);
	
INSERT INTO `#__jvarcade_contentrating` (`name`,`description`,`warningrequired`,`imagename`,`published`) VALUES 
	('Everyone','This game is suitable for players of all ages.',0,'e.png','1'),
	('Teen','This game is suitable for players above age 13.',0,'t.png','1'),
	('Mature','This game is suitable for players above age 18.',1,'m.png','1');