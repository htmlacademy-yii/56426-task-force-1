<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\City;
use frontend\models\User;
use frontend\models\Profile;
use frontend\models\UserSignupForm;

class SignupController extends Controller
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
                $user = new User();
                $user->email = $model->email;
                $user->name = $model->name;
                $user->password = $model->password;
                if ($user->save()) {
                    $profile = new Profile();
                    $profile->user_id = $user->id;
                    $profile->city_id = $model->city;
                    if ($profile->save()) {
                        return Yii::$app->getResponse()->redirect(['tasks']);
                    }
                }
            }
        }

        return $this->render('index', ['model' => $model, 'items' => $items]);
    }
}
