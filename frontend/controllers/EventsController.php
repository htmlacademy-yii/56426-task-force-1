<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Event;

class EventsController extends SecuredController
{
    public function actionIndex()
    {
        $events = Event::find()->where(['user_id' => Yii::$app->user->getId(), 'is_viewed' => false])->all();
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'task_id' => $event->task->id,
                'task_name' => "«".$event->task->name."»",
                'event_type' => $event->type,
                'event_text' => $event->text
            ];
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function actionClear()
    {
        Event::updateAll(['is_viewed' => true], ['user_id' => Yii::$app->user->getId(), 'is_viewed' => false]);

        return Event::find()->where(['user_id' => Yii::$app->user->getId(), 'is_viewed' => false])->count();
    }
}
