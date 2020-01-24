<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\UserFilterForm;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $query = User::find()->joinWith('profile')->joinWith('skills');

        $model = new UserFilterForm();

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData, '') && $model->validate()) {

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

                // Условие выборки по присутствию в избранном

                // Условие выборки по совпадению в имени
                if (!empty($model->search)) {
                    $query->andWhere(['like', 'user.name', $model->search]);
                }

            }
        }

        $users = $query->orderBy(['dt_add' => SORT_DESC])->all();

        return $this->render('index', ['users' => $users, 'model' => $model]);
    }
}
