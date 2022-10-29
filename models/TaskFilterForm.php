<?php


namespace app\models;


use yii\base\Model;

class TaskFilterForm extends Model
{
    public $categories;
    public $withoutPerformer;
    public $period;
    public $remote;

    const PERIOD_VALUES = [
        '1' => 'час',
        '24' => 'сутки',
        '168' => 'неделя',
    ];

    public function attributeLabels(): array
    {
        return [
            'withoutPerformer' => 'Без исполнителя',
            'remote' => 'Удаленная работа',
        ];
    }


    public function rules(): array
    {
        return [
            [['categories', 'withoutPerformer', 'period', 'remote'], 'safe']
        ];
    }

}