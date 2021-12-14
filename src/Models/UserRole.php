<?php

namespace HtmlAcademy\Models;

class UserRole {

    public const CUSTOMER = 0;
    public const CONTRACTOR = 1;

    private static $roles = [
        self::CUSTOMER,
        self::CONTRACTOR
    ];

    public static function getAll() {
        return self::$roles;
    }

}
