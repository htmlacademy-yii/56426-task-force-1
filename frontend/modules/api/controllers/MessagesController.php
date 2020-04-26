<?php

namespace frontend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use frontend\models\Chat;
use frontend\models\Task;

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
        return Chat::find()->joinWith('task')->where(['chat.task_id' => $id, 'chat.contractor_id' => Yii::$app->user->getId()])->orderBy(['dt_add' => SORT_ASC])->asArray()->all();
    }

    public function actionUpdate($id)
    {
        $data = json_decode(Yii::$app->getRequest()->getRawBody());

        if (strlen($data->message)) {
            $model = new Chat();
            $model->task_id = $id;
            $model->contractor_id = Yii::$app->user->getId();
            $model->is_mine = 0;
            $model->message = $data->message;
            $model->save();
        }

        return;
    }
}
