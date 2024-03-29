<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\models\Task;
use frontend\models\UserLoginForm;
use HtmlAcademy\Models\TaskStatus;

class LandingController extends UnsecuredController
{
    public $layout = 'landing';
    public $model;

    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess']
            ]
        ];
    }

    public function actionIndex()
    {
        $this->model = new UserLoginForm();

        $tasks = Task::find()->joinWith('category')->where(['task.status' => TaskStatus::NEW_TASK])->orderBy(['created_at' => SORT_DESC])->limit(4)->all();

        return $this->render('index', ['tasks' => $tasks]);
    }

    public function actionLogin()
    {
        $this->model = new UserLoginForm();

        if (Yii::$app->request->getIsPost()) {
            $this->model->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($this->model);
            }
            if ($this->model->validate()) {
                Yii::$app->user->login($this->model->getUser());
                Yii::$app->session->set('userCity', isset(Yii::$app->user->getIdentity()->profile->city) ? Yii::$app->user->getIdentity()->profile->city->id : null);
                return $this->redirect('/tasks');
            }
        }

        return $this->goHome();
    }

    public function onAuthSuccess($client)
    {
        $this->model = new UserLoginForm();
        $attributes = $client->getUserAttributes();

        if (Yii::$app->user->isGuest && isset($attributes['email'])) {
            $this->model->email = $attributes['email'];
            if ($user = $this->model->getUser()) {
                Yii::$app->user->login($user);
                Yii::$app->session->set('userCity', isset(Yii::$app->user->getIdentity()->profile->city) ? Yii::$app->user->getIdentity()->profile->city->id : null);
                return $this->redirect('/tasks');
            } else {
                return $this->redirect('/signup?email='.$attributes['email']);
            }
        }

        return $this->goHome();
    }
}
