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
            $formData = Yii::$app->request->post();
            if ($this->model->load($formData) && $this->model->validate()) {
                $user = $this->model->getUser();
                Yii::$app->user->login($user);
                return $this->redirect('/signup');
                //return $this->redirect('/tasks');
            }
        }

        return $this->goHome();
    }
}
