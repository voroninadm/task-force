<?php


namespace app\models;


use yii\base\Model;

class AddTaskForm extends Model
{
    public $title;
    public $description;
    public $category_id;
    public $address;
    public $price;
    public $deadline;

    public function attributeLabels(): array
    {
        return [
            'title' => 'Опишите суть работы',
            'description' => 'Подробности задания',
            'category_id' => 'Категория',
            'address' => 'Локация',
            'price' => 'Бюджет',
            'deadline' => 'Срок исполнения',

        ];
    }

}