<?php

namespace HtmlAcademy\Models;

class ActionComplete extends Actions {

    public static function getName() {
        return 'Завершить';
    }

    public static function getInnerName() {
        return 'ActionComplete';
    }

    public static function isAvailable($task, $userRole, $userId) {
        return $task->status === TaskStatus::IN_PROGRESS &&
               $userRole === UserRole::CUSTOMER &&
               $task->customer_id === $userId;
    }

}
