<?php

namespace frontend\controllers;

use Yii;
use yii\web\UploadedFile;
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
//            $model->load(Yii::$app->request->post());
            $model->image_files = UploadedFile::getInstances($model, 'image_files');
//            if ($model->validate()) {
                $model->upload();
                $model->save();
//            }
        }

        return $this->render('index', ['model' => $model, 'cities' => $cities]);
    }
}
