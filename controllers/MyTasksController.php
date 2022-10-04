<?php


namespace app\controllers;


use app\models\User;
use app\services\TaskService;
use Yii;
use yii\data\ActiveDataProvider;


class MyTasksController extends SecuredController
{
    public function actionIndex()
    {
        $this->view->title = 'Мои задания';

        $taskService = new TaskService();
        $user = Yii::$app->user->identity;

        $status = Yii::$app->request->get('status');
        $titlesList = [
            'new' => 'Новые задания',
            'in_work' => 'Задания в процессе выполнения',
            'overdue' => 'Просроченные задания',
            'closed' => 'Закрытые задания',
        ];

        if ($user->is_performer === User::ROLE_CUSTOMER) {
            $status = $status ?? 'new';
        }

        if ($user->is_performer === User::ROLE_PERFORMER) {
            $status = $status ?? 'in_work';
        }

        $tasksDataProvider = new ActiveDataProvider([
            'query' => $taskService->getMyTasks($user, $status),
            'pagination' => [
                'pageSize' => Yii::$app->params['tasksListSize'],
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ],
            'sort' => [
                'defaultOrder' => [
                    'public_date' => SORT_DESC,
                ]
            ]
        ]);

        return $this->render('index',
            [
                'tasksDataProvider' => $tasksDataProvider,
                'title' => $titlesList[$status],
            ]);
    }
}