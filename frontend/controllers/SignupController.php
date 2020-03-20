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

        $cities = City::find()->orderBy(['name' => SORT_ASC])->all();

        $items = ['none' => ''];
        foreach ($cities as $city) {
            $items[$city->id] = $city->name;
        }

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData) && $model->validate()) {
                if ($model->signup()) {
                    return $this->redirect('/tasks');
                }
            }
        }

        return $this->render('index', ['model' => $model, 'items' => $items]);
    }
}
