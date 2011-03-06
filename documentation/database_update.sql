
/* Run the following commands in your phpmyAdmin SQL console */

/* Update the database from v3 to XT */
/* --------------------------------- */

/* Add a year field to outlets */
ALTER TABLE  `outlets` ADD  `saison_year` INT( 4 ) NOT NULL AFTER  `saison_end`;
ALTER TABLE  `outlets` ADD  `passerby_max_pax` INT( 12 ) NOT NULL;
ALTER TABLE  `outlets` CHANGE  `avg_duration`  `avg_duration` VARCHAR( 5 ) NOT NULL;
ALTER TABLE  `maitre` ADD  `outlet_child_passer_max_pax` INT( 12 ) NOT NULL;

INSERT INTO `l16n` (`id`, `needle`, `en`, `de`, `fr`, `es`, `nl`, `dk`, `se`, `it`, `fi`, `no`, `pl`, `tr`) VALUES 
(NULL, '_already_user_1', 'The unsername', 'Den Benutzername', 'The unsername', 'The unsername', 'The unsername', 'The unsername', 'The unsername', 'The unsername', 'The unsername', 'The unsername', 'The unsername', 'The unsername'), 
(NULL, '_already_user_2', 'does already exist.', 'gibt es bereits.', 'does already exist.', 'does already exist.', 'does already exist.', 'does already exist.', 'does already exist.', 'does already exist.', 'does already exist.', 'does already exist.', 'does already exist.', 'does already exist.');

/* Update the database from XT 0.1730 to > XT 0.1731 */
/* ------------------------------------------------- */

ALTER TABLE `properties` ADD `logo_filename` VARCHAR( 255 ) NOT NULL ,
ADD `status` VARCHAR( 10 ) NOT NULL DEFAULT 'active'