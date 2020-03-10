<?php

namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\Reply;
use frontend\models\TaskFilterForm;
use HtmlAcademy\Models\TaskStatus;

class TasksController extends SecuredController
{
    public function actionIndex()
    {
        $query = Task::find()->joinWith('category')->where(['task.status' => TaskStatus::NEW_TASK]);

        $model = new TaskFilterForm();

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData) && $model->validate()) {
                // Условие выборки по отсутствию откликов
                if ($model->replies) {
                    //LEFT OUTER JOIN
                    $query->leftJoin('reply', 'reply.task_id = task.id');
                    $query->andWhere(['or',
                        ['reply.task_id' => null],
                        ['task.id' => null]
                    ]);
                }
                // Условие выборки по списку категорий
                if ($model->categories) {
                    $categories = ['or'];
                    foreach ($model->categories as $category) {
                        $categories[] = [
                            'task.category_id' => $category + 1
                        ];
                    }
                    $query->andWhere($categories);
                }
                // Условие выборки по отсутствию локации
                if ($model->location) {
                    $query->andWhere(['task.address' => null]);
                }
                // Условие выборки по периоду времени
                if ($model->period === 'day') {
                    $query->andWhere(['>', 'task.dt_add', date("Y-m-d H:i:s", strtotime("- 1 day"))]);
                } elseif ($model->period === 'week') {
                    $query->andWhere(['>', 'task.dt_add', date("Y-m-d H:i:s", strtotime("- 1 week"))]);
                } elseif ($model->period === 'month') {
                    $query->andWhere(['>', 'task.dt_add', date("Y-m-d H:i:s", strtotime("- 1 month"))]);
                }
                // Условие выборки по совпадению в названии
                if (!empty($model->search)) {
                    $query->andWhere(['like', 'task.name', $model->search]);
                }
            }
        }

        $tasks = $query->orderBy(['dt_add' => SORT_DESC])->all();

        return $this->render('index', ['tasks' => $tasks, 'model' => $model]);
    }

    public function actionView($id)
    {
        $task = Task::find()->joinWith('category')->joinWith('files')->where(['task.id' => $id])->one();
        if (!$task) {
            throw new NotFoundHttpException("Задание с ID $id не найдено");
        }
        $customer = User::find()->joinWith('customerTasks')->where(['user.id' => $task->customer_id])->one();
        $replies = Reply::find()->joinWith('task')->joinWith('contractor')->where(['reply.task_id' => $task->id])->all();
        return $this->render('view', ['task' => $task, 'customer' => $customer, 'replies' => $replies]);
    }

    public function actionCreate()
    {
        return $this->render('create');
    }
}
