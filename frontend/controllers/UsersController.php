<?php

namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\User;
use frontend\models\UserFilterForm;
use HtmlAcademy\Models\TaskStatus;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $query = User::find()->joinWith('profile')->innerJoinWith('skills')->joinWith('contractorTasks')->joinWith('feedbacks');

        $model = new UserFilterForm();

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
                        foreach ($model->skills as $skill) {
                            $skills[] = [
                                'skill.id' => $skill + 1
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

        $users = $query->orderBy(['user.dt_add' => SORT_DESC])->all();

        return $this->render('index', ['users' => $users, 'model' => $model]);
    }

    public function actionView($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("Исполнитель с ID $id не найден");
        }
        return $this->render('view', ['user' => $user]);
    }
}
