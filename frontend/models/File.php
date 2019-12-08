<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id Идентификатор
 * @property string $path Путь к файлу
 * @property string $original_name Оригинальное имя файла
 * @property string $dt_add Время создания записи
 *
 * @property Attachment[] $attachments
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'original_name'], 'required'],
            [['dt_add'], 'safe'],
            [['path', 'original_name'], 'string', 'max' => 255],
            [['path'], 'unique'],
            [['original_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'original_name' => 'Original Name',
            'dt_add' => 'Dt Add',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['file_id' => 'id']);
    }
}
