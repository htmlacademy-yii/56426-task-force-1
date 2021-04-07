<?php

namespace HtmlAcademy\Models;

use Yii;
use frontend\models\Reply;

class ActionAccept extends Actions {

    public static function getName() {
        return 'Принять';
    }

    public static function getInnerName() {
        return 'ActionAccept';
    }

    public static function isAvailable($task, $userRole, $userId) {
        $repliesExist = Reply::find()->where(['task_id' => $task->id, 'contractor_id' => $userId, 'active' => true])->exists();
        return $task->status === TaskStatus::NEW_TASK &&
               $userRole === UserRole::CONTRACTOR &&
               $task->customer_id !== $userId &&
               !$repliesExist;
    }
}
