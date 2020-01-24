<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Task;
use frontend\models\TaskFilterForm;
use HtmlAcademy\Models\TaskStatus;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->joinWith('category')->where(['status' => TaskStatus::NEW_TASK])->orderBy(['dt_add' => SORT_DESC])->all();
        $model = new TaskFilterForm();

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();

            echo "<pre>";
            var_dump($formData);
            echo "</pre>";

            $model->load($formData);

            echo "<pre>";
            var_dump($model);
            echo "</pre>";
        }

        return $this->render('index', ['tasks' => $tasks, 'model' => $model]);
    }
}
