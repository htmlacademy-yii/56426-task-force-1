<?php
namespace frontend\models;

use yii\base\Model;

class UserFilterForm extends Model
{
    public $skill;
    public $free;
    public $online;
    public $feedback;
    public $favorite;
    public $search;

    public function __construct() {
        $skill = Skill::find()->orderBy(['id' => SORT_ASC])->all();
        foreach ($skill as $item) {
            $this->skill[$item->id] = $item->name;
        }
    }

    public function attributeLabels()
    {
        return [
            'free' => 'Сейчас свободен',
            'online' => 'Сейчас онлайн',
            'feedback' => 'Есть отзывы',
            'favorite' => 'В избранном',
            'search' => 'Поиск по имени'
        ];
    }
}
