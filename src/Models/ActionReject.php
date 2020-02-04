<?php
declare(strict_types=1);

namespace HtmlAcademy\Models;

class ActionReject extends Actions {

    public static function getName(): string {
        return 'Отказаться';
    }

    public static function getInnerName(): string {
        return 'ActionReject';
    }

    public static function isAvailable(Task $task, int $userRole, int $userId): bool {
        return $task->currentStatus === TaskStatus::IN_PROGRESS &&
               $userRole === UserRole::CONTRACTOR &&
               $task->contractorId === $userId;
    }

}
