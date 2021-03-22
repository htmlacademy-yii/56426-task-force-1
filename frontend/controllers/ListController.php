<?php

namespace frontend\controllers;

use Yii;
use frontend\models\City;
use frontend\models\Task;
use frontend\models\User;
use HtmlAcademy\Models\TaskStatus;
use HtmlAcademy\Models\UserRole;

class ListController extends SecuredController
{
    public $towns;

    public function init()
    {
        parent::init();
        $this->towns = City::find()->orderBy(['name' => SORT_ASC])->all();
    }

    public function actionIndex()
    {
        $query = Task::find()->joinWith('category');

        if (User::getRole() === UserRole::CUSTOMER) {
            $query->joinWith('contractor')->andWhere(['task.customer_id' => Yii::$app->user->getId()]);
        } else {
            $query->joinWith('customer')->andWhere(['task.contractor_id' => Yii::$app->user->getId()]);
        }

        $currentStatus = null;

        if (Yii::$app->request->getIsGet()) {
            $filter = Yii::$app->request->get();
            if (isset($filter['status']) && in_array($filter['status'], TaskStatus::getAllClasses())) {
                $currentStatus = array_search($filter['status'], TaskStatus::getAllClasses());
                $query->andWhere(['task.status' => $currentStatus]);
            }
        }

        $tasks = $query->orderBy(['dt_add' => SORT_DESC])->all();

        return $this->render('index', ['tasks' => $tasks, 'role' => User::getRole(), 'currentStatus' => $currentStatus]);
    }
}
