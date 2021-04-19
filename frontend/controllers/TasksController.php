<?php

namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use frontend\models\City;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\Event;
use frontend\models\Reply;
use frontend\models\Category;
use frontend\models\TaskFilterForm;
use frontend\models\TaskCreateForm;
use frontend\models\ReplyCreateForm;
use frontend\models\TaskCompleteForm;
use HtmlAcademy\Models\TaskStatus;
use HtmlAcademy\Models\UserRole;

class TasksController extends SecuredController
{
    public $towns;
    public $taskId;
    public $taskLat;
    public $taskLong;
    public $replyForm;
    public $eventsCount;
    public $completeForm;
    public $autoComplete;

    public function init()
    {
        parent::init();
        $this->towns = City::find()->orderBy(['name' => SORT_ASC])->all();
        $this->eventsCount = Event::newEventsCount();
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->request->getIsAjax()) {
            $data = Yii::$app->request->get();
            if (isset($data['city'])) {
                Yii::$app->session->set('userCity', ((int)$data['city'] > 0) ? (int)$data['city'] : null);
            }
            return true;
        }

        $query = Task::find()->joinWith('category')->where(['task.status' => TaskStatus::NEW_TASK]);

        if (!is_null(Yii::$app->session->get('userCity'))) {
            $query->andWhere(['or', ['task.city_id' => null], ['task.city_id' => Yii::$app->session->get('userCity')]]);
        }

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

        $query->orderBy(['dt_add' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5,
            'defaultPageSize' => 5,
            'pageSizeLimit' => [1, 5],
            'forcePageParam' => false
        ]);

        $tasks = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', ['tasks' => $tasks, 'model' => $model, 'pages' => $pages]);
    }

    // Просмотр задания
    public function actionView($id)
    {
        $this->taskId = $id;
        $this->replyForm = new ReplyCreateForm();
        $this->completeForm = new TaskCompleteForm();

        $task = Task::find()->joinWith('category')->joinWith('attachments')->where(['task.id' => $id])->one();
        if (!$task) {
            throw new NotFoundHttpException("Задание с ID $id не найдено");
        }

        $this->taskLat = $task->lat;
        $this->taskLong = $task->long;

        $customer = User::find()->joinWith('customerTasks')->where(['user.id' => $task->customer_id])->one();

        $query = Reply::find()->joinWith('task')->joinWith('contractor')->where(['reply.task_id' => $task->id])->andWhere(['reply.active' => true]);
        if ($task->customer_id !== Yii::$app->user->getId()) {
            $query->andWhere(['reply.contractor_id' => Yii::$app->user->getId()]);
        }
        $replies = $query->all();

        return $this->render('view', ['task' => $task, 'customer' => $customer, 'replies' => $replies]);
    }

    // Создание задания
    public function actionCreate()
    {
        $this->autoComplete = true;

        if (User::getRole() !== UserRole::CUSTOMER) {
            return $this->redirect('/tasks');
        }

        $model = new TaskCreateForm();

        $rows = Category::find()->orderBy(['id' => SORT_ASC])->all();
        $categories = ['none' => ''] + array_column($rows, 'name', 'id');

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData) && $model->validate() && $task_id = $model->save()) {
                return $this->redirect("/task/$task_id");
            }
        }

        return $this->render('create', ['model' => $model, 'categories' => $categories]);
    }

    // Новый отклик на задание
    public function actionReply($id)
    {
        $model = new ReplyCreateForm();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());
            $model->validate();
            $model->save($id);
        }

        return $this->redirect("/task/$id");
    }

    // Завершение задания
    public function actionComplete($id)
    {
        $model = new TaskCompleteForm();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate() && $model->save($id)) {
                return $this->redirect("/tasks");
            }
        }

        return $this->redirect("/task/$id");
    }

    // Отказ от исполнения задания
    public function actionReject($id)
    {
        $task = Task::findOne($id);
        $task->status = TaskStatus::FAILED;

        $event = new Event();
        $event->user_id = $task->customer_id;
        $event->task_id = $task->id;
        $event->type = "abandon";
        $event->text = "Исполнитель отказался от задания";

        $transaction = Yii::$app->db->beginTransaction();
        if ($task->save() && $event->save()) {
            $transaction->commit();
        } else {
            $transaction->rollback();
        }

        return $this->redirect("/tasks");
    }

    // Отмена задания заказчиком
    public function actionCancel($id)
    {
        $task = Task::findOne($id);
        $task->status = TaskStatus::CANCELED;
        $task->save();

        return $this->redirect("/tasks");
    }

    // Выбор исполнителя задания
    public function actionApply($task_id, $user_id)
    {
        $task = Task::findOne($task_id);
        $task->status = TaskStatus::IN_PROGRESS;
        $task->contractor_id = $user_id;

        $event = new Event();
        $event->user_id = $user_id;
        $event->task_id = $task_id;
        $event->type = "begin";
        $event->text = "Выбран исполнитель для задания";

        $transaction = Yii::$app->db->beginTransaction();
        if ($task->save() && $event->save()) {
            Reply::updateAll(['active' => (integer)false], ['and', ['=', 'task_id', $task_id], ['<>', 'contractor_id', $user_id]]);
            $transaction->commit();
        } else {
            $transaction->rollback();
        }

        return $this->redirect("/task/$task_id");
    }

    // Отклонение отклика
    public function actionRefuse($task_id, $reply_id)
    {
        $reply = Reply::findOne($reply_id);
        $reply->active = (integer)false;
        $reply->save();

        return $this->redirect("/task/$task_id");
    }
}
