<?php
declare(strict_types=1);

namespace HtmlAcademy\models;

class ActionAccept extends Actions {

    public static function getName(): string {
        return 'Принять';
    }

    public static function getInnerName(): string {
        return 'ActionAccept';
    }

    public static function isAvailable(Task $task, int $userRole, int $userId): bool {
        return $task->currentStatus === TaskStatus::NEW_TASK &&
               $userRole === UserRole::CONTRACTOR &&
               $task->customerId !== $userId;
    }

}
