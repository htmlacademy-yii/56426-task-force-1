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
        $this->free = 0;
        $this->online = 0;
        $this->feedback = 0;
        $this->favorite = 0;
    }
}
