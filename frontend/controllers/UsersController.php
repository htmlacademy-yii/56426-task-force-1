<?php

namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\UserFilterForm;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $rows = (new Query())->select(['user_id', 'count(*)'])->from('user_skill')->groupBy('user_id')->orderBy('user_id')->all();
        $contractors = array_column($rows, 'user_id');

        $query = User::find()->joinWith('profile')->joinWith('skills')->joinWith('contractorTasks')->joinWith('feedbacks')->where(['user.id' => $contractors]);

        $model = new UserFilterForm();

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData, '') && $model->validate()) {

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
                                'skills.id' => $skill + 1
                            ];
                        }
                        $query->andWhere($skills);
                    }
                    // Условие выборки по отсутствию назначенных заданий
                    if ($model->free) {
                        $rows = (new Query())->select(['contractor_id', 'count(*)'])->from('task')->where(['task.status' => '1'])->groupBy('contractor_id')->orderBy('contractor_id')->all();
                        $inProgress = array_column($rows, 'contractor_id');
                        $query->andWhere(['not in', 'user.id', $inProgress]);
                    }
                    // Условие выборки по признаку активности
                    if ($model->online) {
                        $query->andWhere(['>', 'last_activity', date("Y-m-d H:i:s", strtotime("- 30 minutes"))]);
                    }
                    // Условие выборки по наличию отзывов
                    if ($model->feedback) {
                        $rows = (new Query())->select(['contractor_id', 'count(*)'])->from('feedback')->groupBy('contractor_id')->orderBy('contractor_id')->all();
                        $feedbacks = array_column($rows, 'contractor_id');
                        $query->andWhere(['user.id' => $feedbacks]);
                    }
                        // Условие выборки по присутствию в избранном
                    if ($model->favorite) {
                        $rows = (new Query())->select(['user_id'])->from('favorite')->orderBy('user_id')->all();
                        $favorites = array_column($rows, 'user_id');
                        $query->andWhere(['user.id' => $favorites]);
                    }
                }
            }
        }

        $users = $query->orderBy(['user.dt_add' => SORT_DESC])->all();

        return $this->render('index', ['users' => $users, 'model' => $model]);
    }
}
