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
 * @property string|null $telegram Телеграм
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
            [['user_id', 'city_id'], 'integer'],
            [['birthday', 'last_activity'], 'safe'],
            [['about'], 'string'],
            [['address'], 'string', 'max' => 255],
            [['phone', 'skype', 'telegram'], 'string', 'max' => 64],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'user_id' => 'Пользователь',
            'city_id' => 'Город',
            'address' => 'Адрес',
            'birthday' => 'День рождения',
            'about' => 'Информация о себе',
            'phone' => 'Номер телефона',
            'skype' => 'Скайп',
            'telegram' => 'Телеграм',
            'last_activity' => 'Время последней активности'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
}
