create database `56426_task_force_1` character set `utf8` collate `utf8_general_ci`;

use `56426_task_force_1`;

create table `city` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`name` varchar(64) not null unique comment 'Название города',
	`created_at` timestamp not null default current_timestamp comment 'Время создания записи'
) engine `innodb` character set `utf8`;

create table `user` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`email` varchar(64) not null unique comment 'E-mail',
	`password` varchar(64) not null comment 'Пароль',
	`name` varchar(64) not null comment 'Имя пользователя',
	`city_id` int(8) unsigned default null comment 'Город',
	`address` varchar(255) default null comment 'Адрес',
	`birthday` date default null comment 'День рождения',
	`info` text default null comment 'Информация о себе',
	`phone` varchar(64) default null comment 'Номер телефона',
	`skype` varchar(64) default null comment 'Скайп',
	`messenger` varchar(64) comment 'Другой мессенджер',
	`created_at` timestamp not null default current_timestamp comment 'Время создания записи',
	foreign key (`city_id`) references `city`(`id`)
) engine `innodb` character set `utf8`;

create table `settings` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`user_id` int(8) unsigned not null comment 'Пользователь',
	`show_message_if_new_message` bool not null default true comment 'Новое сообщение',
	`show_message_if_task_action` bool not null default true comment 'Действие по заданию',
	`show_message_if_new_job` bool not null default true comment 'Новый отзыв',
	`show_contacts_to_customer_only` bool not null default true comment 'Показывать мои контакты только заказчику',
	foreign key (`user_id`) references `user`(`id`)
) engine `innodb` character set `utf8`;

create table `skill` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`name` varchar(64) not null unique comment 'Название специализации',
	`created_at` timestamp not null default current_timestamp comment 'Время создания записи'
) engine `innodb` character set `utf8`;

create table `user_skill` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`user_id` int(8) unsigned not null comment 'Пользователь',
	`skill_id` int(8) unsigned not null comment 'Специализация',
	foreign key (`user_id`) references `user`(`id`),
	foreign key (`skill_id`) references `skill`(`id`)
) engine `innodb` character set `utf8`;

create table `category` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`name` varchar(64) not null unique comment 'Название категории задания',
	`created_at` timestamp not null default current_timestamp comment 'Время создания записи'
) engine `innodb` character set `utf8`;

create table `task` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`customer_id` int(8) unsigned not null comment 'Заказчик',
	`preview` varchar(64) not null comment 'Мне нужно',
	`description` text not null comment 'Подробности задания',
	`category_id` int(8) unsigned not null comment 'Категория задания',
	`address` varchar(255) default null comment 'Адрес',
	`lat` decimal(8, 6) default null comment 'Широта',
	`lon` decimal(8, 6) default null comment 'Долгота',
	`budget` int(4) unsigned default null comment 'Бюджет',
	`deadline` datetime default null comment 'Срок завершения работы',
	`created_at` timestamp not null default current_timestamp comment 'Время создания записи',
	foreign key (`customer_id`) references `user`(`id`),
	foreign key (`category_id`) references `category`(`id`)
) engine `innodb` character set `utf8`;

create table `job` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`task_id` int(8) unsigned not null comment 'Задание',
	`contractor_id` int(8) unsigned not null comment 'Исполнитель',
	`price` int(4) unsigned default null comment 'Цена',
	`comment` varchar(255) default null comment 'Комментарий',
	`rating` enum('1', '2', '3', '4', '5') default null comment 'Оценка',
	`completed_at` datetime default null comment 'Время завершения работы',
	`created_at` timestamp not null default current_timestamp comment 'Время создания записи',
	foreign key (`task_id`) references `task`(`id`),
	foreign key (`contractor_id`) references `user`(`id`)
) engine `innodb` character set `utf8`;

create table `chat` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`task_id` int(8) unsigned not null comment 'Задание',
	`contractor_id` int(8) unsigned not null comment 'Исполнитель',
	`message` varchar(255) not null comment 'Текст сообщения',
	`created_at` timestamp not null default current_timestamp comment 'Время создания записи',
	foreign key (`task_id`) references `task`(`id`),
	foreign key (`contractor_id`) references `user`(`id`)
) engine `innodb` character set `utf8`;

create table `file` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`path` varchar(255) not null unique comment 'Путь к файлу',
	`original_name` varchar(255) not null unique comment 'Оригинальное имя файла',
	`created_at` timestamp not null default current_timestamp comment 'Время создания записи'
) engine `innodb` character set `utf8`;

create table `attachment` (
	`id` int(8) unsigned not null auto_increment primary key comment 'Идентификатор',
	`task_id` int(8) unsigned not null comment 'Задание',
	`file_id` int(8) unsigned not null comment 'Файл',
	foreign key (`task_id`) references `task`(`id`),
	foreign key (`file_id`) references `file`(`id`)
) engine `innodb` character set `utf8`;
