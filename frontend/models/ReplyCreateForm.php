<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class ReplyCreateForm extends Model
{
    public $price;
    public $comment;

    public function attributeLabels()
    {
        return [
            'price' => 'Ваша цена',
            'comment' => 'Комментарий'
        ];
    }

    public function rules()
    {
        return [
            [['price', 'comment'], 'safe'],
            [['price', 'comment'], 'required'],
            [['price'], 'integer', 'min' => 1],
            [['comment'], 'string']
        ];
    }

    public function save($taskId)
    {
        $task = Task::findOne($taskId);

        $reply = new Reply();
        $reply->task_id = $task->id;
        $reply->contractor_id = Yii::$app->user->getId();
        $reply->price = $this->price;
        $reply->comment = $this->comment;

        $event = new Event();
        $event->user_id = $task->customer_id;
        $event->task_id = $task->id;
        $event->type = "reply";
        $event->text = "Новый отклик к заданию";

        $transaction = Yii::$app->db->beginTransaction();
        if ($reply->save() && $event->save()) {
            $transaction->commit();
            return true;
        } else {
            $transaction->rollback();
            return false;
        }
    }
}
