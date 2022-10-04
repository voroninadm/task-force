<?php


namespace app\models;


use Yii;
use yii\base\Model;

class ProfileForm extends Model
{
    public $avatar;
    public $name;
    public $email;
    public $birth_date;
    public $phone;
    public $telegram;
    public $description;
    public $categories;

    public function attributeLabels(): array
    {
        return [
            'avatar' => 'Аватар',
            'name' => 'Ваше имя',
            'email' => 'Email',
            'birth_date' => 'День рождения',
            'phone' => 'Номер телефона',
            'telegram' => 'Telegram',
            'description' => 'Информация о себе',
            'categories' => 'Выбор специализаций'
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'email'], 'required'],
            [['avatar'], 'image', 'extensions' => ['gif', 'jpg', 'jpeg', 'png']],
            [['avatar', 'birth_date', 'phone', 'telegram', 'description', 'categories'], 'default', 'value' => null],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone'], 'string', 'length' => [11, 11]],
            [['telegram'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 255],
            [['birth_date'], 'date', 'format' => 'php:Y-m-d'],
            [
                'email',
                'unique',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => 'email',
                'when' => fn($model) => $model->email !== Yii::$app->user->identity->email,
            ],
            [
                'categories',
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::class,
                'targetAttribute' => 'id',
                'allowArray' => true,
            ],
        ];
    }
}