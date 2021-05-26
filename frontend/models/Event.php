<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id Идентификатор
 * @property int $user_id Пользователь
 * @property int $task_id Задание
 * @property int $is_viewed Признак просмотра
 * @property string $type Тип события
 * @property string $text Текст события
 * @property string $created_at Время создания записи
 *
 * @property User $user
 * @property Task $task
 */
class Event extends \yii\db\ActiveRecord
{
    public static function newEventsCount()
    {
        return Event::find()->where([
            'user_id' => Yii::$app->user->getId(),
            'is_viewed' => false
        ])->count();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id', 'type', 'text'], 'required'],
            [['user_id', 'task_id', 'is_viewed'], 'integer'],
            [['type'], 'string'],
            [['created_at'], 'safe'],
            [['text'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']]
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
            'task_id' => 'Задание',
            'is_viewed' => 'Признак просмотра',
            'type' => 'Тип события',
            'text' => 'Текст события',
            'created_at' => 'Время создания записи'
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
