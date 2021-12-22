<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use HtmlAcademy\Models\TaskStatus;
use HtmlAcademy\Models\UserRole;

class UserTasksList extends Model
{
    public $role;
    public $tasks;
    public $status;

    private $query;

    public function __construct()
    {
        parent::__construct();

        $this->status = null;
        $this->role = User::getRole();
        $this->query = Task::find()->joinWith('category');

        if ($this->role === UserRole::CUSTOMER) {
            $this->query->joinWith('contractor')->andWhere(['task.customer_id' => Yii::$app->user->getId()]);
        } else {
            $this->query->joinWith('customer')->andWhere(['task.contractor_id' => Yii::$app->user->getId()]);
        }
    }

    public function applyFilter($filter)
    {
        if (isset($filter['status']) && in_array($filter['status'], TaskStatus::getAllClasses())) {
            $this->status = array_search($filter['status'], TaskStatus::getAllClasses());
            if ($this->status === TaskStatus::CANCELED) {
                $this->query->andWhere(['in', 'task.status', [TaskStatus::CANCELED, TaskStatus::FAILED]]);
            } elseif ($this->status === TaskStatus::FAILED) {
                $this->query->andWhere(['task.status' => TaskStatus::IN_PROGRESS])->andWhere('task.created_at > task.expire');
            } else {
                $this->query->andWhere(['task.status' => $this->status]);
            }
        }
    }

    public function loadTasks()
    {
        $this->tasks = $this->query->orderBy(['created_at' => SORT_DESC])->all();
    }
}
