<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id Идентификатор
 * @property int $task_id Задание
 * @property int $sender_id Отправитель
 * @property int $recipient_id Получатель
 * @property string $message Текст сообщения
 * @property string $created_at Время создания записи
 *
 * @property Task $task
 * @property User $sender
 * @property User $recipient
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'sender_id', 'recipient_id', 'message'], 'required'],
            [['task_id', 'sender_id', 'recipient_id'], 'integer'],
            [['created_at'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['recipient_id' => 'id']]
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
            'sender_id' => 'Отправитель',
            'recipient_id' => 'Получатель',
            'message' => 'Текст сообщения',
            'created_at' => 'Время создания записи'
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::class, ['id' => 'sender_id']);
    }

    /**
     * Gets query for [[Recipient]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::class, ['id' => 'recipient_id']);
    }
}
