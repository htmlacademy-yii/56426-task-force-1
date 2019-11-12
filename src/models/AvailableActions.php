<?php
declare(strict_types=1);

namespace HtmlAcademy\models;

use HtmlAcademy\ex\DataTypeException;

class AvailableActions {

    private static $actions = [
        ActionAccept::class,
        ActionCancel::class,
        ActionComplete::class,
        ActionReject::class
    ];

    public static function getAll(): array {
        return self::$actions;
    }

    public static function getActions(Task $task, int $userRole, int $userId): array {
        if (!in_array($userRole, UserRole::getAll())) {
            throw new DataTypeException("Недопустимое значение роли пользователя.");
        }

        $actionsList = [];

        foreach (self::$actions as $action) {
            if ($action::isAvailable($task, $userRole, $userId)) {
                $actionsList[] = $action::getName();
            }
        }

        return $actionsList;
    }
}
