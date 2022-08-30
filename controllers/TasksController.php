<?php


namespace app\controllers;


use app\models\Category;
use app\models\File;
use app\models\Response;
use app\models\TaskFile;
use app\models\TaskFilterForm;
use app\services\TasksFilterServices;
use taskforce\classes\exceptions\NotFoundHttpException;
use app\models\Task;
use Yii;
use yii\data\ActiveDataProvider;

class TasksController extends SecuredController
{

    /**
     * to new tasks page
     * @return string
     */
    public function actionIndex(): string
    {
        $this->view->title = 'Новые задания';

        $categoriesList = Category::getCategoryList();

        $filterForm = new TaskFilterForm();

        $filterForm->load(Yii::$app->request->get());


        $query = (new TasksFilterServices())->filterTasks($filterForm);
        $tasksDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['tasksListSize'],
            ],
            'sort' => [
                'defaultOrder' => [
                    'public_date' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'tasksDataProvider' => $tasksDataProvider,
            'filterForm' => $filterForm,
            'categoriesList' => $categoriesList,
        ]);
    }

    /**
     * to view $id task page
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $task = Task::findOne($id);
        if (!$task) {
            throw new NotFoundHttpException("Задание с ID $id не найдено");
        }

        $this->view->title = "$task->title :: Taskforce";

        $taskStatusNameRu = Task::STATUSES_RU[$task->status];

        $responses = Response::find()
            ->where(['task_id' => $id])
            ->all();

        $files = $task->files;

        return $this->render('view',
            [
                'task' => $task,
                'taskStatusNameRu' => $taskStatusNameRu,
                'responses' => $responses,
                'files' => $files
            ]);
    }

    public function actionCreate()
    {
        $this->view->title = "Новое задание :: Taskforce";

        return $this->render('create');
    }

}