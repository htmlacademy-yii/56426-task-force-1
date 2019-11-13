<?php
declare(strict_types=1);

namespace HtmlAcademy\Models;

abstract class Actions {

    abstract public static function getName();
    abstract public static function getInnerName();
    abstract public static function isAvailable(Task $task, int $userRole, int $userId);

}
