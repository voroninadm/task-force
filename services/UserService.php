<?php


namespace app\services;


use app\models\RegistrationForm;
use app\models\User;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;


class UserService
{
    /**
     * create user after registration
     * @throws Exception
     */
    public function createUser(RegistrationForm $form): user
    {
        $user = new User();
        $user->loadDefaultValues();
        $user->name = $form->name;
        $user->avatar_file_id = 1;
        $user->city_id = $form->city_id;
        $user->email = $form->email;
        $user->password = Yii::$app->security->generatePasswordHash($form->password);
        $user->is_performer = intval($form->is_performer);

        if ($user->save()) {
            //assign role to new registered user
            $auth = Yii::$app->authManager;
            $customerRole = $auth->getRole('customer');
            $performerRole = $auth->getRole('performer');

            if ($user->is_performer === User::ROLE_CUSTOMER) {
                $auth->assign($customerRole, $user->id);
            }

            if ($user->is_performer === User::ROLE_PERFORMER) {
                $auth->assign($performerRole, $user->id);
            }
        } else {
            throw new Exception('Не удалось зарегистрировать пользователя');
        }
        return $user;
    }

    /**
    * count performer's rating
     * @param User $user
     * @return float
     */
    public function countUserPerformerRating(User $user): float
    {
        $reviews = $user->countUserPerformerRating;

        $reviewsCount = count($reviews);
        $reviewsRateSum = array_sum(ArrayHelper::getColumn($reviews, 'grade'));
        $userFailedTasksCount = $user->failed_task;

        return round($reviewsRateSum / ($reviewsCount + $userFailedTasksCount), 2);
    }
}