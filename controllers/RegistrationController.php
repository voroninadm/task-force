<?php


namespace app\controllers;


use app\models\City;
use app\models\RegistrationForm;
use app\services\UserService;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RegistrationController extends GuestController
{
    public function actionIndex(): array|string
    {
        $this->view->title = 'Регистрация пользователя';

        $regForm = new RegistrationForm();
        $citiesList = City::getCitiesList();

        if (Yii::$app->request->getIsPost()) {
            $regForm->load(Yii::$app->request->post());

            //Ajax form validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($regForm);
            }

            //validation and saving new user
            if ($regForm->validate()) {
                $userService = new UserService();
                $user = $userService->createUser($regForm);
                Yii::$app->user->login($user);

                //auto login when registration is successful
                Yii::$app->user->login($user);
                $this->redirect('/tasks');
            }
        }

        return $this->render('index', [
            'regForm' => $regForm,
            'citiesList' => $citiesList

        ]);
    }
}