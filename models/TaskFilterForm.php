<?php


namespace app\models;


use yii\base\Model;

class TaskFilterForm extends Model
{
    public $categories;
    public $withoutPerformer;
    public $period;

    const PERIOD_VALUES = [
        '1' => '1 час',
        '12' => '12 часов',
        '24' => '24 часа',
    ];

    public function attributeLabels(): array
    {
        return [
            'withoutPerformer' => 'Без исполнителя',
        ];
    }


    public function rules(): array
    {
        return [
            [['categories', 'withoutPerformer', 'period'], 'safe']
        ];
    }

}