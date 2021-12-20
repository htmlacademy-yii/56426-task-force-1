<?php

namespace frontend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use frontend\models\Chat;
use frontend\models\Task;
use frontend\models\Event;

class MessagesController extends ActiveController
{
    public $modelClass = Chat::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index'], $actions['view'], $actions['update']);

        return $actions;
    }

    public function actionIndex()
    {
        return Task::find()->where(['contractor_id' => Yii::$app->user->getId()])->asArray()->all();
    }

    public function actionView($id)
    {
        $chat = Chat::find()->joinWith('sender')->where(['chat.task_id' => $id])->andWhere(['or', ['=', 'chat.sender_id', Yii::$app->user->getId()], ['=', 'chat.recipient_id', Yii::$app->user->getId()]])->orderBy(['created_at' => SORT_ASC])->asArray()->all();

        return array_map(function($message) {
            return array_merge($message, [
                'out' => ((int)$message['sender_id'] === Yii::$app->user->getId()) ? 1 : 0
            ]);
        }, $chat);
    }

    public function actionUpdate($id)
    {
        $task = Task::findOne($id);

        if (is_null($task) || is_null($task->contractor_id)) {
            return "";
        }

        $data = json_decode(Yii::$app->getRequest()->getRawBody());

        if (strlen($data->message)) {

            $transaction = Yii::$app->db->beginTransaction();

            $chat = new Chat();
            $chat->task_id = $task->id;
            $chat->sender_id = Yii::$app->user->getId();
            $chat->recipient_id = ($task->customer_id === Yii::$app->user->getId()) ? $task->contractor_id : $task->customer_id;
            $chat->message = $data->message;
            $chatSaveResult = $chat->save();

            $event = new Event();
            $event->user_id = $chat->recipient_id;
            $event->task_id = $task->id;
            $event->type = "message";
            $event->text = "Новое сообщение в чате";
            if ($event->isActivated()) {
                $eventSaveResult = $event->save();
            } else {
                $eventSaveResult = true;
            }
    
            if ($chatSaveResult && $eventSaveResult) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        }

        return $data->message;
    }
}
