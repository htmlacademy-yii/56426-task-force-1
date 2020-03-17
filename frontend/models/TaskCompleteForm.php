<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use HtmlAcademy\Models\TaskStatus;

class TaskCompleteForm extends Model
{
    public $status;
    public $comment;
    public $rating;

    public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий',
            'rating' => 'Оценка'
        ];
    }

    public function rules()
    {
        return [
            [['status', 'comment', 'rating'], 'safe'],
            [['comment', 'rating'], 'required'],
            [['comment'], 'string'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5]
        ];
    }

    public function save($taskId)
    {
        $task = Task::findOne($taskId);
        $task->status = $this->status;

        $feedback = new Feedback();
        $feedback->task_id = $taskId;
        $feedback->contractor_id = Yii::$app->user->getId();
        $feedback->rating = $this->rating;
        $feedback->description = $this->comment;

        $transaction = Yii::$app->db->beginTransaction();
        if ($task->save() && $feedback->save()) {
            $transaction->commit();
            return true;
        } else {
            $transaction->rollback();
            return false;
        }
    }
}
