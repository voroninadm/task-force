<?php


namespace app\models;


use yii\base\Model;

class CreateReviewForm extends Model
{
    public $description;
    public $grade;
    public $task_id;
    public $author_id;
    public $user_id;

    public function attributeLabels(): array
    {
        return [
            'description' => 'Ваш комментарий',
            'grade' => 'Оценка работы',
            'task_id' => 'Task ID',
            'author_id' => 'Author ID',
            'user_id' => 'User ID',
        ];
    }

    public function rules(): array
    {
        return [
            [['description', 'grade', 'task_id', 'author_id', 'user_id'], 'required'],
            [['grade', 'task_id', 'author_id', 'user_id'], 'integer'],
            [['description'],'string', 'length' => [5, 255]],
            [
                ['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['task_id' => 'id']
            ],
            [
                ['author_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['author_id' => 'id']
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }
}