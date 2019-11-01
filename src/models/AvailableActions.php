<?php
namespace HtmlAcademy\models;

class AvailableActions {

    public const ACCEPT = ActionAccept::getName();
    public const CANCEL = ActionCancel::getName();
    public const COMPLETE = ActionComplete::getName();
    public const REJECT = ActionReject::getName();

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
