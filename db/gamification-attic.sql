DROP TABLE IF EXISTS `gamification_operator`;


CREATE TABLE `gamification_operator` (
  `id` smallint(6) not null auto_increment primary key,
  `title` varchar(255) not null,
  `description` text,
  `eq` tinyint(1) not null default 0,
  `lt` tinyint(1) not null default 0,
  `gt` tinyint(1) not null default 0,
  `let` tinyint(1) not null default 0,
  `get` tinyint(1) not null default 0,
  `sum` tinyint(1) not null default 0,
  `avg` tinyint(1) not null default 0
) DEFAULT CHARSET=utf8;


-- τελεστές
insert into `gamification_operator` (`id`, `title`, `eq`) values (1, 'equal', 1);
insert into `gamification_operator` (`id`, `title`, `lt`) values (2, 'less than', 1);
insert into `gamification_operator` (`id`, `title`, `gt`) values (3, 'greater than', 1);
insert into `gamification_operator` (`id`, `title`, `let`) values (4, 'less or equal than', 1);
insert into `gamification_operator` (`id`, `title`, `get`) values (5, 'greater or equal than', 1);

