<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Task;
use frontend\models\User;
use HtmlAcademy\Models\TaskStatus;
use HtmlAcademy\Models\UserRole;

class ListController extends SecuredController
{
    public function actionIndex()
    {
        $query = Task::find()->joinWith('category'); //->where(['task.status' => TaskStatus::NEW_TASK]);

        if (User::getRole() === UserRole::CUSTOMER) {
            $query->joinWith('contractor')->andWhere(['task.customer_id' => Yii::$app->user->getId()]);
        } else {
            $query->joinWith('customer')->andWhere(['task.contractor_id' => Yii::$app->user->getId()]);
        }

        $tasks = $query->orderBy(['dt_add' => SORT_DESC])->all();

        return $this->render('index', ['tasks' => $tasks, 'role' => User::getRole()]);
    }
}
