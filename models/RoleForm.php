<?php

declare(strict_types=1);


namespace app\models;


use yii\base\Model;

class RoleForm extends Model
{
    public int $is_performer = 0;

    public function attributeLabels(): array
    {
        return [
            'is_performer' => 'я собираюсь откликаться на заказы',
        ];
    }

    public function rules(): array
    {
        return [
            [['is_performer'], 'boolean']
        ];
    }
}