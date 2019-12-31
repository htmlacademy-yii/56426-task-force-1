<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Task;
use frontend\models\TaskFilterForm;
use HtmlAcademy\models\TaskStatus;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->joinWith('category')->where(['status' => TaskStatus::NEW_TASK])->orderBy(['dt_add' => SORT_DESC])->all();
        $model = new TaskFilterForm();
        return $this->render('index', ['tasks' => $tasks, 'model' => $model]);
    }
}
