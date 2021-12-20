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
 * @property string $created_at Время создания записи
 *
 * @property Attachment[] $attachments
 * @property Chat[] $chats
 * @property Reply[] $replies
 * @property Feedback[] $feedbacks
 * @property User $customer
 * @property Category $category
 * @property User $contractor
 * @property Event[] $events
 */
class Task extends \yii\db\ActiveRecord
{
    public function newMessagesCount()
    {
        return Event::find()->where([
            'user_id' => Yii::$app->user->getId(),
            'task_id' => $this->id,
            'is_viewed' => false,
            'type' => 'message'
        ])->count();
    }

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
            [['expire', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['contractor_id' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'customer_id' => 'Заказчик',
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category_id' => 'Категория задания',
            'city_id' => 'Город',
            'address' => 'Адрес',
            'lat' => 'Широта',
            'long' => 'Долгота',
            'budget' => 'Бюджет',
            'status' => 'Статус задания',
            'contractor_id' => 'Исполнитель',
            'expire' => 'Срок завершения работы',
            'created_at' => 'Время создания записи'
        ];
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Contractor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractor()
    {
        return $this->hasOne(User::class, ['id' => 'contractor_id']);
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::class, ['task_id' => 'id']);
    }
}
