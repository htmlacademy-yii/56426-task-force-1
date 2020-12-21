<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\City;
use frontend\models\User;
use frontend\models\Profile;
use frontend\models\UserSignupForm;

class SignupController extends UnsecuredController
{
    public function actionIndex()
    {
        $model = new UserSignupForm();

        if (Yii::$app->request->getIsGet()) {
            $data = Yii::$app->request->get();
            if (isset($data['email'])) {
                $model->email = $data['email'];
            }
        }

        $rows = City::find()->orderBy(['name' => SORT_ASC])->all();
        $cities = ['none' => ''] + array_column($rows, 'name', 'id');

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData) && $model->validate()) {
                if ($model->signup()) {
                    return $this->redirect('/tasks');
                }
            }
        }

        return $this->render('index', ['model' => $model, 'cities' => $cities]);
    }
}
