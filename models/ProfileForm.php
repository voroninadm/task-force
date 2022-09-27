<?php


namespace app\models;


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
            [['email'], 'trim'],
            ['email', 'email'],
        ];
    }
}