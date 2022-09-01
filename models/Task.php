<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string|null $public_date
 * @property string $status
 * @property string $title
 * @property string $description
 * @property int $category_id
 * @property int $city_id
 * @property string|null $address
 * @property float $lat
 * @property float $lng
 * @property int|null $price
 * @property string|null $deadline
 * @property int $customer_id
 * @property int|null $performer_id
 *
 * @property Category $category
 * @property City $city
 * @property User $customer
 * @property File[] $files
 * @property User $performer
 * @property Response[] $responses
 * @property Review[] $reviews
 * @property TaskFile[] $taskFiles
 */
class Task extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in_work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    const STATUSES_RU = [
        self::STATUS_NEW => 'Новое задание',
        self::STATUS_CANCELED => 'Задание отменено',
        self::STATUS_IN_WORK => 'Задание в работе',
        self::STATUS_DONE => 'Задание завершено',
        self::STATUS_FAILED => 'Задание провалено'
    ];


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
            [['public_date', 'deadline'], 'safe'],
            [['status', 'title', 'description', 'category_id', 'customer_id'], 'required'],
            [['category_id', 'city_id', 'price', 'customer_id', 'performer_id'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['status', 'title', 'description', 'address'], 'string', 'max' => 255],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::class,
                'targetAttribute' => ['category_id' => 'id']
            ],
            [
                ['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::class,
                'targetAttribute' => ['city_id' => 'id']
            ],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['customer_id' => 'id']
            ],
            [
                ['performer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['performer_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'public_date' => 'Дата публикации',
            'status' => 'Статус',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'category_id' => 'ID категории задания',
            'city_id' => 'ID города задания',
            'address' => 'Адрес',
            'lat' => 'Широта',
            'lng' => 'Долгота',
            'price' => 'Цена за выполнение задания',
            'deadline' => 'Дедлайн задания',
            'customer_id' => 'ID заказчика',
            'performer_id' => 'ID исполнителя',
        ];
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
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFiles(): \yii\db\ActiveQuery
    {
        return $this->hasMany(File::class, ['id' => 'file_id'])->viaTable('task_file', ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Performer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformer(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'performer_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFile::class, ['task_id' => 'id']);
    }
}
