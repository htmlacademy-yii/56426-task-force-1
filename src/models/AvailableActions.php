<?php
namespace HtmlAcademy\models;

class AvailableActions {

    private static $actions = [
        ActionAccept::class => 'Принять',
        ActionCancel::class => 'Отменить',
        ActionComplete::class => 'Завершить',
        ActionReject::class => 'Отказаться'
    ];

    public static function getAll() {
        return $this->$actions;
    }

    public static function getActions(Task $task, int $userRole, int $userId) {
        $actionsList = [];

        foreach (self::$actions as $action => $actionName) {
            if ($action::isAvailable($task, $userRole, $userId)) {
                $actionsList[] = $actionName;
            }
        }

        return $actionsList;
    }
}
