INSERT INTO `#__jvarcade_folders` (`name`,`description`,`published`,`imagename`,`viewpermissions`) VALUES 
	('Classic Games','This is a sample folder.  You can use it if you like, or remove it.','1','folder.gif','1,2,3,4,5,6,7,8,9');
	
INSERT INTO `#__jvarcade_games` (`gamename`,`title`,`height`,`width`,`description`,`numplayed`,`imagename`,`filename`,`background`,`published`,`reverse_score`,`folderid`) VALUES 
	('neave_frogger', 'Frogger', 484, 448, 'Enter your description for Neave Frogger here.', 0, 'neave_frogger.png', 'neave_frogger.swf', '#000000', 1, 0, 1),
	('Neave_snake', 'Snake', 400, 500, 'Enter your description for Neave_Snake here.', 0, 'neave_snake.gif', 'neave_snake.swf', '#FFFFFF', 1, 0, 1),
	('Invaders', 'Invaders', 400, 500, 'Enter you Invaders description here.', 0, 'invaders.gif', 'invaders.swf', '#FFFFFF', 1, 0, 1),
	('Simon', 'Simon', 400, 500, 'Enter your Simon description here.', 0, 'simon.gif', 'simon.swf', '#000000', 1, 0, 1);
	
INSERT INTO `#__jvarcade_contentrating` (`name`,`description`,`warningrequired`,`imagename`,`published`) VALUES 
	('Everyone','This game is suitable for players of all ages.',0,'e.png','1'),
	('Teen','This game is suitable for players above age 13.',0,'t.png','1'),
	('Mature','This game is suitable for players above age 18.',1,'m.png','1');