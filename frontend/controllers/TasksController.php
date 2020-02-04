<?php
namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use frontend\models\Task;
use frontend\models\TaskFilterForm;
use HtmlAcademy\Models\TaskStatus;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $query = Task::find()->joinWith('category')->where(['task.status' => TaskStatus::NEW_TASK]);

        $model = new TaskFilterForm();

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData, '') && $model->validate()) {

                // Условие выборки по списку категорий
                $checkedCategories = [];
                foreach ($model->category as $id => $isChecked) {
                    if ($isChecked) {
                        $checkedCategories[] = $id;
                    }
                }
                if (count($checkedCategories)) {
                    $query->andWhere(['task.category_id' => $checkedCategories]);
                }

                // Условие выборки по отсутствию откликов
                if ($model->replies) {
                    $rows = (new Query())->select(['task_id', 'count(*)'])->from('reply')->groupBy('task_id')->orderBy('task_id')->all();
                    $unrepliedTasks = array_column($rows, 'task_id');
                    $query->andWhere(['not in', 'task.id', $unrepliedTasks]);
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

        $tasks = $query->orderBy(['dt_add' => SORT_DESC])->all();

        return $this->render('index', ['tasks' => $tasks, 'model' => $model]);
    }
}
