<?php
namespace frontend\models;

use yii\base\Model;

class TaskFilterForm extends Model
{
    public $category;
    public $replies;
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
        $this->replies = 0;
        $this->location = 0;
        $this->period = "all";
        $this->search = "";
    }

    public function attributeLabels()
    {
        return [
            'category' => $this->categoryLabels,
            'replies' => 'Без откликов',
            'location' => 'Удалённая работа',
            'period' => 'Период',
            'search' => 'Поиск по названию'
        ];
    }

    public function rules()
    {
        return [
            [['category', 'replies', 'location', 'period', 'search'], 'safe']
        ];
    }
}
