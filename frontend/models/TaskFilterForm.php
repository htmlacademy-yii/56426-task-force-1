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

    private $categoryLabels;

    public function __construct()
    {
        $category = Category::find()->orderBy(['id' => SORT_ASC])->all();
        foreach ($category as $item) {
            $this->category[$item->id] = 0;
            $this->categoryLabels[$item->id] = $item->name;
        }
        $this->city = 0;
        $this->location = 0;
        $this->period = "all";
        $this->search = "";
    }

    public function attributeLabels()
    {
        return [
            'category' => $this->categoryLabels,
            'city' => 'Мой город',
            'location' => 'Удалённая работа',
            'period' => 'Период',
            'search' => 'Поиск по названию'
        ];
    }

    public function rules()
    {
        return [
            [['category', 'city', 'location', 'period', 'search'], 'safe']
        ];
    }
}
