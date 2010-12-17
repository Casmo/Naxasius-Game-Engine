-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `actions_conversations`
--

CREATE TABLE IF NOT EXISTS `actions_conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('getquest','completequest','getitem','lostitem','getstat','loststat') NOT NULL,
  `target_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `actions_obstacles`
--

CREATE TABLE IF NOT EXISTS `actions_obstacles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('getquest','completequest','getitem','lostitem','getstat','loststat') NOT NULL,
  `target_id` int(11) NOT NULL,
  `areas_obstacle_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `map_id` int(11) NOT NULL,
  `tile_id` int(11) NOT NULL,
  `access` tinyint(1) NOT NULL,
  `restriction` enum('none','up','right','left','down') NOT NULL DEFAULT 'none',
  `travel_to_quest_id` int(11) NOT NULL DEFAULT '0' COMMENT 'This quest is needed to go to travel_to',
  `travel_to` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `areas_mobs`
--

CREATE TABLE IF NOT EXISTS `areas_mobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) NOT NULL,
  `mob_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `spawn_time` int(10) NOT NULL,
  `last_killed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `kill_limit` int(10) NOT NULL,
  `in_battle` tinyint(1) NOT NULL DEFAULT '0',
  `player_only` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `areas_npcs`
--

CREATE TABLE IF NOT EXISTS `areas_npcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(75) NOT NULL,
  `area_id` int(11) NOT NULL,
  `npc_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `areas_obstacles`
--

CREATE TABLE IF NOT EXISTS `areas_obstacles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) NOT NULL,
  `obstacle_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `areas_obstacles_items`
--

CREATE TABLE IF NOT EXISTS `areas_obstacles_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areas_obstacle_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `spawn_time` int(11) NOT NULL,
  `max_drop` int(11) NOT NULL,
  `player_only` tinyint(1) NOT NULL,
  `quest_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE IF NOT EXISTS `avatars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `image_map` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bags`
--

CREATE TABLE IF NOT EXISTS `bags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `index` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `image` varchar(50) NOT NULL DEFAULT '',
  `money` int(10) NOT NULL DEFAULT '0' COMMENT 'Calculated to copper, silver, gold',
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `loggedin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `avatar_id` int(11) NOT NULL DEFAULT '1',
  `last_move` enum('down','up','left','right') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `characters_quests`
--

CREATE TABLE IF NOT EXISTS `characters_quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quest_id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `completed` enum('yes','no','finished') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `characters_stats`
--

CREATE TABLE IF NOT EXISTS `characters_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `stat_id` int(11) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE IF NOT EXISTS `chats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('general','trade','combat','map','private','system') NOT NULL DEFAULT 'general',
  `character_id_from` int(11) NOT NULL,
  `character_id_to` int(11) NOT NULL,
  `message` varchar(150) NOT NULL,
  `display` enum('yes','no') NOT NULL DEFAULT 'no' COMMENT 'Display to messagebox in ui. Will set to ''no'' after display',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE IF NOT EXISTS `conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `conversation_id` int(11) NOT NULL COMMENT 'This Conversation is needed',
  `quest_id` int(11) NOT NULL COMMENT 'This quest is needed (finished)',
  `conversation_goto` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `npc_id` int(11) NOT NULL,
  `icon` varchar(75) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conversations_quests`
--

CREATE TABLE IF NOT EXISTS `conversations_quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `completed` enum('yes','no','finished','all') NOT NULL,
  `comparison` enum('is','isnot') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `drops`
--

CREATE TABLE IF NOT EXISTS `drops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `areas_obstacle_item_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(75) NOT NULL DEFAULT '',
  `order` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `type` enum('tile','item','obstacle') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups_obstacles`
--

CREATE TABLE IF NOT EXISTS `groups_obstacles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `obstacle_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups_tiles`
--

CREATE TABLE IF NOT EXISTS `groups_tiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `tile_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE IF NOT EXISTS `inventories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `bag_id` int(11) NOT NULL,
  `index` tinyint(2) NOT NULL,
  `equiped` enum('none','mainhand','onehand','twohand','offhand','head','shoulders','hands','feets','legs','neck','ring','chest','wrist','belt') NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quality` enum('trash','normal','good','rare','epic','legendary') NOT NULL,
  `type` enum('none','quest','reagent','item','consumable','bag') NOT NULL,
  `slot` enum('none','mainhand','onehand','twohand','offhand','head','shoulders','hands','feets','legs','neck','ring','chest','wrist','belt') NOT NULL,
  `unique` int(11) NOT NULL COMMENT 'Maximum numbers of items per character',
  `stackable` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'How many in one bag slot?',
  `character_id` int(11) NOT NULL DEFAULT '0' COMMENT 'First looted by this character',
  `discovered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items_mobs`
--

CREATE TABLE IF NOT EXISTS `items_mobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `mob_id` int(11) NOT NULL DEFAULT '0',
  `quest_id` int(11) NOT NULL DEFAULT '0',
  `chance` int(5) NOT NULL DEFAULT '50000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items_quests`
