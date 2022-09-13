<?php


namespace app\models;


use yii\base\Model;

class CreateResponseForm extends Model
{
    public $task_id;
    public $comment;
    public $price;

    public function attributeLabels(): array
    {
        return [
        'task_id' => 'Id Задачи',
        'comment' => 'Ваш комментарий',
        'price' => 'Стоимость',
        ];
    }

    public function rules(): array
    {
        return [
            [['task_id'], 'required'],
            [['task_id', 'price'], 'integer'],
            [['comment'], 'string', 'length' => [3, 50]],
            [['price'], 'integer', 'min' => 1],
            [
                ['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id']
            ]
        ];
    }
}