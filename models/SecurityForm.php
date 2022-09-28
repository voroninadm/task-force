<?php


namespace app\models;


use Yii;
use yii\base\Model;

class SecurityForm extends Model
{
    public $old_password;
    public $password;
    public $password_repeat;
    public $is_private;

    public function attributeLabels(): array
    {
        return [
            'old_password' => 'Текущий пароль',
            'password' => 'Новый пароль',
            'password_repeat' => 'Повтор нового пароля',
            'is_private' => 'Мои контактные данные видны только заказчику',
        ];
    }

    public function rules(): array
    {
        return [
            [['old_password'], 'validatePassword'],
            [['old_password', 'password', 'password_repeat'], 'string', 'max' => 255],
            [['password', 'password_repeat'], 'string', 'min' => Yii::$app->params['minUserPasswordLength']],
            [['is_private'], 'boolean'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password']
            ];
    }

    public function validatePassword($attribute): void
    {
        $user = Yii::$app->user->identity;

        if (!$user->validatePassword($this->old_password)) {
            $this->addError($attribute, 'Неправильный старый пароль');
        }
    }
}