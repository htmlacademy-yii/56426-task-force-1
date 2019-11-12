<?php
declare(strict_types=1);

namespace HtmlAcademy\models;

class TaskStatus {

    public const NEW_TASK = 0;
    public const IN_PROGRESS = 1;
    public const COMPLETED = 2;
    public const CANCELED = 3;
    public const FAILED = 4;

    protected static $statuses = [
        self::NEW_TASK => "Новое",
        self::IN_PROGRESS => "Выполняется",
        self::COMPLETED => "Завершено",
        self::CANCELED => "Отменено",
        self::FAILED => "Провалено"
    ];

    public static function getAll(): array {
        return self::$statuses;
    }

}
