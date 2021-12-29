<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property int $id Идентификатор
 * @property int $user_id Пользователь
 * @property string $file Файл
 * @property string $name Имя файла
 *
 * @property User $user
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'file', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 64],
            [['file'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']]
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
            'file' => 'Файл',
            'name' => 'Имя файла'
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
