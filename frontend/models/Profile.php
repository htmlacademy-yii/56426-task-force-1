<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id Идентификатор
 * @property int $user_id Пользователь
 * @property int|null $city_id Город
 * @property string|null $address Адрес
 * @property string|null $birthday День рождения
 * @property string|null $about Информация о себе
 * @property string|null $phone Номер телефона
 * @property string|null $skype Скайп
 * @property string|null $messenger Другой мессенджер
 * @property string $last_activity Время последней активности
 *
 * @property User $user
 * @property City $city
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'city_id', 'new_message', 'task_action', 'new_job', 'show_contacts'], 'integer'],
            [['birthday'], 'safe'],
            [['about'], 'string'],
            [['address'], 'string', 'max' => 255],
            [['phone', 'skype', 'messenger'], 'string', 'max' => 64],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'city_id' => 'City ID',
            'address' => 'Address',
            'birthday' => 'Birthday',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'messenger' => 'Messenger'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
