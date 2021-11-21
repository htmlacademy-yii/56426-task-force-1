<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "attachment".
 *
 * @property int $id Идентификатор
 * @property int $task_id Задание
 * @property string $file Файл
 * @property string $name Имя файла
 *
 * @property Task $task
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'file', 'name'], 'required'],
            [['task_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 64],
            [['file'], 'unique'],
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
            'task_id' => 'Задание',
            'file' => 'Файл',
            'name' => 'Имя файла'
        ];
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
