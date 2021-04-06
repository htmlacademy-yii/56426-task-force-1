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

    private $eventData = [
        TaskStatus::COMPLETED => [
            'type' => '',
            'text' => ''
        ],
        TaskStatus::FAILED => [
            'type' => 'abandon',
            'text' => ''
        ]
    ];

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

    public function eventData($taskStatus)
    {
        switch ($taskStatus) {
            case TaskStatus::COMPLETED:
                return [
                    'type' => 'close',
                    'text' => 'Завершено задание'
                ];
                break;
            case TaskStatus::FAILED:
                return [
                    'type' => 'abandon',
                    'text' => 'Провалено задание'
                ];
                break;
            default:
                return [
                    'type' => '',
                    'text' => ''
                ];
        }
    }

    public function save($taskId)
    {
        $task = Task::findOne($taskId);
        $task->status = $this->status;

        $feedback = new Feedback();
        $feedback->task_id = $taskId;
        $feedback->contractor_id = $task->contractor_id;
        $feedback->rating = $this->rating;
        $feedback->description = $this->comment;

        $event = new Event();
        $event->user_id = $task->contractor_id;
        $event->task_id = $task->id;
        $event->type = $this->eventData($this->status)['type'];
        $event->text = $this->eventData($this->status)['text'];

        $transaction = Yii::$app->db->beginTransaction();
        if ($task->save() && $feedback->save() && $event->save()) {
            $transaction->commit();
            return true;
        } else {
            $transaction->rollback();
            return false;
        }
    }
}
