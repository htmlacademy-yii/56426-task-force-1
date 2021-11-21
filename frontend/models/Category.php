<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id Идентификатор
 * @property string $name Название категории задания
 * @property string|null $icon Значок категории
 * @property string $created_at Время создания записи
 *
 * @property Task[] $tasks
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at'], 'safe'],
            [['name', 'icon'], 'string', 'max' => 64],
            [['name'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'name' => 'Название категории задания',
            'icon' => 'Значок категории',
            'created_at' => 'Время создания записи'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['category_id' => 'id']);
    }
}
