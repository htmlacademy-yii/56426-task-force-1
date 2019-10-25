create database `taskforce` character set `utf8` collate `utf8_general_ci`;

use `taskforce`;

create table `city` (
	`id` serial primary key,
	`name` varchar(255) not null
) engine=innodb default charset=utf8;

create table `user` (
	`id` serial primary key,
	`email` varchar(255) not null unique,
	`password` varchar(255) not null,
	`name` varchar(255) not null,
	`city` bigint default null references `city`(`id`),
	`address` varchar(255) default null,
	`birthday` date default null,
	`info` varchar(255) default null,
	`phone` varchar(255) default null,
	`skype` varchar(255) default null,
	`messenger` varchar(255),
	`newmessage` bool not null default true,
	`taskaction` bool not null default true,
	`newresponse` bool not null default true,
	`showcontacts` bool not null default true
) engine=innodb default charset=utf8;

create table `spec` (
	`id` serial primary key,
	`name` varchar(255) not null
) engine=innodb default charset=utf8;

create table `userspec` (
	`id` serial primary key,
	`user` bigint not null references `user`(`id`),
	`spec` bigint not null references `spec`(`id`)
) engine=innodb default charset=utf8;

create table `category` (
	`id` serial primary key,
	`name` varchar(255) not null
) engine=innodb default charset=utf8;

create table `task` (
	`id` serial primary key,
	`user` bigint not null references `user`(`id`),
	`description` varchar(255) not null,
	`details` varchar(255) not null,
	`category` bigint not null references `category`(`id`),
	`location` varchar(255) default null,
	`budget` int unsigned default null,
	`deadline` date default null
) engine=innodb default charset=utf8;

create table `response` (
	`id` serial primary key,
	`task` bigint not null references `task`(`id`),
	`user` bigint not null references `user`(`id`),
	`price` int unsigned default null,
	`comment` varchar(255) default null,
	`rating` tinyint unsigned default null,
	`iscompleted` boolean not null default false
) engine=innodb default charset=utf8;

create table `chat` (
	`id` serial primary key,
	`task` bigint not null references `task`(`id`),
	`user` bigint not null references `user`(`id`),
	`time` datetime not null,
	`message` varchar(255) not null
) engine=innodb default charset=utf8;

create table `attachment` (
	`id` serial primary key,
	`task` bigint not null references `task`(`id`),
	`file` varchar(255) not null
) engine=innodb default charset=utf8;
