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
        return Chat::find()->joinWith('task')->where(['chat.task_id' => $id])->andWhere(['or', ['=', 'task.customer_id', Yii::$app->user->getId()], ['=', 'chat.contractor_id', Yii::$app->user->getId()]])->orderBy(['dt_add' => SORT_ASC])->asArray()->all();
    }

    public function actionUpdate($id)
    {
        $data = json_decode(Yii::$app->getRequest()->getRawBody());

        if (strlen($data->message)) {
            $task = Task::findOne($id);

            $chat = new Chat();
            $chat->task_id = $task->id;
            $chat->contractor_id = Yii::$app->user->getId();
            $chat->is_mine = ($task->customer_id === Yii::$app->user->getId()) ? 1 : 0;
            $chat->message = $data->message;

            $event = new Event();
            $event->user_id = ($task->customer_id === Yii::$app->user->getId()) ? $task->contractor_id : $task->customer_id;
            $event->task_id = $task->id;
            $event->type = "message";
            $event->text = "Новое сообщение в чате";
    
            $transaction = Yii::$app->db->beginTransaction();
            if ($chat->save() && $event->save()) {
                $transaction->commit();
            } else {
                $transaction->rollback();
            }
        }

        return;
    }
}
