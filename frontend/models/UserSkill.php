<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_skill".
 *
 * @property int $id Идентификатор
 * @property int $user_id Пользователь
 * @property int $skill_id Специализация
 *
 * @property User $user
 * @property Skill $skill
 */
class UserSkill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'skill_id'], 'required'],
            [['user_id', 'skill_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skill::class, 'targetAttribute' => ['skill_id' => 'id']]
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
            'skill_id' => 'Специализация'
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
    public function getSkill()
    {
        return $this->hasOne(Skill::class, ['id' => 'skill_id']);
    }
}
