<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\UserLoginForm;

class LandingController extends Controller
{
    public $layout = 'landing';
    public $model;

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

        return $this->redirect('/signup');
    }
}
