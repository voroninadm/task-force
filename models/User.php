<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string|null $birth_date
 * @property int $city_id
 * @property string|null $reg_date
 * @property int|null $avatar_file_id
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $telegram
 * @property int|null $done_task
 * @property int|null $failed_task
 * @property float|null $rating
 * @property int $is_performer
 * @property int|null $is_private
 * @property int $is_busy
 *
 * @property File $avatarFile
 * @property Category[] $categories
 * @property City $city
 * @property Response[] $responses
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property UserCategory[] $userCategories
 */
class User extends \yii\db\ActiveRecord
{
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
            [['name', 'city_id', 'email', 'password', 'phone', 'telegram', 'is_performer'], 'required'],
            [['birth_date', 'reg_date'], 'safe'],
            [['city_id', 'avatar_file_id', 'done_task', 'failed_task', 'is_performer', 'is_private', 'is_busy'], 'integer'],
            [['rating'], 'number'],
            [['name', 'email', 'password', 'phone', 'telegram'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['avatar_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['avatar_file_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'birth_date' => 'Дата рождения',
            'city_id' => 'ID города',
            'reg_date' => 'Дата регистрации',
            'avatar_file_id' => 'ID файла-аватарки',
            'email' => 'Email',
            'password' => 'Пароль',
            'phone' => 'Номер телефона',
            'telegram' => 'Telegram-аккаунт',
            'done_task' => 'Выполненные задания',
            'failed_task' => 'Проваленные задания',
            'rating' => 'Рейтинг',
            'is_performer' => 'Является ли заказчиком',
            'is_private' => 'Закрытый ли профиль',
            'is_busy' => 'Занят ли исполнитель',
        ];
    }

    /**
     * Gets query for [[AvatarFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvatarFile()
    {
        return $this->hasOne(File::class, ['id' => 'avatar_file_id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('user_category', ['user_id' => 'id']);
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
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::class, ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategory::class, ['user_id' => 'id']);
    }
}