--

CREATE TABLE IF NOT EXISTS `items_quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `type` enum('reward','needed') NOT NULL,
  `group_number` int(11) NOT NULL COMMENT 'Can be used to choose a reward between the same group number',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items_stats`
--

CREATE TABLE IF NOT EXISTS `items_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `stat_id` int(11) NOT NULL,
  `value` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kills`
--

CREATE TABLE IF NOT EXISTS `kills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL DEFAULT '0',
  `target_id` int(11) NOT NULL DEFAULT '0' COMMENT 'This is areas_mobs.id or characters.id',
  `mob_id` int(11) NOT NULL DEFAULT '0',
  `type` enum('mob','character') NOT NULL DEFAULT 'mob',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `npc_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `loots`
--

CREATE TABLE IF NOT EXISTS `loots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) NOT NULL DEFAULT '0',
  `mob_id` int(11) NOT NULL DEFAULT '0',
  `party_id` int(11) NOT NULL DEFAULT '0',
  `character_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `looted` enum('yes','no') NOT NULL DEFAULT 'no',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `maps`
--

CREATE TABLE IF NOT EXISTS `maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `subname` varchar(50) NOT NULL,
  `battle_system` enum('pve','pvp','ffa','faction','guild','race') NOT NULL DEFAULT 'pve',
  `image` varchar(75) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mobs`
--

CREATE TABLE IF NOT EXISTS `mobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `level` int(11) NOT NULL,
  `icon` varchar(40) NOT NULL,
  `image` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mobs_quests`
--

CREATE TABLE IF NOT EXISTS `mobs_quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mob_id` int(11) NOT NULL DEFAULT '0',
  `quest_id` int(11) NOT NULL DEFAULT '0',
  `amount` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mobs_stats`
--

CREATE TABLE IF NOT EXISTS `mobs_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mob_id` int(11) NOT NULL,
  `stat_id` int(11) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(75) NOT NULL,
  `summary` text NOT NULL,
  `message` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `image_title` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `npcs`
--

CREATE TABLE IF NOT EXISTS `npcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(75) NOT NULL,
  `image` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `obstacles`
--

CREATE TABLE IF NOT EXISTS `obstacles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  `image` varchar(50) NOT NULL,
  `sha1` varchar(40) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `obstacles_sheets`
--

CREATE TABLE IF NOT EXISTS `obstacles_sheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sheet_id` int(11) NOT NULL DEFAULT '0',
  `obstacle_id` int(11) NOT NULL DEFAULT '0',
  `position_x` int(10) NOT NULL DEFAULT '0',
  `position_y` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `order` int(10) NOT NULL,
  `menu` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE IF NOT EXISTS `parties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(75) NOT NULL,
  `image` varchar(75) NOT NULL,
  `link` varchar(150) NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE IF NOT EXISTS `quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description_full` text NOT NULL,
  `description_summary` text NOT NULL,
  `removable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quests_stats`
--

CREATE TABLE IF NOT EXISTS `quests_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quest_id` int(11) NOT NULL,
  `stat_id` int(11) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('news','topic') NOT NULL DEFAULT 'news',
  `message` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `screenshots`
--

CREATE TABLE IF NOT EXISTS `screenshots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(75) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(75) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sheets`
--

CREATE TABLE IF NOT EXISTS `sheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `type` enum('obstacle','tile') NOT NULL DEFAULT 'obstacle',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(25) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`id`, `key`, `name`) VALUES
(1, 'hp', 'Health'),
(2, 'mp', 'Mana'),
(3, 'armor', 'Armor'),
(4, 'strength', 'Strength'),
(5, 'min_damage', 'Min damage'),
(6, 'max_damage', 'Max damage'),
(7, 'slots', 'Slots'),
(8, 'xp', 'Experience'),
(9, 'karma', 'Charisma');

-- --------------------------------------------------------

--
-- Table structure for table `stats_types`
--

CREATE TABLE IF NOT EXISTS `stats_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `stat_id` int(11) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `texts`
--

CREATE TABLE IF NOT EXISTS `texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `image_title` varchar(100) NOT NULL,
  `page_id` int(11) NOT NULL,
  `order` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tiles`
--

CREATE TABLE IF NOT EXISTS `tiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  `image` varchar(75) NOT NULL,
  `group_id` int(11) NOT NULL,
  `sha1` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(75) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `activation_code` varchar(25) NOT NULL,
  `created` datetime NOT NULL,
  `role` enum('player','admin') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
