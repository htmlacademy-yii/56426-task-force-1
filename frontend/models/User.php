<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use HtmlAcademy\Models\UserRole;
use HtmlAcademy\Models\TaskStatus;

/**
 * This is the model class for table "user".
 *
 * @property int $id Идентификатор
 * @property string $name Имя пользователя
 * @property string $email E-mail
 * @property string $password Пароль
 * @property string $created_at Время создания записи
 *
 * @property Chat[] $chats
 * @property Feedback[] $feedbacks
 * @property Photo[] $photos
 * @property Profile $profile
 * @property Reply[] $replies
 * @property Settings $settings
 * @property Skill[] $skills
 * @property Task[] $customerTasks
 * @property Task[] $contractorTasks
 */

class User extends ActiveRecord implements IdentityInterface
{
    public static function getAvatar($user_id = null)
    {
        if (is_null($user_id)) {
            $user_id = Yii::$app->user->getId();
        }

        $user_avatar = Yii::$app->params['filesUserPath'].'/'.$user_id.'/'.Yii::$app->params['avatarFileName'];

        return file_exists($user_avatar) ? '/'.$user_avatar.'?'.time() : Yii::$app->params['defaultAvatar'];
    }

    public static function getRole()
    {
        if (UserSkill::find()->where(['user_id' => Yii::$app->user->getId()])->count()) {
            return UserRole::CONTRACTOR;
        }
        return UserRole::CUSTOMER;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function taskCount()
    {
        return count($this->contractorTasksCompleted);
    }

    public function feedbackCount()
    {
        return count($this->feedbacks);
    }

    public function rating()
    {
        $rating = 0;
        if(count($this->feedbacks) > 0) {
            $rating = array_sum(array_column($this->feedbacks, 'rating')) / count($this->feedbacks);
        }
        return $rating;
    }

    public function stars()
    {
        $stars = '';
        for($star = 1; $star <= 5; $star++) {
            if($this->rating() >= $star) {
                $stars .= '<span></span>';
            } else {
                $stars .= '<span class="star-disabled"></span>';
            }
        }
        return $stars;
    }

    // Implement IdentityInterface methods

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Implement findIdentityByAccessToken() method
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // Implement getAuthKey() method
    }

    public function validateAuthKey($authKey)
    {
        // Implement validateAuthKey() method
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['created_at'], 'safe'],
            [['name', 'email', 'password'], 'string', 'max' => 64],
            [['email'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'name' => 'Имя пользователя',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'created_at' => 'Время создания записи'
        ];
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::class, ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::class, ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[Photos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::class, ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[Settings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSettings()
    {
        return $this->hasOne(Settings::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Skills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkills()
    {
        return $this->hasMany(Skill::class, ['id' => 'skill_id'])->viaTable('user_skill', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[ContractorTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractorTasks()
    {
        return $this->hasMany(Task::class, ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[ContractorTasksCompleted]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractorTasksCompleted()
    {
        return $this->hasMany(Task::class, ['contractor_id' => 'id'])->andWhere(['task.status' => TaskStatus::COMPLETED]);
    }
}
