<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\UserLoginForm;

class LandingController extends Controller
{
    public $layout = 'landing';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $model = new UserLoginForm();

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData) && $model->validate()) {
                $user = $model->getUser();
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }
    }
}
