<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use HtmlAcademy\Tools\GeoCoder;
use HtmlAcademy\Models\TaskStatus;

class TaskCreateForm extends Model
{
    public $name;
    public $description;
    public $category;
    public $location;
    public $budget;
    public $expire;

    public $task_files;

    private $saved_files;

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'task_files' => 'Файлы',
            'location' => 'Локация',
            'budget' => 'Бюджет',
            'expire' => 'Срок исполнения'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'description', 'category', 'location', 'budget', 'expire', 'task_files'], 'safe'],
            [['name', 'description', 'category', 'budget', 'expire'], 'required'],
            [['name', 'description', 'location'], 'string'],
            [['category'], 'exist', 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
            [['budget'], 'integer', 'min' => 1],
            [['expire'], 'date', 'format' => 'php:Y-m-d'],
            [['task_files'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 6]
        ];
    }

    public function save()
    {
        $task = new Task();

        $task->customer_id = Yii::$app->user->getId();
        $task->status = TaskStatus::NEW_TASK;

        $task->name = $this->name;
        $task->description = $this->description;
        $task->category_id = $this->category;
        $task->budget = $this->budget;
        $task->expire = $this->expire;

        $task->city_id = null;
        $task->address = null;
        $task->long = null;
        $task->lat = null;

        if (!empty($this->location)) {

            // Запрос геоданных для указанной локации
            $geocode = new GeoCoder($this->location);

            // Извлечение строки с адресом
            $task->address = $geocode->getAddress();

            // Извлечение координат
            $task_position = $geocode->getPosition();
            $task->long = $task_position['long'];
            $task->lat = $task_position['lat'];

            // Извлечение названия города
            $task_city_name = $geocode->getCityName();

            // Поиск города в БД и создание при отсутствии
            if (!is_null($task_city_name)) {
                $task_city = City::findOne(['name' => $task_city_name]);
                if (is_null($task_city)) {
                    $task_city = new City();
                    $task_city->name = $task_city_name;
                    // Запрос геоданных для нового города
                    $geocode->setLocation($task_city_name);
                    $city_position = $geocode->getPosition();
                    $task_city->long = $city_position['long'];
                    $task_city->lat = $city_position['lat'];
                    $task_city->save();
                }
                $task->city_id = $task_city->id;
            }

        }

        // Сохранение новой задачи
        if ($task->save()) {
            return $task->id;
        }

        return false;
    }

    public function upload($task_id)
    {
        $path = Yii::$app->params['filesTaskPath'].'/'.$task_id;

        if (!file_exists($path)) {
            if (!mkdir($path, 0755, true)) {
                return false;
            }
        }

        $this->saved_files = [];
        foreach ($this->task_files as $file) {
            $fileName = $path.'/'.$file->baseName.'.'.$file->extension;
            if ($file->saveAs($fileName)) {
                $this->saved_files[] = ['file' => $fileName, 'name' => $file->baseName];
            }
        }

        foreach ($this->saved_files as $file) {
            $attachment = new Attachment();
            $attachment->task_id = $task_id;
            $attachment->file = $file['file'];
            $attachment->name = $file['name'];
            $attachment->save();
        }

        return true;
    }
}
