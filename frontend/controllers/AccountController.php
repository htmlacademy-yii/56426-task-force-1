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

        $rows = City::find()->orderBy(['name' => SORT_ASC])->all();
        $cities = ['none' => ''] + array_column($rows, 'name', 'id');

        if (Yii::$app->request->getIsPost()) {
            $model->clearSettings();
            $model->load(Yii::$app->request->post());
            $model->convertSettings();
            $model->image_files = UploadedFile::getInstances($model, 'image_files');
            if ($model->validate()) {
                $model->upload();
                $model->save();
            }
        }

        return $this->render('index', ['model' => $model, 'cities' => $cities]);
    }
}
