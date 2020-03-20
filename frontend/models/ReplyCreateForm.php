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
        $reply = new Reply();

        $reply->task_id = $taskId;
        $reply->contractor_id = Yii::$app->user->getId();
        $reply->price = $this->price;
        $reply->comment = $this->comment;

        return $reply->save();
    }
}
