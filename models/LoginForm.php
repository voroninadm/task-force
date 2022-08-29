<?php


namespace app\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    private $_user = null;

    public function attributeLabels(): array
    {
        return [
            'email' => 'EMAIL',
            'password' => 'ПАРОЛЬ',
        ];
    }

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], 'safe'],
            ['email', 'email'],
            [
                'email',
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['email' => 'email'],
                'message' => 'Пользователя с таким e-mail не существует',
            ],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный пароль');
            }
        }
    }

    public function getUser(): ?User
    {
        if (is_null($this->_user)) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}