<?php
namespace HtmlAcademy\models;

class UserRole {

    public const CUSTOMER = 0;
    public const CONTRACTOR = 1;

    protected static $roles = [
        self::CUSTOMER => "Заказчик",
        self::CONTRACTOR => "Исполнитель"
    ];

    public static function getAll() {
        return self::$roles;
    }

}
