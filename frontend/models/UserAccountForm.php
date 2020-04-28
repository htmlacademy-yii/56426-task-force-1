<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class UserSignupForm extends Model
{
    public $name;
    public $email;
    public $city;
    public $birthday;
    public $about;
    public $password;
    public $repassword;
    public $phone;
    public $skype;
    public $messenger;

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city' => 'Город',
            'birthday' => 'День рождения',
            'about' => 'Информация о себе',
            'password' => 'Новый пароль',
            'repassword' => 'Повтор пароля',
            'phone' => 'Телефон',
            'skype' => 'Skype',
            'messenger' => 'Telegram'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'email', 'city', 'birthday', 'about', 'password', 'phone', 'skype', 'messenger'], 'safe'],
            [['name', 'email', 'city', 'password'], 'required'],
            [['name'], 'string', 'min' => 1],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::className()],
            [['city'], 'integer'],
            [['city'], 'exist', 'targetClass' => City::className(), 'targetAttribute' => ['city' => 'id']],
            [['password'], 'string', 'min' => 8]
        ];
    }

    public function save()
    {
        $userId = Yii::$app->user->getId();

        $user = User::findOne($userId);
        $profile = Profile::find()->where(['user_id' => $userId])->one();

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        
        $profile->city_id = $this->city;
        $profile->birthday = $this->birthday;
        $profile->about = $this->about;
        $profile->phone = $this->phone;
        $profile->skype = $this->skype;
        $profile->messenger = $this->messenger;

        $transaction = Yii::$app->db->beginTransaction();
        if ($user->save() && $profile->save()) {
            $transaction->commit();
            return true;
        } else {
            $transaction->rollback();
            return false;
        }
    }
}
