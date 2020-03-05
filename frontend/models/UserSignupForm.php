<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class UserSignupForm extends Model
{
    public $email;
    public $name;
    public $city;
    public $password;

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'city' => 'Город проживания',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            [['email', 'name', 'city', 'password'], 'safe'],
            [['email', 'name', 'city', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::className()],
            [['name'], 'string', 'min' => 1],
            [['city'], 'integer'],
            [['city'], 'exist', 'targetClass' => City::className(), 'targetAttribute' => ['city' => 'id']],
            [['password'], 'string', 'min' => 8]
        ];
    }

    public function signup()
    {
        $user = new User();
        $user->email = $this->email;
        $user->name = $this->name;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        if ($user->save()) {
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->city_id = $this->city;
            return $profile->save();
        }
    }
}
