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
    `gender` ENUM('male', 'female', 'other'),
    `day_of_birth` CHAR(2),
    `month_of_birth` CHAR(2),
    `year_of_birth` CHAR(15)
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

/* Table to store groups and informations about them */

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`groups` (
	`id_group` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `group_name` CHAR(60) NOT NULL,
    `created` CHAR(19) NOT NULL,
    `last_active` CHAR(19) NOT NULL
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

/* Table to store members of a particular group */

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`group_members` (
	`id_group` INT UNSIGNED NOT NULL,
    `id_user` INT UNSIGNED NOT NULL,
    `joined` CHAR(19) NOT NULL,
    `rights` ENUM('member', 'admin', 'owner') NOT NULL DEFAULT 'member'
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

/* Table to store informations about group chats, group chat can belong to a particular group,
 but can be also created without affinity to any group.
 One group can own multiple group chats, for example for all members, for adminstartors and owners, and etc. */

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`group_chats` (
	`id_group_chat` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `group_chat_name` CHAR(60) NOT NULL,
    `group_affinity` INT UNSIGNED, 
    `created` CHAR(19) NOT NULL,
    `last_active` CHAR(19) NOT NULL
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

/* Table for storing members of particular group chat */

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`group_chat_members` (
	`id_group_chat` INT UNSIGNED NOT NULL,
    `id_user` INT UNSIGNED NOT NULL,
    `joined` CHAR(19) NOT NULL,
    `rights` ENUM('member', 'admin', 'owner') NOT NULL DEFAULT 'member',
    `last_message_seen` INT UNSIGNED
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

/* Table for storing messages in particular group chats */

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`group_chat_messages` (
	`id_group_chat_message` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_user_sender` INT UNSIGNED NOT NULL,
    `id_group_chat` INT UNSIGNED NOT NULL,
    `message` TEXT NOT NULL,
    `time` CHAR(19) NOT NULL,
    `time_deleted` CHAR(19),
    `status` enum('recorded' , 'deleted') NOT NULL DEFAULT 'recorded'
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


/* Foreign keys */

ALTER TABLE `SocialNetwork`.`friends` ADD FOREIGN KEY (`id_user_1`) REFERENCES `SocialNetwork`.`users`(`id_user`);
ALTER TABLE `SocialNetwork`.`friends` ADD FOREIGN KEY (`id_user_2`) REFERENCES `SocialNetwork`.`users`(`id_user`);

ALTER TABLE `SocialNetwork`.`posts` ADD FOREIGN KEY (`id_user_author`) REFERENCES `SocialNetwork`.`users`(`id_user`);

ALTER TABLE `SocialNetwork`.`messages` ADD FOREIGN KEY (`id_user_sender`) REFERENCES `SocialNetwork`.`users`(`id_user`);
ALTER TABLE `SocialNetwork`.`messages` ADD FOREIGN KEY (`id_user_receiver`) REFERENCES `SocialNetwork`.`users`(`id_user`);

ALTER TABLE `SocialNetwork`.`group_posts` ADD FOREIGN KEY (`id_group`) REFERENCES `SocialNetwrok`.`groups`(`id_group`);
ALTER TABLE `SocialNetwork`.`group_posts` ADD FOREIGN KEY (`id_user_author`) REFERENCES `SocialNetwrok`.`groups`(`id_group`);

ALTER TABLE `SocialNetwork`.`group_members` ADD FOREIGN KEY (`id_group`) REFERENCES `SocialNetwork`.`groups`(`id_group`);
ALTER TABLE `SocialNetwork`.`group_members` ADD FOREIGN KEY (`id_user`) REFERENCES `SocialNetwork`.`users`(`id_user`);

ALTER TABLE `SocialNetwork`.`group_chats` ADD FOREIGN KEY (`group_affinity`) REFERENCES `SocialNetwork`.`groups`(`id_group`);

ALTER TABLE `SocialNetwork`.`group_chat_members` ADD FOREIGN KEY (`id_group_chat`) REFERENCES `SocialNetwork`.`group_chats`(`id_group_chat`);
ALTER TABLE `SocialNetwork`.`group_chat_members` ADD FOREIGN KEY (`id_user`) REFERENCES `SocialNetwork`.`users`(`id_user`);
ALTER TABLE `SocialNetwork`.`group_chat_members` ADD FOREIGN KEY (`last_message_seen`) REFERENCES `SocialNetwork`.`group_chat_messages`(`id_group_chat_message`);

ALTER TABLE `SocialNetwork`.`group_chat_messages` ADD FOREIGN KEY (`id_user_sender`) REFERENCES `SocialNetwork`.`users`(`id_user`);
ALTER TABLE `SocialNetwork`.`group_chat_messages` ADD FOREIGN KEY (`id_group_chat`) REFERENCES `SocialNetwork`.`group_chats`(`id_group_chat`);

