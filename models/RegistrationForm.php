<?php


namespace app\models;


use yii\base\Model;

class RegistrationForm extends Model
{
   public $name;
   public $email;
   public $city_id;
   public $password;
   public $password_repeat;
   public $is_performer;

    public function attributeLabels(): array
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city_id' => 'Город',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'is_performer' => 'Отклик на задания',
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'email', 'city_id', 'password', 'password_repeat'], 'required'],
            [['email'], 'email'],
            [['name', 'email', 'password', 'password_repeat'], 'string', 'max' => 255],
            [['password', 'password_repeat'], 'string', 'min' => 5],
            [['city_id', 'is_performer'], 'integer'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            [
                'email',
                'unique',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['email' => 'email']
            ],
            [
                'city_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => City::class,
                'targetAttribute' => ['city_id' => 'id']
            ],

        ];
    }


}