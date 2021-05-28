<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

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
    public $telegram;

    public $skills;

    public $task_actions;
    public $new_message;
    public $new_reply;
    public $hide_contacts;
    public $hide_profile;

    public $avatar;
    public $image_files;

    private $user;
    private $profile;
    private $settings;

    private $saved_files;

    function __construct()
    {
        $this->loadAccountData(Yii::$app->user->getId());
    }

    public function attributeLabels()
    {
        return [
            'avatar' => 'Сменить аватар',
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city' => 'Город',
            'birthday' => 'День рождения',
            'about' => 'Информация о себе',
            'password' => 'Новый пароль',
            'password_retype' => 'Повтор пароля',
            'image_files' => 'Выбрать фотографии',
            'phone' => 'Телефон',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'task_actions' => 'Действия по заданию',
            'new_message' => 'Новое сообщение',
            'new_reply' => 'Новый отклик',
            'hide_contacts' => 'Показывать мои контакты только заказчику',
            'hide_profile' => 'Не показывать мой профиль'
        ];
    }

    public function rules()
    {
        return [
            [['avatar', 'name', 'email', 'city', 'birthday', 'about', 'password', 'password_retype', 'image_files', 'phone', 'skype', 'telegram', 'skills', 'task_actions', 'new_message', 'new_reply', 'hide_contacts', 'hide_profile'], 'safe'],
            [['birthday', 'about', 'phone', 'skype', 'telegram'], 'default'],
            [['name', 'email', 'city'], 'required'],
            [['name'], 'string', 'min' => 1],
            [['email'], 'email'],
            [['email'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => ['email' => 'email']],
            [['city'], 'integer'],
            [['city'], 'exist', 'targetClass' => City::className(), 'targetAttribute' => ['city' => 'id']],
            [['password'], 'string', 'min' => 8],
            [['password'], 'compare', 'compareAttribute' => 'password_retype'],
            [['avatar'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg', 'maxFiles' => 1],
            [['image_files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'maxFiles' => 6]
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
        $this->profile->telegram = $this->telegram;

        $this->settings->task_actions = (int)$this->task_actions;
        $this->settings->new_message = (int)$this->new_message;
        $this->settings->new_reply = (int)$this->new_reply;
        $this->settings->hide_contacts = (int)$this->hide_contacts;
        $this->settings->hide_profile = (int)$this->hide_profile;

        UserSkill::deleteAll(['user_id' => Yii::$app->user->getId()]);
        $allSkills = Skill::find()->asArray()->all();
        $skills = is_array($this->skills) ? $this->skills : [];
        foreach ($skills as $skillNumber) {
            $userSkill = new UserSkill();
            $userSkill->user_id = Yii::$app->user->getId();
            $userSkill->skill_id = $allSkills[$skillNumber]['id'];
            $userSkill->save();
        }

        $files = is_array($this->saved_files) ? $this->saved_files : [];
        foreach ($files as $image) {
            $photo = new Photo();
            $photo->user_id = Yii::$app->user->getId();
            $photo->file = $image['file'];
            $photo->name = $image['name'];
            $photo->save();
        }

        $transaction = Yii::$app->db->beginTransaction();
        if ($this->user->save() && $this->profile->save() && $this->settings->save()) {
            $transaction->commit();
            return true;
        } else {
            $transaction->rollback();
            return false;
        }
    }

    public function upload()
    {
        $path = 'files/user/'.Yii::$app->user->getId();

        if (!file_exists($path)) {
            if (!mkdir($path, 0755, true)) {
                return false;
            }
        }

        if (!is_null($this->avatar) && $this->avatar->extension === 'jpg') {
            $this->avatar->saveAs($path.'/avatar.jpg');
        }

        $this->saved_files = [];
        foreach ($this->image_files as $file) {
            $fileName = $path.'/'.$file->baseName.'.'.$file->extension;
            if ($file->saveAs($fileName)) {
                $this->saved_files[] = ['file' => $fileName, 'name' => $file->baseName];
            }
        }

        return true;
    }

    public function loadAccountData($userId)
    {
        // Загрузка данных из user
        $this->user = User::findOne($userId);
        if (is_null($this->user)) {
            return false;
        }

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->password = null;
        $this->password_retype = null;

        // Загрузка данных из profile
        $this->profile = Profile::find()->where(['user_id' => $userId])->one();
        if (is_null($this->profile)) {
            $this->profile = new Profile();
            $this->profile->user_id = $userId;
        }

        $this->city = $this->profile->city_id;
        $this->birthday = $this->profile->birthday;
        $this->about = $this->profile->about;
        $this->phone = $this->profile->phone;
        $this->skype = $this->profile->skype;
        $this->telegram = $this->profile->telegram;

        // Загрузка данных из settings
        $this->settings = Settings::find()->where(['user_id' => $userId])->one();
        if (is_null($this->settings)) {
            $this->settings = new Settings();
            $this->settings->user_id = $userId;
        }
        
        $this->task_actions = (bool)$this->settings->task_actions;
        $this->new_message = (bool)$this->settings->new_message;
        $this->new_reply = (bool)$this->settings->new_reply;
        $this->hide_contacts = (bool)$this->settings->hide_contacts;
        $this->hide_profile = (bool)$this->settings->hide_profile;

        // Список всех навыков
        $allSkills = Skill::find()->asArray()->all();

        // Список идентификаторов навыков пользователя
        $userSkills = array_column($this->user->skills, 'id');

        // Список порядковых номеров галочек
        $this->skills = [];
        foreach ($allSkills as $key => $value) {
            if (in_array($value['id'], $userSkills)) {
                $this->skills[] = $key;
            }
        }

        return true;
    }

    public function clearSettings()
    {
        $this->task_actions = false;
        $this->new_message = false;
        $this->new_reply = false;
        $this->hide_contacts = false;
        $this->hide_profile = false;
    }

    public function convertSettings()
    {
        $this->task_actions = (bool)$this->task_actions;
        $this->new_message = (bool)$this->new_message;
        $this->new_reply = (bool)$this->new_reply;
        $this->hide_contacts = (bool)$this->hide_contacts;
        $this->hide_profile = (bool)$this->hide_profile;
    }
}
