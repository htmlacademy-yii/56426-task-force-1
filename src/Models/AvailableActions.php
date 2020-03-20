<?php

namespace HtmlAcademy\Models;

use Yii;
use frontend\models\User;

class AvailableActions {

    private static $actions = [
        ActionAccept::class,
        ActionCancel::class,
        ActionComplete::class,
        ActionReject::class
    ];

    public static function getAll() {
        return self::$actions;
    }

    public static function getActions($task) {

        $actionsList = [];

        foreach (self::$actions as $action) {
            if ($action::isAvailable($task, User::getRole(), Yii::$app->user->getId())) {
                $actionsList[] = $action;
            }
        }

        return $actionsList;
    }
}
