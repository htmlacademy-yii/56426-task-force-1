<?php
namespace models;

class TaskAction {

    public const ACCEPT = 0;
    public const CANCEL = 1;
    public const COMPLETE = 2;
    public const REJECT = 3;

    protected static $actions = [
        self::ACCEPT => 'Принять',
        self::CANCEL => 'Отменить',
        self::COMPLETE => 'Завершить',
        self::REJECT => 'Отказаться'
    ];

    public static function getAll() {
        return self::$actions;
    }

}
