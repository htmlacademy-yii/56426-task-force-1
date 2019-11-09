<?php
namespace HtmlAcademy\models;

class ActionReject extends Actions {

    public static function getName() {
        return 'Отказаться';
    }

    public static function getInnerName() {
        return 'ActionReject';
    }

    public static function isAvailable(Task $task, int $userRole, int $userId) {
        return ($task->currentStatus === TaskStatus::IN_PROGRESS && $userRole === UserRole::CONTRACTOR && $task->contractorId === $userId) ? true : false;
    }

}
