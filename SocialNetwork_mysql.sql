/* some service commands */

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET GLOBAL time_zone = '+01:00';

/* Creation of database */

CREATE SCHEMA IF NOT EXISTS `SocialNetwork` DEFAULT CHARSET utf8;
USE `SocialNetwork`;

/* Creation of user for accessing from php scripts,
   granting privileges for insert, select, update and delete
   rows from database
 */

GRANT SELECT, INSERT, UPDATE, DELETE
ON SocialNetwork.*
TO WebUser@localhost IDENTIFIED BY 'SN13wEb19-20';

/* Creation of tables */

/* Table for storing users and information about them */

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`users` (
	`id_user` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` CHAR(100) NOT NULL UNIQUE,
    `name` CHAR(40) NOT NULL,
    `surname` CHAR(40) NOT NULL,
    `password` CHAR(97) NOT NULL,
    `registered` CHAR(19) NOT NULL,
    `last_active` CHAR(19) NOT NULL,
    `color_mode` ENUM('dark', 'light') DEFAULT 'dark' NOT NULL,
    `profile_picture` CHAR(128),
    `bio` TEXT,
    `location` CHAR(100),
    `gender` ENUM('male', 'female', 'other') DEFAULT 'other' NOT NULL,
    `day_of_birth` CHAR(2),
    `month_of_birth` CHAR(2),
    `year_of_birth` CHAR(4)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

/* Table to store friend relationships between users */

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`friends` (
	`id_user_1` INT UNSIGNED NOT NULL,
    `id_user_2` INT UNSIGNED NOT NULL,
    `time` CHAR(19) NOT NULL
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

/* Table to store messages between two users */

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`messages` (
	`id_message` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`id_user_sender` INT UNSIGNED NOT NULL,
    `id_user_receiver` INT UNSIGNED NOT NULL,
    `message` TEXT NOT NULL,
    `time_sent` CHAR(19) NOT NULL,
    `time_seen` CHAR(19),
    `time_deleted` CHAR(19),
    `status` enum('seen', 'unseen', 'deleted') NOT NULL DEFAULT 'unseen'
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


/* Foreign keys */

ALTER TABLE `SocialNetwork`.`friends` ADD FOREIGN KEY (`id_user_1`) REFERENCES `SocialNetwork`.`users`(`id_user`);
ALTER TABLE `SocialNetwork`.`friends` ADD FOREIGN KEY (`id_user_2`) REFERENCES `SocialNetwork`.`users`(`id_user`);

ALTER TABLE `SocialNetwork`.`messages` ADD FOREIGN KEY (`id_user_sender`) REFERENCES `SocialNetwork`.`users`(`id_user`);
ALTER TABLE `SocialNetwork`.`messages` ADD FOREIGN KEY (`id_user_receiver`) REFERENCES `SocialNetwork`.`users`(`id_user`);

