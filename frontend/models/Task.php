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
 * @property int|null $city_id Город
 * @property string|null $address Адрес
 * @property float|null $lat Широта
 * @property float|null $long Долгота
 * @property int|null $budget Бюджет
 * @property int $status Статус задания
 * @property int|null $contractor_id Исполнитель
 * @property string|null $expire Срок завершения работы
 * @property string $dt_add Время создания записи
 *
 * @property Attachment[] $attachments
 * @property Chat[] $chats
 * @property Job[] $jobs
 * @property Reply[] $replies
 * @property Feedback[] $feedbacks
 * @property User $customer
 * @property Category $category
 * @property User $contractor
 * @property File[] $files
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
            [['customer_id', 'name', 'description', 'category_id', 'status'], 'required'],
            [['customer_id', 'category_id', 'city_id', 'budget', 'status', 'contractor_id'], 'integer'],
            [['description'], 'string'],
            [['lat', 'long'], 'number'],
            [['expire', 'dt_add'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['contractor_id' => 'id']],
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
            'city_id' => 'City ID',
            'address' => 'Address',
            'lat' => 'Lat',
            'long' => 'Long',
            'budget' => 'Budget',
            'status' => 'Status',
            'contractor_id' => 'Contractor ID',
            'expire' => 'Expire',
            'dt_add' => 'Dt Add',
        ];
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Jobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
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
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])->viaTable('attachment', ['task_id' => 'id']);
    }
}
