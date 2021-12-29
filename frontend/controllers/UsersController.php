<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use frontend\models\City;
use frontend\models\User;
use frontend\models\Event;
use frontend\models\UsersList;
use frontend\models\Feedback;

class UsersController extends SecuredController
{
    public $towns;
    public $eventsCount;

    public function init()
    {
        parent::init();
        $this->towns = City::find()->orderBy(['name' => SORT_ASC])->all();
        $this->eventsCount = Event::newEventsCount();
    }

    public function actionIndex($sort = null)
    {
        $usersList = new UsersList();

        if (Yii::$app->request->getIsGet()) {
            $usersList->addFilterBySkill(Yii::$app->request->get());
        }

        if (Yii::$app->request->getIsPost()) {
            $usersList->addFilterByForm(Yii::$app->request->post());
        }

        $usersList->loadUsers($sort);

        return $this->render('index', [
            'users' => $usersList->users,
            'model' => $usersList->filterForm,
            'pages' => $usersList->pages,
            'sortingRules' => $usersList->sortingRules,
            'sort' => $sort
        ]);
    }

    public function actionView($id)
    {
        $user = User::find()->joinWith('profile')->innerJoinWith('skills')->joinWith('contractorTasks')->joinWith('photos')->where(['user.id' => $id])->one();
        if (!$user) {
            throw new NotFoundHttpException("Исполнитель с ID $id не найден");
        }
        $feedbacks = Feedback::find()->joinWith('task')->where(['feedback.contractor_id' => $id])->all();
        return $this->render('view', ['user' => $user, 'feedbacks' => $feedbacks]);
    }
}
