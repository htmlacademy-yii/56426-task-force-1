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

        $cities = ['none' => ''];
        $rows = City::find()->orderBy(['name' => SORT_ASC])->all();
        foreach ($rows as $item) {
            $cities[$item->id] = $item->name;
        }

        if (Yii::$app->request->getIsPost()) {
            if (Yii::$app->request->getIsAjax()) {
                return "AJAX query accepted";
            }
            $formData = Yii::$app->request->post();
            if ($model->load($formData) && $model->validate()) {
                $model->save();
            }
        }

        return $this->render('index', ['model' => $model, 'cities' => $cities]);
    }
}
