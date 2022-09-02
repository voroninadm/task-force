<?php

/**
 * @var RegistrationController $citiesList
 * @var RegistrationController $regForm
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="center-block">
    <div class="registration-form regular-form">
        <?php $form = ActiveForm::begin([
                'id' => 'registrationForm',
            'enableAjaxValidation' => true,
                'fieldConfig' => [
                    'errorOptions' => [
                        'tag' => 'span',
                        'class' => 'help-block'
                    ]
                ]
        ]) ?>
        <h3 class="head-main head-task">Регистрация нового пользователя</h3>

        <div class="form-group">
            <?= $form->field($regForm, 'name') ?>
        </div>
        <div class="half-wrapper">
            <div class="form-group">
                <?= $form->field($regForm, 'email')->textInput(['type' => 'email']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($regForm, 'city_id')->dropDownList($citiesList) ?>
            </div>
        </div>
            <div class="form-group">
                <?= $form->field($regForm, 'password')->passwordInput() ?>
            </div>
            <div class="form-group">
                <?= $form->field($regForm, 'password_repeat')->passwordInput() ?>
            </div>
        <div class="form-group">
            <?= $form->field($regForm, 'is_performer')
                ->checkbox(['checked' => true,
                            'label' => 'я собираюсь откликаться на заказы',
                            'labelOptions' => ['class' => 'control-label checkbox-label']
                ]);
            ?>
        </div>
        <?= Html::submitButton('Создать аккаунт', ['class' => 'button button--blue']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>