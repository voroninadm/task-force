<?php


namespace app\controllers;


use app\models\Category;
use app\models\ProfileForm;
use yii\helpers\ArrayHelper;

class ProfileController extends SecuredController
{

    public function actionIndex()
    {
        $this->view->title = 'Настройки профиля';

        $user = \Yii::$app->user->identity;
        $profileForm = new ProfileForm;
        $categoriesList = Category::getCategoryList();
        $userCategoriesList = ArrayHelper::getColumn($user->categories, 'id');

     return $this->render('index', [
         'user' => $user,
         'profileForm' => $profileForm,
         'categoriesList' => $categoriesList,
         'userCategoriesList' => $userCategoriesList
     ]);
 }
}