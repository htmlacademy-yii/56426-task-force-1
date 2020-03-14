<?php

namespace frontend\models;

use yii\base\Model;

class TaskFilterForm extends Model
{
    public $replies;
    public $location;
    public $period;
    public $search;
    public $categories;

    public function attributeLabels()
    {
        return [
            'replies' => 'Без откликов',
            'location' => 'Удалённая работа',
            'period' => 'Период',
            'search' => 'Поиск по названию'
        ];
    }

    public function rules()
    {
        return [
            [['categories', 'replies', 'location', 'period', 'search'], 'safe'],
        ];
    }

    public function extraFields() {
        return ['replies', 'location'];
    }
}
