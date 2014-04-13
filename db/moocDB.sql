
DROP TABLE IF EXISTS `Data`;
DROP TABLE IF EXISTS `Item`;
DROP TABLE IF EXISTS `User`;

CREATE TABLE `Item` (
    `id` int(11) NOT NULL auto_increment,
    `item_id` varchar(8) DEFAULT NULL,
    `name` varchar(128) ,
    `image` varchar(128) ,
    `institution` varchar(64) DEFAULT NULL,
    `catagories` varchar(128),
    `language` varchar(16),
    `syllabus` text,
    `about` text,
    `description` text,
    `workload` varchar(64),
    `subtitle` varchar(64),
    `instructors` varchar(128) DEFAULT NULL,
    `background` text,
    `level` tinyint DEFAULT NULL,
    `keywords` varchar(16) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `User` (
    `id` int(11) NOT NULL auto_increment,
    `screen_name` text,
    `age` int,
    `gender` char(1),
    `occupation` varchar(32) DEFAULT NULL,
    `tags` text,
    PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Data` (
    `id` int(11) NOT NULL auto_increment,
    `user_id` int,
    `item_id` int,
    `rating` tinyint DEFAULT 0,
    `timestamp` timestamp,
    PRIMARY KEY (`id`),
    FOREIGN KEY (user_id) REFERENCES User(id),
    FOREIGN KEY (item_id) REFERENCES Item(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

