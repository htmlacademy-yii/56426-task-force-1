<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "skill".
 *
 * @property int $id Идентификатор
 * @property string $name Название специализации
 * @property string $created_at Время создания записи
 *
 * @property User[] $user
 */
class Skill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 64],
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
            'name' => 'Название специализации',
            'created_at' => 'Время создания записи'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('user_skill', ['skill_id' => 'id']);
    }
}
