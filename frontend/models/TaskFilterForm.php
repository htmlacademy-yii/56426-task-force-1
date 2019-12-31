<?php
namespace frontend\models;

use yii\base\Model;

class TaskFilterForm extends Model
{
    public $category;
    public $city;
    public $location;
    public $period;
    public $search;

    public function __construct() {
        $category = Category::find()->orderBy(['id' => SORT_ASC])->all();
        foreach ($category as $item) {
            $this->category[$item->id] = $item->name;
        }
    }

    public function attributeLabels()
    {
        return [
            'city' => 'Мой город',
            'location' => 'Удалённая работа',
            'period' => 'Период',
            'search' => 'Поиск по названию'
        ];
    }
}
