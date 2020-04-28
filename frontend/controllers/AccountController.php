<?php

namespace frontend\controllers;

class AccountController extends SecuredController
{
    public $dropzone;

    public function actionIndex()
    {
        $this->dropzone = true;

        return $this->render('index');
    }
}
