<?php
declare(strict_types=1);

namespace HtmlAcademy\models;

class UserRole {

    public const CUSTOMER = 0;
    public const CONTRACTOR = 1;

    protected static $roles = [
        self::CUSTOMER,
        self::CONTRACTOR
    ];

    public static function getAll(): array {
        return self::$roles;
    }

}
