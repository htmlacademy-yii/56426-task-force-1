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
            [['email'], 'unique', 'targetClass' => User::class],
            [['name'], 'string', 'min' => 1],
            [['city'], 'integer'],
            [['city'], 'exist', 'targetClass' => City::class, 'targetAttribute' => ['city' => 'id']],
            [['password'], 'string', 'min' => 8]
        ];
    }

    public function signup()
    {
        $user = new User();
        $user->name = htmlspecialchars($this->name);
        $user->email = $this->email;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);

        $profile = new Profile();
        $settings = new Settings();

        $transaction = Yii::$app->db->beginTransaction();

        $user_is_saved = (boolean)$user->save();

        if ($user_is_saved) {
            $profile->user_id = $user->id;
            $profile->city_id = $this->city;
            $settings->user_id = $user->id;
        }

        if ($user_is_saved && $profile->save() && $settings->save()) {
            $transaction->commit();
            return true;
        } else {
            $transaction->rollBack();
            return false;
        }
    }
}
