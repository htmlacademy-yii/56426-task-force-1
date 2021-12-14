<?php

namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use frontend\models\City;
use frontend\models\User;
use frontend\models\Event;
use frontend\models\UserFilterForm;
use frontend\models\Feedback;
use HtmlAcademy\Models\TaskStatus;

class UsersController extends SecuredController
{
    public $towns;
    public $eventsCount;
    public $sortingRules;

    public function init()
    {
        parent::init();
        $this->towns = City::find()->orderBy(['name' => SORT_ASC])->all();
        $this->eventsCount = Event::newEventsCount();
        $this->sortingRules = [
            'rating' => 'Рейтингу',
            'orders' => 'Числу заказов',
            'feedbacks' => 'Популярности'
        ];
    }

    public function actionIndex($sort = null)
    {
        $query = User::find()->select([
            'user.*',
            '(sum(feedback.rating) / count(feedback.id)) as rating',
            'count(task.id) as orders',
            'count(feedback.id) as feedbacks'
        ]);

        $query->joinWith('profile')->innerJoinWith('skills')->joinWith('contractorTasks')->joinWith('feedbacks');

        $model = new UserFilterForm();

        if (Yii::$app->request->getIsGet()) {
            $data = Yii::$app->request->get();
            if (isset($data['skill'])) {
                $model->skills = [$data['skill']];
                $query->andWhere(['skill.id' => $data['skill']]);
            }
        }

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData) && $model->validate()) {

                // Условие выборки по совпадению в имени
                if (!empty($model->search)) {
                    $model->reset();
                    $query->andWhere(['like', 'user.name', $model->search]);
                } else {
                    // Условие выборки по списку навыков
                    if ($model->skills) {
                        $skills = ['or'];
                        foreach ($model->skills as $skill_id) {
                            $skills[] = [
                                'skill.id' => $skill_id
                            ];
                        }
                        $query->andWhere($skills);
                    }
                    // Условие выборки по отсутствию назначенных заданий
                    if ($model->free) {
                        $query->andWhere(['<>', 'task.status', TaskStatus::IN_PROGRESS]);
                    }
                    // Условие выборки по признаку активности
                    if ($model->online) {
                        $query->andWhere(['>', 'last_activity', date("Y-m-d H:i:s", strtotime("- 30 minutes"))]);
                    }
                    // Условие выборки по наличию отзывов
                    if ($model->feedback) {
                        $query->andWhere(['is not', 'feedback.id', null]);
                    }
                        // Условие выборки по присутствию в избранном
                    if ($model->favorite) {
                        $query->innerJoinWith('favorite');
                    }
                }
            }
        }

        $query->groupBy(['user.id']);

        if (!is_null($sort) && array_key_exists($sort, $this->sortingRules)) {
            $query->orderBy([$sort => SORT_ASC]);
        } else {
            $query->orderBy(['user.created_at' => SORT_DESC]);
        }

        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5,
            'defaultPageSize' => 5,
            'pageSizeLimit' => [1, 5],
            'forcePageParam' => false
        ]);

        $users = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', ['users' => $users, 'model' => $model, 'sort' => $sort, 'pages' => $pages]);
    }

    public function actionView($id)
    {
        $user = User::find()->joinWith('profile')->innerJoinWith('skills')->joinWith('contractorTasks')->joinWith('photos')->where(['user.id' => $id])->one();
        if (!$user) {
            throw new NotFoundHttpException("Исполнитель с ID $id не найден");
        }
        $feedbacks = Feedback::find()->joinWith('task')->where(['feedback.contractor_id' => $id])->all();
        return $this->render('view', ['user' => $user, 'feedbacks' => $feedbacks]);
    }
}
