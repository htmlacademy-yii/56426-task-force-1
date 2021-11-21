<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\City;
use frontend\models\User;
use frontend\models\Profile;
use frontend\models\UserLoginForm;
use frontend\models\UserSignupForm;

class SignupController extends UnsecuredController
{
    public function actionIndex()
    {
        $modelLogin = new UserLoginForm();
        $modelSignup = new UserSignupForm();

        if (Yii::$app->request->getIsGet()) {
            $data = Yii::$app->request->get();
            if (isset($data['email'])) {
                $modelSignup->email = $data['email'];
            }
        }

        $rows = City::find()->orderBy(['name' => SORT_ASC])->all();
        $cities = ['none' => ''] + array_column($rows, 'name', 'id');

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($modelSignup->load($formData) && $modelSignup->validate() && $modelSignup->signup()) {
                $modelLogin->email = $modelSignup->email;
                if ($user = $modelLogin->getUser()) {
                    Yii::$app->user->login($user);
                    return $this->redirect('/tasks');
                }
            }
        }

        return $this->render('index', ['model' => $modelSignup, 'cities' => $cities]);
    }
}
