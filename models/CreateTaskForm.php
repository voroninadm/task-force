<?php


namespace app\models;


use Yii;
use yii\base\Model;

class CreateTaskForm extends Model
{
    public $title;
    public $description;
    public $category_id;
    public $location;
    public $address;
    public $city;
    public $lat;
    public $long;
    public $price;
    public $deadline;
    public $files;

    public function attributeLabels(): array
    {
        return [
            'title' => 'Опишите суть работы',
            'description' => 'Подробности задания',
            'category_id' => 'Категория',
            'location' => 'Локация',
            'address' => 'Адрес задания',
            'city' => 'Город задания',
            'lat' => 'Широта',
            'long' => 'Долгота',
            'price' => 'Бюджет',
            'deadline' => 'Срок исполнения',
            'files' => 'Файлы'

        ];
    }

    public function rules(): array
    {
        return [
            [['title', 'description', 'category_id'], 'required'],
            [['title'], 'string', 'length' => [10, 255]],
            [['description'], 'string', 'min' => 30],
            [['category_id', 'price'], 'integer'],
            [['lat', 'long'], 'double'],
            [['title','description','deadline', 'address', 'city', 'location'], 'string'],
            [
                'category_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::class,
                'targetAttribute' => ['category_id' => 'id']
            ],
            [
                ['deadline'],
                'date',
                'format' => 'php:Y-m-d',
                'min' => date('Y-m-d'),
                'max' => date('Y-m-d', strtotime('+1 year', strtotime('now'))),
                'tooSmall' => 'Срок исполнения не ранее текущего дня',
                'tooBig' => 'Задачи со сроком исполнения более года недоступны'
            ],
            [['price'], 'integer', 'min' => 1],
            [
                ['files'],
                'file',
                'maxFiles' => Yii::$app->params['maxFilesToTask'],
                'tooMany' => "Не более " .Yii::$app->params['maxFilesToTask'] . " файлов"
            ],
            [
                ['location'],
                'showLocationErrorMessage',
                'when' => fn($model) => $model->city !== Yii::$app->user->identity->city->name
            ],
        ];

    }

    public function showLocationErrorMessage($attribute, $params)
    {
        $this->addError($attribute, 'Вы можете указывать адрес только в рамках города, указанного при регистрации!');
    }
}

