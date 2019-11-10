<?php
namespace HtmlAcademy\models;

class ActionCancel extends Actions {

    public static function getName() {
        return 'Отменить';
    }

    public static function getInnerName() {
        return 'ActionCancel';
    }

    public static function isAvailable(Task $task, int $userRole, int $userId) {
        return $task->currentStatus === TaskStatus::NEW_TASK &&
               $userRole === UserRole::CUSTOMER &&
               $task->customerId === $userId;
    }

}
