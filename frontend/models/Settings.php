<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $id Идентификатор
 * @property int $user_id Пользователь
 * @property int $task_actions Действия по заданию
 * @property int $new_message Новое сообщение
 * @property int $new_feedback Новый отзыв
 * @property int $show_contacts Показывать мои контакты только заказчику
 * @property int $hide_profile Не показывать мой профиль
 *
 * @property User $user
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'task_actions', 'new_message', 'new_feedback', 'show_contacts', 'hide_profile'], 'integer'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_actions' => 'Task Actions',
            'new_message' => 'New Message',
            'new_feedback' => 'New Feedback',
            'show_contacts' => 'Show Contacts',
            'hide_profile' => 'Hide Profile',
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
}
