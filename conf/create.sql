use `poll`;

create table `historyComments`(
	`hcmt_id` int(10) unsigned not null auto_increment primary key,
	`t_id` int(10) unsigned null,
	`comment` text default null
)engine=MyISAM default charset=utf8;