<?php


namespace app\controllers;


use app\models\Category;
use app\models\ProfileForm;
use app\models\SecurityForm;
use app\models\User;
use app\services\FileService;
use app\services\UserService;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class ProfileController extends SecuredController
{

    public function actionIndex(): Response|string|array
    {
        $this->view->title = 'Настройки профиля';

        $user = Yii::$app->user->identity;
        $fileService = new FileService();
        $userService = new UserService();
        $profileForm = new ProfileForm;
        $categoriesList = Category::getCategoryList();
        $userCategoriesList = ArrayHelper::getColumn($user->categories, 'id');

        if (Yii::$app->request->getIsPost()) {
            $profileForm->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($profileForm);
            }

            if ($profileForm->validate()) {
                $avatar = null;
                $uploadedFile = UploadedFile::getInstance($profileForm, 'avatar');
                if (!empty($uploadedFile)) {
                    $avatar = $fileService->upload($uploadedFile, 'avatar', $user->id);
                }

                $userService->updateUserProfile($profileForm, $user, $avatar);

                if ($user->is_performer === User::ROLE_PERFORMER) {
                    $userService->updateUserCategories($profileForm->categories, $user);
                }

                if ($user->is_performer === User::ROLE_CUSTOMER) {
                    return $this->refresh();
                }

                return $this->redirect(['user/view', 'id' => $user->id]);
            }
        }

     return $this->render('index', [
         'user' => $user,
         'profileForm' => $profileForm,
         'categoriesList' => $categoriesList,
         'userCategoriesList' => $userCategoriesList
     ]);
 }

 public function actionSecurity(): string|array|Response
 {
     $this->view->title = 'Настройки безопасности и приватности';

     $userService = new UserService();
     $securityForm = new SecurityForm();
     $user = Yii::$app->user->identity;

     if (Yii::$app->request->getIsPost()) {
         $securityForm->load(Yii::$app->request->post());

         if (Yii::$app->request->isAjax) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($securityForm);
         }

         if ($securityForm->validate()) {
             $userService->updateUserSecurity($securityForm, $user);

             if ($user->is_performer === User::ROLE_CUSTOMER) {
                 return $this->refresh();
             }

             return $this->redirect(['user/view', 'id' => $user->id]);
         }
     }

     return $this->render('security', [
         'securityForm' => $securityForm,
         'user' => $user
     ]);
 }
}