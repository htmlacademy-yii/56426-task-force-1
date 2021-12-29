<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use HtmlAcademy\Models\TaskStatus;

class UsersList extends Model
{
    public $users;
    public $pages;
    public $filterForm;
    public $sortingRules;

    private $query;

    public function __construct()
    {
        parent::__construct();

        $this->filterForm = new UserFilterForm();

        $this->sortingRules = [
            'rating' => 'Рейтингу',
            'orders' => 'Числу заказов',
            'feedbacks' => 'Популярности'
        ];

        $this->query = User::find()->select([
            'user.*',
            '(sum(feedback.rating) / count(feedback.id)) as rating',
            'count(task.id) as orders',
            'count(feedback.id) as feedbacks'
        ]);

        $this->query->joinWith('profile')->innerJoinWith('skills')->joinWith('contractorTasks')->joinWith('feedbacks');
    }

    public function addFilterBySkill($filter)
    {
        if (isset($filter['skill']) && is_numeric($filter['skill'])) {
            $this->filterForm->skills = [$filter['skill']];
            $this->query->andWhere(['skill.id' => $filter['skill']]);
        }
    }

    public function addFilterByForm($formData)
    {
        if ($this->filterForm->load($formData) && $this->filterForm->validate()) {
            // Условие выборки по совпадению в имени
            if (!empty($this->filterForm->search)) {
                $this->filterForm->reset();
                $this->query->andWhere(['like', 'user.name', $this->filterForm->search]);
            } else {
                // Условие выборки по списку навыков
                if ($this->filterForm->skills) {
                    $skills = ['or'];
                    foreach ($this->filterForm->skills as $skill_id) {
                        $skills[] = [
                            'skill.id' => $skill_id
                        ];
                    }
                    $this->query->andWhere($skills);
                }
                // Условие выборки по отсутствию назначенных заданий
                if ($this->filterForm->free) {
                    $this->query->andWhere(['<>', 'task.status', TaskStatus::IN_PROGRESS]);
                }
                // Условие выборки по признаку активности
                if ($this->filterForm->online) {
                    $this->query->andWhere(['>', 'last_activity', date("Y-m-d H:i:s", strtotime("- 30 minutes"))]);
                }
                // Условие выборки по наличию отзывов
                if ($this->filterForm->feedback) {
                    $this->query->andWhere(['is not', 'feedback.id', null]);
                }
                    // Условие выборки по присутствию в избранном
                if ($this->filterForm->favorite) {
                    $this->query->innerJoinWith('favorite');
                }
            }
        }
    }

    public function loadUsers($sort)
    {
        $this->query->groupBy(['user.id']);

        if (!is_null($sort) && array_key_exists($sort, $this->sortingRules)) {
            $this->query->orderBy([$sort => SORT_DESC]);
        } else {
            $this->query->orderBy(['user.created_at' => SORT_DESC]);
        }

        $countQuery = clone $this->query;

        $this->users = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'totalCount' => $countQuery->count(),
                'pageSize' => 5,
                'defaultPageSize' => 5,
                'pageSizeLimit' => [1, 5],
                'forcePageParam' => false
            ]
        ]);

        $this->pages = $this->users->pagination;
    }
}
