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
 * @property string $dt_add Время создания записи
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
            [['dt_add'], 'safe'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'lat' => 'Lat',
            'long' => 'Long',
            'dt_add' => 'Dt Add',
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
