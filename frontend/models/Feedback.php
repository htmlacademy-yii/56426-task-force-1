<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id Идентификатор
 * @property int $contractor_id Исполнитель
 * @property int $task_id Задание
 * @property string $rating Оценка
 * @property string $description Текст отзыва
 * @property string $created_at Время создания записи
 *
 * @property User $contractor
 * @property Task $task
 */
class Feedback extends \yii\db\ActiveRecord
{

    public function ratingClass()
    {
        switch ($this->rating){
            case 1:
                $ratingClass = 'one-rate';
                break;
            case 2:
                $ratingClass = 'two-rate';
                break;
            case 3:
                $ratingClass = 'three-rate';
                break;
            case 4:
                $ratingClass = 'four-rate';
                break;
            case 5:
                $ratingClass = 'five-rate';
                break;
            default:
                $ratingClass = '';
        }

        return $ratingClass;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contractor_id', 'task_id', 'rating', 'description'], 'required'],
            [['contractor_id', 'task_id'], 'integer'],
            [['rating', 'description'], 'string'],
            [['created_at'], 'safe'],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['contractor_id' => 'id']],
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
            'contractor_id' => 'Исполнитель',
            'task_id' => 'Задание',
            'rating' => 'Оценка',
            'description' => 'Текст отзыва',
            'created_at' => 'Время создания записи'
        ];
    }

    /**
     * Gets query for [[Contractor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractor()
    {
        return $this->hasOne(User::className(), ['id' => 'contractor_id']);
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
