<?php
namespace HtmlAcademy\models;

class AvailableActions {

    protected static $actions = [
        ActionAccept::getName() => 'Принять',
        ActionCancel::getName() => 'Отменить',
        ActionComplete::getName() => 'Завершить',
        ActionReject::getName() => 'Отказаться'
    ];

    public static function getAll() {
        return self::$actions;
    }

}
