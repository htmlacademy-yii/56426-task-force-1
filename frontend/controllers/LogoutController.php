<?php

namespace frontend\controllers;

use Yii;

class LogoutController extends SecuredController
{
    public function actionIndex()
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
}
