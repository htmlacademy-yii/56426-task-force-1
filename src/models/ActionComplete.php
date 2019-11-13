<?php
declare(strict_types=1);

namespace HtmlAcademy\Models;

class ActionComplete extends Actions {

    public static function getName(): string {
        return 'Завершить';
    }

    public static function getInnerName(): string {
        return 'ActionComplete';
    }

    public static function isAvailable(Task $task, int $userRole, int $userId): bool {
        return $task->currentStatus === TaskStatus::IN_PROGRESS &&
               $userRole === UserRole::CUSTOMER &&
               $task->customerId === $userId;
    }

}
