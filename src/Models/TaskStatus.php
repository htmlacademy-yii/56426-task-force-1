<?php

namespace HtmlAcademy\Models;

class TaskStatus {

    public const NEW_TASK = 0;
    public const IN_PROGRESS = 1;
    public const COMPLETED = 2;
    public const CANCELED = 3;
    public const FAILED = 4;

    protected static $statusClass = [
        self::NEW_TASK => "new-status",
        self::IN_PROGRESS => "active-status",
        self::COMPLETED => "completed-status",
        self::CANCELED => "canceled-status",
        self::FAILED => "failed-status"
    ];

    protected static $statusName = [
        self::NEW_TASK => "Новое",
        self::IN_PROGRESS => "Выполняется",
        self::COMPLETED => "Завершено",
        self::CANCELED => "Отменено",
        self::FAILED => "Провалено"
    ];

    public static function getAll() {
        return self::$statusName;
    }

    public static function getClass($id) {
        return self::$statusClass[$id];
    }

    public static function getName($id) {
        return self::$statusName[$id];
    }
}
