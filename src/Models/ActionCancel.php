<?php

namespace HtmlAcademy\Models;

class ActionCancel extends Actions {

    public static function getName() {
        return 'Отменить';
    }

    public static function getInnerName() {
        return 'ActionCancel';
    }

    public static function isAvailable($task, $userRole, $userId) {
        return $task->status === TaskStatus::NEW_TASK &&
               $userRole === UserRole::CUSTOMER &&
               $task->customer_id === $userId;
    }

}
