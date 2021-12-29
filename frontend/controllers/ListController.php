<?php

namespace frontend\controllers;

use Yii;
use frontend\models\City;
use frontend\models\Event;
use frontend\models\UserTasksList;

class ListController extends SecuredController
{
    public $towns;
    public $eventsCount;

    public function init()
    {
        parent::init();
        $this->towns = City::find()->orderBy(['name' => SORT_ASC])->all();
        $this->eventsCount = Event::newEventsCount();
    }

    public function actionIndex()
    {
        $myList = new UserTasksList();

        if (Yii::$app->request->getIsGet()) {
            $myList->addFilterByStatus(Yii::$app->request->get());
        }

        $myList->loadTasks();

        return $this->render('index', ['tasks' => $myList->tasks, 'role' => $myList->role, 'currentStatus' => $myList->status]);
    }
}
