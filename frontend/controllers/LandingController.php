<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\UserLoginForm;

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

        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->model = new UserLoginForm();

        if (Yii::$app->request->getIsPost()) {
            $this->model->load(Yii::$app->request->post());
            if ($this->model->validate()) {
                Yii::$app->user->login($this->model->getUser());
                return $this->redirect('/tasks');
            }
        }

        return $this->goHome();
    }

    public function onAuthSuccess($client)
    {
        $this->model = new UserLoginForm();
        $attributes = $client->getUserAttributes();

        if ( !Yii::$app->user->isGuest || !isset($attributes['email']) ) {
            return $this->goHome();
        }

        $this->model->email = $attributes['email'];

        if ($user = $this->model->getUser()) {
            Yii::$app->user->login($user);
            return $this->redirect('/tasks');
        } else {
            return $this->redirect('/signup?email='.$attributes['email']);
        }

        return $this->goHome();
    }
}
