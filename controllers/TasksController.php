<?php


namespace app\controllers;


use app\models\CreateTaskForm;
use app\models\Category;
use app\models\File;
use app\models\Response;
use app\models\TaskFile;
use app\models\TaskFilterForm;
use app\services\CreateTaskService;
use app\services\TasksFilterServices;
use app\services\UploadFileService;
use taskforce\classes\exceptions\NotFoundHttpException;
use app\models\Task;
use Yii;
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
            $task = (new CreateTaskService())->createTask($createTaskForm);

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

}