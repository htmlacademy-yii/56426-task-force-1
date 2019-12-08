<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id Идентификатор
 * @property int $customer_id Заказчик
 * @property string $name Мне нужно
 * @property string $description Подробности задания
 * @property int $category_id Категория задания
 * @property string|null $address Адрес
 * @property float|null $lat Широта
 * @property float|null $long Долгота
 * @property int|null $budget Бюджет
 * @property string|null $expire Срок завершения работы
 * @property string $dt_add Время создания записи
 *
 * @property Attachment[] $attachments
 * @property Chat[] $chats
 * @property Reply[] $replies
 * @property User $customer
 * @property Category $category
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'name', 'description', 'category_id'], 'required'],
            [['customer_id', 'category_id', 'budget'], 'integer'],
            [['description'], 'string'],
            [['lat', 'long'], 'number'],
            [['expire', 'dt_add'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'name' => 'Name',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'address' => 'Address',
            'lat' => 'Lat',
            'long' => 'Long',
            'budget' => 'Budget',
            'expire' => 'Expire',
            'dt_add' => 'Dt Add',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
