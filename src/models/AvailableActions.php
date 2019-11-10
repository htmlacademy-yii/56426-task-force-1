<?php
namespace HtmlAcademy\models;

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

    public static function getActions(Task $task, int $userRole, int $userId) {
        $actionsList = [];

        foreach (self::$actions as $action) {
            if ($action::isAvailable($task, $userRole, $userId)) {
                $actionsList[] = $action::getName();
            }
        }

        return $actionsList;
    }
}
