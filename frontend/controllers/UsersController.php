<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\User;
use frontend\models\UserFilterForm;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = User::find()->joinWith('profile')->joinWith('skills')->orderBy(['dt_add' => SORT_DESC])->all();
        $model = new UserFilterForm();
        return $this->render('index', ['users' => $users, 'model' => $model]);
    }
}
