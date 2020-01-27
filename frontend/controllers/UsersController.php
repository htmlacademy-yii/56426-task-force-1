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

        $query = User::find()->joinWith('profile')->joinWith('skills')->joinWith('feedback')->where(['user.id' => $contractors]);

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
                    $checkedSkills = [];
                    foreach ($model->skill as $id => $isChecked) {
                        if ($isChecked) {
                            $checkedSkills[] = $id;
                        }
                    }
                    if (count($checkedSkills)) {
                        $query->andWhere(['skill_id' => $checkedSkills]);
                    }

                    // Условие выборки по отсутствию назначенных заданий

                    // Условие выборки по признаку активности

                    // Условие выборки по наличию отзывов
                    $rows = (new Query())->select(['contractor_id', 'count(*)'])->from('feedback')->groupBy('contractor_id')->orderBy('contractor_id')->all();
                    $feedbacks = array_column($rows, 'contractor_id');
                    if ($model->feedback) {
                        $query->andWhere(['user.id' => $feedbacks]);
                    }
    
                    // Условие выборки по присутствию в избранном

                }
            }
        }

        $users = $query->orderBy(['user.dt_add' => SORT_DESC])->all();

        return $this->render('index', ['users' => $users, 'model' => $model]);
    }
}
