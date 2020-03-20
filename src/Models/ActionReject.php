<?php

namespace HtmlAcademy\Models;

class ActionReject extends Actions {

    public static function getName() {
        return 'Отказаться';
    }

    public static function getInnerName() {
        return 'ActionReject';
    }

    public static function isAvailable($task, $userRole, $userId) {
        return $task->status === TaskStatus::IN_PROGRESS &&
               $userRole === UserRole::CONTRACTOR &&
               $task->contractor_id === $userId;
    }

}
