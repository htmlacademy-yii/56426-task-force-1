<?php

namespace frontend\controllers;

use Yii;
use yii\web\UploadedFile;
use frontend\models\City;
use frontend\models\Event;
use frontend\models\UserAccountForm;

class AccountController extends SecuredController
{
    public $towns;
    public $dropzone;
    public $eventsCount;

    public function init()
    {
        parent::init();
        $this->towns = City::find()->orderBy(['name' => SORT_ASC])->all();
        $this->eventsCount = Event::newEventsCount();
    }

    public function actionIndex()
    {
        $this->dropzone = true;

        $model = new UserAccountForm();

        $cities = ['none' => ''] + array_column($this->towns, 'name', 'id');

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
