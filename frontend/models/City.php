<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id Идентификатор
 * @property string $name Название города
 * @property float|null $lat Широта
 * @property float|null $long Долгота
 * @property string $created_at Время создания записи
 *
 * @property Profile[] $profiles
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['lat', 'long'], 'number'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'name' => 'Название города',
            'lat' => 'Широта',
            'long' => 'Долгота',
            'created_at' => 'Время создания записи'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['city_id' => 'id']);
    }
}
