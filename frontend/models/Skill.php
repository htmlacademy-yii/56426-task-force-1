<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "skill".
 *
 * @property int $id Идентификатор
 * @property string $name Название специализации
 * @property string $dt_add Время создания записи
 *
 * @property UserSkill[] $userSkills
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
            [['dt_add'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
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
            'dt_add' => 'Dt Add',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_skill', ['skill_id' => 'id']);
    }
}
