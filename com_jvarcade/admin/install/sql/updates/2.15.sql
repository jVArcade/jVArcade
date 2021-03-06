DROP TABLE IF EXISTS `#__jvarcade_achievements`;

ALTER TABLE `#__jvarcade_games` DROP `gsafe`;

DELETE FROM `#__extensions` WHERE `element` = 'pkg_jvarcade';

DELETE FROM `#__jvarcade_settings` WHERE `optname` = 'load_jquery';

DELETE FROM `#__jvarcade_settings` WHERE `optname` = 'window';

DELETE FROM `#__jvarcade_settings` WHERE `optname` = 'test_popup';

UPDATE `#__extensions` SET `package_id` = 0 WHERE `type` = 'plugin' AND `folder` = 'jvarcade';

UPDATE `#__extensions` SET `package_id` = 0 WHERE `type` = 'plugin' AND `element` = 'jvarcade';

UPDATE `#__extensions` SET `package_id` = 0 WHERE `type` = 'component' AND `element` = 'com_jvarcade';
