<?php

namespace HtmlAcademy\Models;

use frontend\models\Reply;

class ActionAccept extends Actions {

    public static function getName() {
        return 'Принять';
    }

    public static function getInnerName() {
        return 'ActionAccept';
    }

    public static function isAvailable($task, $userRole, $userId) {
        $replyExists = (bool)(Reply::findOne(['task_id' => $task, 'contractor_id' => $userId, 'active' => true]));
        return $task->status === TaskStatus::NEW_TASK &&
               $userRole === UserRole::CONTRACTOR &&
               $task->customer_id !== $userId &&
               !$replyExists;
    }

}
