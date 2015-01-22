use `poll`;

create table `stucourses`(
	`id` int(10) unsigned not null auto_increment primary key,
    `userid` int(10) unsigned null,
    `username` varchar(20) default null,
    `courseid` int(10) unsigned null,
    `coursename` varchar(20) default null
)engine=MyISAM default charset=utf8;

CREATE TABLE `comments`(
	`id` int(10) unsigned NOT NULL auto_increment primary key,
	`teacherid` int(10) unsigned DEFAULT NULL,
	`comment` text NOT NULL
)engine=MyISAM default charset=utf8;

create table `courses`(
	`id` int(10) unsigned not null auto_increment primary key,
    `coursename` varchar(20) default null,
    `teacherid` int(10) unsigned null,
	`teachername` varchar(20) default null
)engine=MyISAM default charset=utf8;