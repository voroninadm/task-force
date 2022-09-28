<?php

/**
 * @var SecurityForm $securityForm
 * @var SecurityForm $user
 */

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>

<div class="left-menu left-menu--edit">
    <h3 class="head-main head-task">Настройки</h3>
    <?= $this->render('_menu') ?>
</div>
<div class="my-profile-form">
    <?php $form = ActiveForm::begin([
        'id' => 'securityForm',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'errorOptions' => [
                'tag' => 'span',
                'class' => 'help-block'
            ]
        ]
    ]) ?>
    <h3 class="head-main head-regular">Изменение пароля и приватность</h3>

    <?= $form->field($securityForm, 'old_password')->passwordInput() ?>
    <?= $form->field($securityForm, 'password')->passwordInput() ?>
    <?= $form->field($securityForm, 'password_repeat')->passwordInput() ?>

    <?php if ($user->is_performer === User::ROLE_PERFORMER): ?>
        <?= $form->field($securityForm, 'is_private')->checkbox(['checked' => (bool)$user->is_private], true) ?>
    <?php endif; ?>

    <?= Html::submitButton('Сохранить', ['class' => 'button button--blue']) ?>
    <?php ActiveForm::end() ?>
</div>

