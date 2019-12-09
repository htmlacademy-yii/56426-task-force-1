<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id Идентификатор
 * @property string $email E-mail
 * @property string $password Пароль
 * @property string $name Имя пользователя
 * @property string $dt_add Время создания записи
 *
 * @property Chat[] $chats
 * @property Profile $profile
 * @property Reply[] $replies
 * @property Task[] $tasks
 * @property UserSkill[] $userSkills
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'name'], 'required'],
            [['dt_add'], 'safe'],
            [['email', 'password', 'name'], 'string', 'max' => 64],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'name' => 'Name',
            'dt_add' => 'Dt Add',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['contractor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::className(), ['contractor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSkills()
    {
        return $this->hasMany(UserSkill::className(), ['user_id' => 'id']);
    }
}
