<?php

namespace HtmlAcademy\Models;

abstract class Actions {

    abstract public static function getName();
    abstract public static function getInnerName();
    abstract public static function isAvailable($task, $userRole, $userId);

}
