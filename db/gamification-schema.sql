DROP TABLE IF EXISTS `certificate`;
DROP TABLE IF EXISTS `badge`;
DROP TABLE IF EXISTS `user_certificate`;
DROP TABLE IF EXISTS `user_badge`;
DROP TABLE IF EXISTS `gamification_operator`;
DROP TABLE IF EXISTS `certificate_criterion`;
DROP TABLE IF EXISTS `badge_criterion`;
DROP TABLE IF EXISTS `user_certificate_criterion`;
DROP TABLE IF EXISTS `user_badge_criterion`;

CREATE TABLE `certificate` (
  `id` int(11) not null auto_increment primary key,
  `course` int(11) not null,
  `author` int(11) not null,
  `title` varchar(255) not null,
  `description` text,
  `autoassign` tinyint(1) not null default 1,
  `active` tinyint(1) not null default 1,
  `created` datetime,
  `expires` datetime,
  index `certificate_course` (`course`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `badge` (
  `id` int(11) not null auto_increment primary key,
  `course` int(11) not null,
  `author` int(11) not null,
  `title` varchar(255) not null,
  `description` text,
  `autoassign` tinyint(1) not null default 1,
  `active` tinyint(1) not null default 1,
  `created` datetime,
  `expires` datetime,
  index `badge_course` (`course`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `user_certificate` (
  `id` int(11) not null auto_increment primary key,
  `user` int(11) not null,
  `certificate` int(11) not null,
  `created` datetime,
  unique key `user_certificate` (`user`, `certificate`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `user_badge` (
  `id` int(11) not null auto_increment primary key,
  `user` int(11) not null,
  `badge` int(11) not null,
  `created` datetime,
  unique key `user_badge` (`user`, `badge`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `certificate_criterion` (
  `id` int(11) not null auto_increment primary key,
  `certificate` int(11) not null,
  `activity_type` varchar(255),
  `module` int(11),
  `resource` int(11),
  `threshold` decimal(7,2),
  `operator` varchar(20)
) DEFAULT CHARSET=utf8;

CREATE TABLE `badge_criterion` (
  `id` int(11) not null auto_increment primary key,
  `badge` int(11) not null,
  `activity_type` varchar(255),
  `module` int(11),
  `resource` int(11),
  `threshold` decimal(7,2),
  `operator` varchar(20)
) DEFAULT CHARSET=utf8;

CREATE TABLE `user_certificate_criterion` (
  `id` int(11) not null auto_increment primary key,
  `user` int(11) not null,
  `certificate_criterion` int(11) not null,
  `created` datetime,
  unique key `user_certificate_criterion` (`user`, `certificate_criterion`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `user_badge_criterion` (
  `id` int(11) not null auto_increment primary key,
  `user` int(11) not null,
  `badge_criterion` int(11) not null,
  `created` datetime,
  unique key `user_badge_criterion` (`user`, `badge_criterion`)
) DEFAULT CHARSET=utf8;
