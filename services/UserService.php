<?php


namespace app\services;


use app\models\Category;
use app\models\File;
use app\models\ProfileForm;
use app\models\RegistrationForm;
use app\models\SecurityForm;
use app\models\User;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
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

    /**
     * search user by his email in DB
     * @param string $email
     * @return array|ActiveRecord|User|null
     */
    public function getUserByEmail(string $email): array|ActiveRecord|User|null
    {
        return User::find()->where(['email' => $email])->one();
    }

    /**
     * Updating user info in his profile
     * @param ProfileForm $form
     * @param User $user
     * @param File|null $file
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function updateUserProfile(ProfileForm $form, User $user, ?File $file = null): void
    {
        $user->name = $form->name;
        $user->email = $form->email;
        $user->birth_date = $form->birth_date;
        $user->phone = $form->phone;
        $user->telegram = $form->telegram;
        $user->description = $form->description;
        $user->update();

        if (!is_null($file)) {
            $oldAvatar = $user->avatarFile;

            if (!is_null($oldAvatar)) {
                $user->unlink('avatarFile', $oldAvatar);
            }

            $user->link('avatarFile', $file);
        }
    }

    /**
     * Changing and updating user categories in his profile
     * @param array|null $newCategoriesIds
     * @param User $user
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function updateUserCategories(?array $newCategoriesIds, User $user): void
    {
        $oldCategories = $user->categories;

        if (!empty($oldCategories)) {
            foreach ($oldCategories as $oldCategory) {
                $user->unlink('categories', $oldCategory, true);
            }
        }

        if (!is_null($newCategoriesIds)) {
            foreach ($newCategoriesIds as $categoryId) {
                $newCategory = Category::findOne($categoryId);
                $user->link('categories', $newCategory);
            }
        }
    }

    /**
     * Updating user password and contacts visibility
     * @param SecurityForm $securityForm
     * @param User $user
     * @throws Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function updateUserSecurity(SecurityForm $securityForm, User $user): void
    {
        $newPassword = $securityForm->password;

        if (!empty($newPassword)) {
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($securityForm->password);
        }
        $user->is_private = $securityForm->is_private;
        $user->update();
    }

    /**
     * Performer's contacts visibility checking
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public static function showPerformerContacts(User $currentUser, User $user): bool
    {
        if (!$user->is_private) {
            return true;
        }
        if ($currentUser->id === $user->id && $user->is_private) {
            return true;
        }

        if ($currentUser->is_performer === User::ROLE_CUSTOMER && $user->is_private) {
            $currentUserTasks = $currentUser->getTasksWhereUserIsCustomer();
            return $currentUserTasks->where(['performer_id' => $user->id])->exists();
        }

        return false;
    }
}