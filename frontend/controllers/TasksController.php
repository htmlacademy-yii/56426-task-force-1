<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->joinWith('category')->all();
        return $this->render('index', ['tasks' => $tasks]);
    }
}
