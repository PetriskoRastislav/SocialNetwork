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
	`id_users` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` CHAR(255) NOT NULL UNIQUE,
    `name` CHAR(100) NOT NULL,
    `surname` CHAR(100) NOT NULL,
    `password` CHAR(97) NOT NULL,
    `profile_picture` LONGBLOB DEFAULT NULL,
    `cover_picture` LONGBLOB DEFAULT NULL,
    `registered` timestamp NOT NULL,
    `last_active` timestamp NOT NULL
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`friends`(
	`id_user1` INT UNSIGNED NOT NULL,
    `id_user2` INT UNSIGNED NOT NULL
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE friends ADD foreign key (id_user1) references users(`id_users`);
ALTER TABLE friends ADD foreign key (id_user2) references users(`id_users`);
