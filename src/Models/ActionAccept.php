<?php

namespace HtmlAcademy\Models;

class ActionAccept extends Actions {

    public static function getName() {
        return 'Принять';
    }

    public static function getInnerName() {
        return 'ActionAccept';
    }

    public static function isAvailable($task, $userRole, $userId) {
        return $task->status === TaskStatus::NEW_TASK &&
               $userRole === UserRole::CONTRACTOR &&
               $task->customer_id !== $userId;
    }

}
