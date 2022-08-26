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
            $user->city_id = $regForm->city_id;
            $user->email = $regForm->email;
            $user->password = Yii::$app->security->generatePasswordHash($regForm->password);
            $user->is_performer = $regForm->is_performer;

            if($user->save()) {
                $this->redirect('tasks');
            } else {
                throw new FormException('Не удалось добавить пользователя');
            }
        }

        return $this->render('index',[
            'regForm' => $regForm,
            'citiesList' => $citiesList

        ]);
    }
}