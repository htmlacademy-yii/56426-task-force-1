CREATE DATABASE `56426-task-force-1` CHARACTER SET `utf8` COLLATE `utf8_general_ci`;

USE `56426-task-force-1`;

CREATE TABLE `city` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`name` varchar(64) NOT NULL COMMENT 'Название города',
	`lat` decimal(10,7) DEFAULT NULL COMMENT 'Широта',
	`long` decimal(10,7) DEFAULT NULL COMMENT 'Долгота',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания записи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Города';

CREATE TABLE `skill` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`name` varchar(64) NOT NULL COMMENT 'Название специализации',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания записи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Специализации исполнителей';

CREATE TABLE `category` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`name` varchar(64) NOT NULL COMMENT 'Название категории задания',
	`icon` varchar(64) DEFAULT NULL COMMENT 'Значок категории',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания записи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Категории заданий';

CREATE TABLE `user` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`name` varchar(64) NOT NULL COMMENT 'Имя пользователя',
	`email` varchar(64) NOT NULL COMMENT 'E-mail',
	`password` varchar(64) NOT NULL COMMENT 'Пароль',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания записи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Пользователи';

CREATE TABLE `profile` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`user_id` int(11) NOT NULL COMMENT 'Пользователь',
	`city_id` int(11) DEFAULT NULL COMMENT 'Город',
	`address` varchar(255) DEFAULT NULL COMMENT 'Адрес',
	`birthday` date DEFAULT NULL COMMENT 'День рождения',
	`about` text COMMENT 'Информация о себе',
	`phone` varchar(64) DEFAULT NULL COMMENT 'Номер телефона',
	`skype` varchar(64) DEFAULT NULL COMMENT 'Скайп',
	`telegram` varchar(64) DEFAULT NULL COMMENT 'Телеграм',
	`last_activity` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время последней активности',
	FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
	FOREIGN KEY (`city_id`) REFERENCES `city` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Профили пользователей';

CREATE TABLE `settings` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`user_id` int(11) NOT NULL COMMENT 'Пользователь',
	`task_actions` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Действия по заданию',
	`new_message` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Новое сообщение',
	`new_reply` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Новый отклик',
	`hide_contacts` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Показывать мои контакты только заказчику',
	`hide_profile` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Не показывать мой профиль',
	FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Настройки пользователей';

CREATE TABLE `user_skill` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`user_id` int(11) NOT NULL COMMENT 'Пользователь',
	`skill_id` int(11) NOT NULL COMMENT 'Специализация',
	FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
	FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Установленные специализации';

CREATE TABLE `task` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`customer_id` int(11) NOT NULL COMMENT 'Заказчик',
	`name` varchar(64) NOT NULL COMMENT 'Мне нужно',
	`description` text NOT NULL COMMENT 'Подробности задания',
	`category_id` int(11) NOT NULL COMMENT 'Категория задания',
	`city_id` int(11) DEFAULT NULL COMMENT 'Город',
	`address` varchar(255) DEFAULT NULL COMMENT 'Адрес',
	`lat` decimal(10,7) DEFAULT NULL COMMENT 'Широта',
	`long` decimal(10,7) DEFAULT NULL COMMENT 'Долгота',
	`budget` int(11) DEFAULT NULL COMMENT 'Бюджет',
	`status` int(11) NOT NULL COMMENT 'Статус задания',
	`contractor_id` int(11) DEFAULT NULL COMMENT 'Исполнитель',
	`expire` datetime DEFAULT NULL COMMENT 'Срок завершения работы',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания записи',
	FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`),
	FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
	FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
	FOREIGN KEY (`contractor_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Задания';

CREATE TABLE `reply` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`task_id` int(11) NOT NULL COMMENT 'Задание',
	`contractor_id` int(11) NOT NULL COMMENT 'Исполнитель',
	`price` int(11) DEFAULT NULL COMMENT 'Цена',
	`comment` text COMMENT 'Комментарий',
	`is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Признак активности',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания записи',
	FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
	FOREIGN KEY (`contractor_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отклики на задания';

CREATE TABLE `attachment` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`task_id` int(11) NOT NULL COMMENT 'Задание',
	`file` varchar(255) NOT NULL COMMENT 'Файл',
	`name` varchar(64) NOT NULL COMMENT 'Имя файла',
	FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вложения к заданиям';

CREATE TABLE `photo` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`user_id` int(11) NOT NULL COMMENT 'Пользователь',
	`file` varchar(255) NOT NULL COMMENT 'Файл',
	`name` varchar(64) NOT NULL COMMENT 'Имя файла',
	FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Фото работ исполнителей';

CREATE TABLE `chat` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`task_id` int(11) NOT NULL COMMENT 'Задание',
	`sender_id` int(11) NOT NULL COMMENT 'Отправитель',
	`recipient_id` int(11) NOT NULL COMMENT 'Получатель',
	`message` varchar(255) NOT NULL COMMENT 'Текст сообщения',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания записи',
	FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
	FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`),
	FOREIGN KEY (`recipient_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Внутренняя переписка';

CREATE TABLE `event` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`user_id` int(11) NOT NULL COMMENT 'Пользователь',
	`task_id` int(11) NOT NULL COMMENT 'Задание',
	`is_viewed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Признак просмотра',
	`type` enum('abandon','begin','close','message','reply') NOT NULL COMMENT 'Тип события',
	`text` varchar(255) NOT NULL COMMENT 'Текст события',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания записи',
	FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
	FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='События';

CREATE TABLE `feedback` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
	`contractor_id` int(11) NOT NULL COMMENT 'Исполнитель',
	`task_id` int(11) NOT NULL COMMENT 'Задание',
	`rating` enum('1','2','3','4','5') NOT NULL COMMENT 'Оценка',
	`description` text NOT NULL COMMENT 'Текст отзыва',
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания записи',
	FOREIGN KEY (`contractor_id`) REFERENCES `user` (`id`),
	FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отзывы об исполнителях';
