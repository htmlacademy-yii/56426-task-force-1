<?php

namespace frontend\controllers;

class ListController extends SecuredController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
