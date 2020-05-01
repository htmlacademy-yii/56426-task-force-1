<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class UserAccountForm extends Model
{
    public $name;
    public $email;
    public $city;
    public $birthday;
    public $about;
    public $password;
    public $password_retype;
    public $phone;
    public $skype;
    public $messenger;

    private $user;
    private $profile;

    function __construct()
    {
        $this->loadAccountData(Yii::$app->user->getId());
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city' => 'Город',
            'birthday' => 'День рождения',
            'about' => 'Информация о себе',
            'password' => 'Новый пароль',
            'password_retype' => 'Повтор пароля',
            'phone' => 'Телефон',
            'skype' => 'Skype',
            'messenger' => 'Telegram'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'email', 'city', 'birthday', 'about', 'password', 'password_retype', 'phone', 'skype', 'messenger'], 'safe'],
            [['name', 'email', 'city'], 'required'],
            [['name'], 'string', 'min' => 1],
            [['email'], 'email'],
            [['email'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => ['email' => 'email']],
            [['city'], 'integer'],
            [['city'], 'exist', 'targetClass' => City::className(), 'targetAttribute' => ['city' => 'id']],
            [['password'], 'string', 'min' => 8],
            [['password'], 'compare', 'compareAttribute' => 'password_retype']
        ];
    }

    public function save()
    {
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        if (!empty($this->password)) {
            $this->user->password = Yii::$app->security->generatePasswordHash($this->password);
        }
        
        $this->profile->city_id = $this->city;
        $this->profile->birthday = $this->birthday;
        $this->profile->about = $this->about;
        $this->profile->phone = $this->phone;
        $this->profile->skype = $this->skype;
        $this->profile->messenger = $this->messenger;

        $transaction = Yii::$app->db->beginTransaction();
        if ($this->user->save() && $this->profile->save()) {
            $transaction->commit();
            return true;
        } else {
            $transaction->rollback();
            return false;
        }
    }

    public function loadAccountData($userId)
    {
        $this->user = User::findOne($userId);
        $this->profile = Profile::find()->where(['user_id' => $userId])->one();

        if (is_null($this->user) || is_null($this->profile)) return false;

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->password = null;
        $this->password_retype = null;
        
        $this->city = $this->profile->city_id;
        $this->birthday = $this->profile->birthday;
        $this->about = $this->profile->about;
        $this->phone = $this->profile->phone;
        $this->skype = $this->profile->skype;
        $this->messenger = $this->profile->messenger;

        return true;
    }
}
