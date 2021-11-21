<?php

namespace HtmlAcademy\Models;

class TaskStatus {

    public const NEW_TASK = 0;
    public const IN_PROGRESS = 1;
    public const COMPLETED = 2;
    public const CANCELED = 3;
    public const FAILED = 4;

    protected static $statusValues = [
        self::NEW_TASK,
        self::IN_PROGRESS,
        self::COMPLETED,
        self::CANCELED,
        self::FAILED
    ];

    protected static $statusClass = [
        self::NEW_TASK => "new",
        self::IN_PROGRESS => "active",
        self::COMPLETED => "completed",
        self::CANCELED => "canceled",
        self::FAILED => "failed"
    ];

    protected static $statusName = [
        self::NEW_TASK => "Новое",
        self::IN_PROGRESS => "Выполняется",
        self::COMPLETED => "Завершено",
        self::CANCELED => "Отменено",
        self::FAILED => "Провалено"
    ];

    protected static $statusNamePlural = [
        self::NEW_TASK => "Новые",
        self::IN_PROGRESS => "Активные",
        self::COMPLETED => "Завершённые",
        self::CANCELED => "Отменённые",
        self::FAILED => "Просроченные"
    ];

    public static function getAll() {
        return self::$statusValues;
    }

    public static function getAllClasses() {
        return self::$statusClass;
    }

    public static function getAllNames() {
        return self::$statusName;
    }

    public static function getAllNamesPlural() {
        return self::$statusNamePlural;
    }

    public static function getClass($id) {
        return self::$statusClass[$id];
    }

    public static function getName($id) {
        return self::$statusName[$id];
    }

    public static function getNamePlural($id) {
        return self::$statusNamePlural[$id];
    }
}
