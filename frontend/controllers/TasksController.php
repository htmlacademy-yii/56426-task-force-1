<?php

namespace frontend\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use frontend\models\City;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\Event;
use frontend\models\Reply;
use frontend\models\Category;
use frontend\models\TasksList;
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

        $tasksList = new TasksList();

        $tasksList->addFilterByCity(Yii::$app->session->get('userCity'));

        if (Yii::$app->request->getIsGet()) {
            $tasksList->addFilterByCategory(Yii::$app->request->get());
        }

        if (Yii::$app->request->getIsPost()) {
            $tasksList->addFilterByForm(Yii::$app->request->post());
        }

        $tasksList->loadTasks();

        return $this->render('index', [
            'tasks' => $tasksList->tasks,
            'model' => $tasksList->filterForm,
            'pages' => $tasksList->pages,
            'cityFilter' => $tasksList->cityFilter
        ]);
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

        $query = Reply::find()->joinWith('task')->joinWith('contractor')->where(['reply.task_id' => $task->id])->andWhere(['reply.is_active' => true]);
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
            $model->load(Yii::$app->request->post());
            $model->task_files = UploadedFile::getInstances($model, 'task_files');
            if ($model->validate() && $task_id = $model->save()) {
                $model->upload($task_id);
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
        $transaction = Yii::$app->db->beginTransaction();

        $task = Task::findOne($id);
        $task->status = TaskStatus::FAILED;
        $taskSaveResult = $task->save();

        $event = new Event();
        $event->user_id = $task->customer_id;
        $event->task_id = $task->id;
        $event->type = "abandon";
        $event->text = "Исполнитель отказался от задания";
        if ($event->isActivated()) {
            $eventSaveResult = $event->save();
        } else {
            $eventSaveResult = true;
        }

        if ($taskSaveResult && $eventSaveResult) {
            $transaction->commit();
        } else {
            $transaction->rollBack();
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
        $transaction = Yii::$app->db->beginTransaction();

        $task = Task::findOne($task_id);
        $task->status = TaskStatus::IN_PROGRESS;
        $task->contractor_id = $user_id;
        $taskSaveResult = $task->save();

        $event = new Event();
        $event->user_id = $user_id;
        $event->task_id = $task_id;
        $event->type = "begin";
        $event->text = "Выбран исполнитель для задания";
        if ($event->isActivated()) {
            $eventSaveResult = $event->save();
        } else {
            $eventSaveResult = true;
        }

        if ($taskSaveResult && $eventSaveResult) {
            Reply::updateAll(['is_active' => (integer)false], ['and', ['=', 'task_id', $task_id], ['<>', 'contractor_id', $user_id]]);
            $transaction->commit();
        } else {
            $transaction->rollBack();
        }

        return $this->redirect("/task/$task_id");
    }

    // Отклонение отклика
    public function actionRefuse($task_id, $reply_id)
    {
        $reply = Reply::findOne($reply_id);
        $reply->is_active = (integer)false;
        $reply->save();

        return $this->redirect("/task/$task_id");
    }
}
