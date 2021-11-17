<?php

namespace frontend\models;

use yii\base\Model;

class UserFilterForm extends Model
{
    public $skills;
    public $free;
    public $online;
    public $feedback;
    public $favorite;
    public $search;
    public $skillsData;

    public function __construct()
    {
        $skill = Skill::find()->orderBy(['id' => SORT_ASC])->all();
        foreach ($skill as $item) {
            $this->skillsData[$item->id] = ['id' => $item->id, 'name' => $item->name];
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

    public function rules()
    {
        return [
            [['skills', 'free', 'online', 'feedback', 'favorite', 'search'], 'safe']
        ];
    }

    public function reset() {
        $this->skills = [];
        $this->free = 0;
        $this->online = 0;
        $this->feedback = 0;
        $this->favorite = 0;
    }

    public function extraFields() {
        return ['free', 'online', 'feedback', 'favorite'];
    }
}
