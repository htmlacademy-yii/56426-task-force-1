<?php
namespace HtmlAcademy\models;

class ActionAccept extends Actions {

    public static function getName() {
        return 'Принять';
    }

    public static function getInnerName() {
        return 'ActionAccept';
    }

    public static function isAvailable(Task $task, int $userRole, int $userId) {
        return $task->currentStatus === TaskStatus::NEW_TASK &&
               $userRole === UserRole::CONTRACTOR &&
               $task->customerId !== $userId;
    }

}
