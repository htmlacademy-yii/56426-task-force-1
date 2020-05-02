<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_notice".
 *
 * @property int $id Идентификатор
 * @property int $user_id Пользователь
 * @property int $notice_id Уведомление
 *
 * @property User $user
 * @property Notice $notice
 */
class UserNotice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_notice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'notice_id'], 'required'],
            [['user_id', 'notice_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['notice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notice::className(), 'targetAttribute' => ['notice_id' => 'id']],
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
            'notice_id' => 'Notice ID',
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
     * Gets query for [[Notice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotice()
    {
        return $this->hasOne(Notice::className(), ['id' => 'notice_id']);
    }
}
