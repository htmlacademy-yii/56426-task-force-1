<?php
namespace models;

class TaskStatus {

    public const NEW = 0;
    public const IN_PROGRESS = 1;
    public const COMPLETED = 2;
    public const CANCELED = 3;
    public const FAILED = 4;

    protected static $statuses = [
        self::NEW = "Новое";
        self::IN_PROGRESS = "Выполняется";
        self::COMPLETED = "Завершено";
        self::CANCELED = "Отменено";
        self::FAILED = "Провалено";
    ];

    public static getAll() {
        return self::$statuses;
    }

}
