<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\Pagination;
use HtmlAcademy\Models\TaskStatus;

class TasksList extends Model
{
    public $tasks;
    public $pages;
    public $cityFilter;
    public $filterForm;

    private $query;

    public function __construct()
    {
        parent::__construct();

        $this->cityFilter = null;
        $this->filterForm = new TaskFilterForm();

        $this->query = Task::find()->joinWith('category')->where(['task.status' => TaskStatus::NEW_TASK]);
    }

    public function addFilterByCity($cityId)
    {
        if (!is_null($cityId)) {
            $this->cityFilter = City::findOne($cityId);
            $this->query->andWhere(['or',
                ['task.city_id' => null],
                ['task.city_id' => $cityId]
            ]);
        }
    }

    public function addFilterByCategory($filter)
    {
        if (isset($filter['category']) && is_numeric($filter['category'])) {
            $this->filterForm->categories = [$filter['category']];
            $this->query->andWhere(['task.category_id' => $filter['category']]);
        }
    }

    public function addFilterByForm($formData)
    {
        if ($this->filterForm->load($formData) && $this->filterForm->validate()) {
            // Условие выборки по отсутствию откликов
            if ($this->filterForm->replies) {
                //LEFT OUTER JOIN
                $this->query->leftJoin('reply', 'reply.task_id = task.id');
                $this->query->andWhere(['or',
                    ['reply.task_id' => null],
                    ['task.id' => null]
                ]);
            }
            // Условие выборки по списку категорий
            if ($this->filterForm->categories) {
                $categories = ['or'];
                foreach ($this->filterForm->categories as $category_id) {
                    $categories[] = [
                        'task.category_id' => $category_id
                    ];
                }
                $this->query->andWhere($categories);
            }
            // Условие выборки по отсутствию локации
            if ($this->filterForm->location) {
                $this->query->andWhere(['task.address' => null]);
            }
            // Условие выборки по периоду времени
            if ($this->filterForm->period === 'day') {
                $this->query->andWhere(['>', 'task.created_at', date("Y-m-d H:i:s", strtotime("- 1 day"))]);
            } elseif ($this->filterForm->period === 'week') {
                $this->query->andWhere(['>', 'task.created_at', date("Y-m-d H:i:s", strtotime("- 1 week"))]);
            } elseif ($this->filterForm->period === 'month') {
                $this->query->andWhere(['>', 'task.created_at', date("Y-m-d H:i:s", strtotime("- 1 month"))]);
            }
            // Условие выборки по совпадению в названии
            if (!empty($this->filterForm->search)) {
                $this->query->andWhere(['like', 'task.name', $this->filterForm->search]);
            }
        }
    }

    public function loadTasks()
    {
        $this->query->orderBy(['created_at' => SORT_DESC]);

        $countQuery = clone $this->query;
        $this->pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5,
            'defaultPageSize' => 5,
            'pageSizeLimit' => [1, 5],
            'forcePageParam' => false
        ]);

        $this->tasks = $this->query->offset($this->pages->offset)->limit($this->pages->limit)->all();
    }
}
