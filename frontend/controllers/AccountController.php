<?php

namespace frontend\controllers;

use Yii;
use frontend\models\City;
use frontend\models\UserAccountForm;

class AccountController extends SecuredController
{
    public $dropzone;

    public function actionIndex()
    {
        $this->dropzone = true;

        $model = new UserAccountForm();

        $cities = City::find()->orderBy(['name' => SORT_ASC])->all();

        $items = ['none' => ''];
        foreach ($cities as $city) {
            $items[$city->id] = $city->name;
        }

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());
        }

        return $this->render('index', ['model' => $model, 'items' => $items]);
    }
}
