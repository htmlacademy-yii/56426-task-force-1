<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "notice".
 *
 * @property int $id Идентификатор
 * @property int $secrecy Признак скрытности
 * @property string $name Название уведомления
 * @property string $created_at Время создания записи
 *
 * @property UserNotice[] $userNotices
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['secrecy', 'name'], 'required'],
            [['secrecy'], 'integer'],
            [['created_at'], 'safe'],
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
            'secrecy' => 'Secrecy',
            'name' => 'Name',
            'created_at' => 'Dt Add',
        ];
    }

    /**
     * Gets query for [[UserNotices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotices()
    {
        return $this->hasMany(UserNotice::className(), ['notice_id' => 'id']);
    }
}
