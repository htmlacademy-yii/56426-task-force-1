<?php
namespace HtmlAcademy\models;

class ActionComplete extends Actions {

    public static function getName() {
        return 'Завершить';
    }

    public static function getInnerName() {
        return 'ActionComplete';
    }

    public static function isAvailable(Task $task, int $userRole, int $userId) {
        return $task->currentStatus === TaskStatus::IN_PROGRESS &&
               $userRole === UserRole::CUSTOMER &&
               $task->customerId === $userId;
    }

}
