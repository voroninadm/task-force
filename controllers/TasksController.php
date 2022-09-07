<?php


namespace app\controllers;


use app\models\CreateReviewForm;
use app\models\CreateTaskForm;
use app\models\Category;
use app\models\File;
use app\models\Response;
use app\models\TaskFile;
use app\models\TaskFilterForm;
use app\services\TaskService;
use app\services\UploadFileService;
use app\models\Task;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

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


        $query = (new TaskService())->filterTasks($filterForm);
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
     * to view $id task at personal page
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function actionView(int $id): string
    {
        $task = Task::findOne($id);
        if (!$task) {
            throw new Exception("Задание с ID $id не найдено");
        }

        $this->view->title = "$task->title :: Taskforce";

        $taskStatusNameRu = Task::STATUSES_RU[$task->status];

        $responses = Response::find()
            ->where(['task_id' => $id])
            ->all();

        $files = $task->files;

        $reviewForm = new CreateReviewForm();

        return $this->render('view',
            [
                'task' => $task,
                'taskStatusNameRu' => $taskStatusNameRu,
                'responses' => $responses,
                'files' => $files,
                'reviewForm' => $reviewForm
            ]);
    }

    /**
     * Create new task
     * @return array|string|\yii\web\Response
     * @throws Exception
     */
    public function actionCreate(): \yii\web\Response|array|string
    {
        $this->view->title = "Создать задание :: Taskforce";

        $user = Yii::$app->user->identity;
        $categoriesList = Category::getCategoryList();
        $createTaskForm = new CreateTaskForm();

        //Ajax form validation
        if (Yii::$app->request->isAjax && $createTaskForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($createTaskForm);
        }

        //validate and create new task
        if($createTaskForm->load(Yii::$app->request->post()) && $createTaskForm->validate()) {
            $uploadedFiles = UploadedFile::getInstances($createTaskForm, 'files');
            $task = (new TaskService())->createTask($createTaskForm);

            if (!empty($uploadedFiles)) {
                foreach ($uploadedFiles as $uploadedFile) {
                    $file = (new UploadFileService())->upload($uploadedFile, 'task', $task->id);
                    $task->link('files', $file);
                }
            }
            return $this->redirect(['tasks/view', 'id' => $task->id]);
        }

        return $this->render('create', [
            'createTaskForm' => $createTaskForm,
            'categoriesList' => $categoriesList
        ]);
    }

    public function actionCancel(int $id): \yii\web\Response
    {
        $task = Task::findOne($id);

        if (!$task) {
            throw new Exception("Задание с id=$id не найдено");
        }

        $user = Yii::$app->user->identity;
        $taskService = new TaskService();

        if ($user->id === $task->customer_id && $task->status === Task::STATUS_NEW) {
            $taskService->cancelTask($task);
        }

        return $this->redirect(['tasks/view', 'id' => $id]);
    }

}