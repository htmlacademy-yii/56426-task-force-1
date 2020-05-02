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
            $model->load(Yii::$app->request->post());
            if ($model->validate() && $model->save()) {
                    //$model->loadAccountData(Yii::$app->user->getId());
            }
        }

        return $this->render('index', ['model' => $model, 'cities' => $cities]);
    }
}
