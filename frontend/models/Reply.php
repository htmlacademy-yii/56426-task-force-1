<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "reply".
 *
 * @property int $id Идентификатор
 * @property int $task_id Задание
 * @property int $contractor_id Исполнитель
 * @property int|null $price Цена
 * @property string|null $comment Комментарий
 * @property int $is_active Признак активности
 * @property string $created_at Время создания записи
 *
 * @property Task $task
 * @property User $contractor
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reply';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'contractor_id'], 'required'],
            [['task_id', 'contractor_id', 'price', 'is_active'], 'integer'],
            [['comment'], 'string'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['contractor_id' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'task_id' => 'Задание',
            'contractor_id' => 'Исполнитель',
            'price' => 'Цена',
            'comment' => 'Комментарий',
            'is_active' => 'Признак активности',
            'created_at' => 'Время создания записи'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContractor()
    {
        return $this->hasOne(User::className(), ['id' => 'contractor_id']);
    }
}
