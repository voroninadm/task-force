<?php


namespace app\controllers;


use app\models\City;
use app\models\RegistrationForm;
use app\models\User;
use taskforce\classes\exceptions\FormException;
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

        //Ajax form validation
        if (Yii::$app->request->isAjax && $regForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($regForm);
        }

        //validation and saving new user
        if($regForm->load(Yii::$app->request->post()) && $regForm->validate())
        {
            $user = new User();
            $user->loadDefaultValues();
            $user->name = $regForm->name;
            $user->avatar_file_id = 1;
            $user->city_id = $regForm->city_id;
            $user->email = $regForm->email;
            $user->password = Yii::$app->security->generatePasswordHash($regForm->password);
            $user->is_performer = intval($regForm->is_performer);

            if($user->save()) {
                // role to new registered user
                $auth = Yii::$app->authManager;
                $customerRole = $auth->getRole('customer');
                $performerRole = $auth->getRole('performer');

                if ($user->is_performer === User::ROLE_CUSTOMER) {
                    $auth->assign($customerRole, $user->id);
                }

                if ($user->is_performer === User::ROLE_PERFORMER) {
                    $auth->assign($performerRole, $user->id);
                }

                //auto login when registration is successful
                $identity = User::findOne($user->id);
                Yii::$app->user->login($identity);
            } else {
                throw new FormException('Не удалось добавить пользователя');
            }
            $this->redirect('/tasks');
        }

        return $this->render('index',[
            'regForm' => $regForm,
            'citiesList' => $citiesList

        ]);
    }
}