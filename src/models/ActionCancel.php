<?php
declare(strict_types=1);

namespace HtmlAcademy\Models;

class ActionCancel extends Actions {

    public static function getName(): string {
        return 'Отменить';
    }

    public static function getInnerName(): string {
        return 'ActionCancel';
    }

    public static function isAvailable(Task $task, int $userRole, int $userId): bool {
        return $task->currentStatus === TaskStatus::NEW_TASK &&
               $userRole === UserRole::CUSTOMER &&
               $task->customerId === $userId;
    }

}
