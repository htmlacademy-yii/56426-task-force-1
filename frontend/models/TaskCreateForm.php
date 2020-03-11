<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use HtmlAcademy\Models\TaskStatus;

class TaskCreateForm extends Model
{
    public $name;
    public $description;
    public $category;
    public $budget;
    public $expire;

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'budget' => 'Бюджет',
            'expire' => 'Срок исполнения'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'description', 'category', 'budget', 'expire'], 'safe'],
            [['name', 'description', 'category', 'budget', 'expire'], 'required'],
            [['name'], 'string', 'min' => 1],
            [['description'], 'string', 'min' => 1],
            [['category'], 'integer'],
            [['category'], 'exist', 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
            [['budget'], 'integer', 'min' => 1],
            [['expire'], 'date', 'format' => 'php:%d.%m.%Y']
        ];
    }

    public function save()
    {
        $task = new Task();

        $task->customer_id = Yii::$app->user->getId();
        $task->status = TaskStatus::NEW_TASK;

        $task->name = $this->name;
        $task->description = $this->description;
        $task->category = $this->category;
        $task->budget = $this->budget;
        $task->expire = $this->expire;

        return $task->save();
    }
}
