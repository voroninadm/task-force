<?php


namespace app\controllers;


use app\models\Category;
use app\models\TaskFilterForm;
use app\services\TasksFilterServices;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class TasksController extends Controller
{

    public function actionIndex(): ?string
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

}