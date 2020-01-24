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

    private $skillLabels;

    public function __construct() {
        $skill = Skill::find()->orderBy(['id' => SORT_ASC])->all();
        foreach ($skill as $item) {
            $this->skill[$item->id] = 0;
            $this->skillLabels[$item->id] = $item->name;
        }
        $this->free = 0;
        $this->online = 0;
        $this->feedback = 0;
        $this->favorite = 0;
        $this->search = "";
    }

    public function attributeLabels()
    {
        return [
            'skill' => $this->skillLabels,
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
            [['skill', 'free', 'online', 'feedback', 'favorite', 'search'], 'safe']
        ];
    }
}
