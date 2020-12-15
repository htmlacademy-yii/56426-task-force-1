create database `56426-task-force-1` character set `utf8` collate `utf8_general_ci`;

use `56426-task-force-1`;

create table `city` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`name` varchar(64) not null comment 'Название города',
	`lat` decimal(10, 7) default null comment 'Широта',
	`long` decimal(10, 7) default null comment 'Долгота',
	`dt_add` timestamp not null default now() comment 'Время создания записи'
) engine `innodb` character set `utf8`;

create table `user` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`email` varchar(64) not null unique comment 'E-mail',
	`password` varchar(64) not null comment 'Пароль',
	`name` varchar(64) not null comment 'Имя пользователя',
	`dt_add` timestamp not null default now() comment 'Время создания записи'
) engine `innodb` character set `utf8`;

create table `profile` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`user_id` int not null unique comment 'Пользователь',
	`city_id` int default null comment 'Город',
	`address` varchar(255) default null comment 'Адрес',
	`birthday` date default null comment 'День рождения',
	`about` text default null comment 'Информация о себе',
	`phone` varchar(64) default null comment 'Номер телефона',
	`skype` varchar(64) default null comment 'Скайп',
	`messenger` varchar(64) comment 'Другой мессенджер',
	`last_activity` timestamp not null default now() comment 'Время последней активности',
	foreign key (`user_id`) references `user`(`id`),
	foreign key (`city_id`) references `city`(`id`)
) engine `innodb` character set `utf8`;

create table `settings` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`user_id` int not null unique comment 'Пользователь',
	`task_actions` boolean not null default true comment 'Действия по заданию',
	`new_message` boolean not null default true comment 'Новое сообщение',
	`new_feedback` boolean not null default true comment 'Новый отзыв',
	`show_contacts` boolean not null default false comment 'Показывать мои контакты только заказчику',
	`hide_profile` boolean not null default true comment 'Не показывать мой профиль',
	foreign key (`user_id`) references `user`(`id`)
) engine `innodb` character set `utf8`;

create table `favorite` (
	`user_id` int not null unique comment 'Пользователь',
	foreign key (`user_id`) references `user`(`id`)
) engine `innodb` character set `utf8`;

create table `skill` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`name` varchar(64) not null unique comment 'Название специализации',
	`dt_add` timestamp not null default now() comment 'Время создания записи'
) engine `innodb` character set `utf8`;

create table `user_skill` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`user_id` int not null comment 'Пользователь',
	`skill_id` int not null comment 'Специализация',
	foreign key (`user_id`) references `user`(`id`),
	foreign key (`skill_id`) references `skill`(`id`)
) engine `innodb` character set `utf8`;

create table `category` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`name` varchar(64) not null unique comment 'Название категории задания',
	`icon` varchar(64) default null comment 'Значок категории',
	`dt_add` timestamp not null default now() comment 'Время создания записи'
) engine `innodb` character set `utf8`;

create table `task` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`customer_id` int not null comment 'Заказчик',
	`name` varchar(64) not null comment 'Мне нужно',
	`description` text not null comment 'Подробности задания',
	`category_id` int not null comment 'Категория задания',
	`address` varchar(255) default null comment 'Адрес',
	`lat` decimal(10, 7) default null comment 'Широта',
	`long` decimal(10, 7) default null comment 'Долгота',
	`budget` int default null comment 'Бюджет',
	`status` int not null comment 'Статус задания',
	`contractor_id` int default null comment 'Исполнитель',
	`expire` datetime default null comment 'Срок завершения работы',
	`dt_add` timestamp not null default now() comment 'Время создания записи',
	foreign key (`customer_id`) references `user`(`id`),
	foreign key (`category_id`) references `category`(`id`),
	foreign key (`contractor_id`) references `user`(`id`)
) engine `innodb` character set `utf8`;

create table `reply` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`task_id` int not null comment 'Задание',
	`contractor_id` int not null comment 'Исполнитель',
	`price` int default null comment 'Цена',
	`comment` text default null comment 'Комментарий',
	`active` boolean not null default true comment 'Признак активности',
	`dt_add` timestamp not null default now() comment 'Время создания записи',
	foreign key (`task_id`) references `task`(`id`),
	foreign key (`contractor_id`) references `user`(`id`)
) engine `innodb` character set `utf8`;

create table `chat` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`task_id` int not null comment 'Задание',
	`contractor_id` int not null comment 'Исполнитель',
	`is_mine` boolean not null default false comment 'Сообщение заказчика',
	`message` varchar(255) not null comment 'Текст сообщения',
	`dt_add` timestamp not null default now() comment 'Время создания записи',
	foreign key (`task_id`) references `task`(`id`),
	foreign key (`contractor_id`) references `user`(`id`)
) engine `innodb` character set `utf8`;

create table `feedback` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`contractor_id` int not null comment 'Исполнитель',
	`task_id` int not null comment 'Задание',
	`rating` enum('1', '2', '3', '4', '5') not null comment 'Оценка',
	`description` text not null comment 'Текст отзыва',
	`dt_add` timestamp not null default now() comment 'Время создания записи',
	foreign key (`contractor_id`) references `user`(`id`),
	foreign key (`task_id`) references `task`(`id`)
) engine `innodb` character set `utf8`;

create table `event` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`user_id` int not null comment 'Пользователь',
	`task_id` int not null comment 'Задание',
	`is_viewed` boolean not null default false comment 'Признак просмотра',
	`type` enum('close', 'executor', 'message') not null comment 'Тип события',
	`text` varchar(255) not null comment 'Текст события',
	`dt_add` timestamp not null default now() comment 'Время создания записи',
	foreign key (`user_id`) references `user`(`id`),
	foreign key (`task_id`) references `task`(`id`)
) engine `innodb` character set `utf8`;

create table `file` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`path` varchar(255) not null unique comment 'Путь к файлу',
	`original_name` varchar(255) not null unique comment 'Оригинальное имя файла',
	`dt_add` timestamp not null default now() comment 'Время создания записи'
) engine `innodb` character set `utf8`;

create table `attachment` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`task_id` int not null comment 'Задание',
	`file_id` int not null comment 'Файл',
	foreign key (`task_id`) references `task`(`id`),
	foreign key (`file_id`) references `file`(`id`)
) engine `innodb` character set `utf8`;

create table `photo` (
	`id` int not null auto_increment primary key comment 'Идентификатор',
	`user_id` int not null comment 'Пользователь',
	`file` varchar(255) not null unique comment 'Файл',
	foreign key (`user_id`) references `user`(`id`)
) engine `innodb` character set `utf8`;
