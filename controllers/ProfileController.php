<?php


namespace app\controllers;


use app\models\Category;
use app\models\ProfileForm;
use app\models\RoleForm;
use app\models\SecurityForm;
use app\models\Task;
use app\models\User;
use app\services\FileService;
use app\services\UserService;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
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

    public function actionRole(): string
    {
        if (Yii::$app->user->identity->is_performer !== null) {
            throw new ForbiddenHttpException('Вам недоступна эта страница');
        }
        $this->view->title = 'Выбор роли';

        $roleForm = new RoleForm();
        $currentUser = Yii::$app->user->identity;

        if (Yii::$app->request->getIsPost()) {
            $roleForm->load(Yii::$app->request->post());

            if ($roleForm->validate()) {
                $currentUser->is_performer = $roleForm->is_performer;
                $currentUser->update();

                $auth = Yii::$app->authManager;
                $customerRole = $auth->getRole('customer');
                $performerRole = $auth->getRole('performer');
                if ($currentUser->is_performer === User::ROLE_PERFORMER) {
                    $auth->assign($performerRole, $currentUser->id);
                }
                if ($currentUser->is_performer === User::ROLE_CUSTOMER) {
                    $auth->assign($customerRole, $currentUser->id);
                }

                $this->redirect(['tasks/']);
            }
        }

        return $this->render('role', [
            'roleForm' => $roleForm
        ]);
    }
}