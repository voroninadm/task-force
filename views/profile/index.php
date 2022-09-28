<?php

/**
 * @var ProfileController $user
 * @var ProfileController $profileForm
 * @var ProfileController $categoriesList
 * @var ProfileController $userCategoriesList
 */

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="left-menu left-menu--edit">
    <h3 class="head-main head-task">Настройки</h3>
    <?= $this->render('_menu') ?>
</div>
<div class="my-profile-form">
    <?php $form = ActiveForm::begin([
            'id' => 'profileForm',
            'enableAjaxValidation' => true,
            'fieldConfig' => [
                'errorOptions' => [
                    'tag' => 'span',
                    'class' => 'help-block'
                ]
            ]
        ]) ?>
    <h3 class="head-main head-regular">Мой профиль</h3>
        <div class="photo-editing">
            <div>
                <p class="form-label">Аватар</p>
                <?= Html::img($user->avatarFile->url, [
                    'class' => 'avatar-preview',
                    'alt' => 'Аватар',
                    'width' => 83,
                    'height' => 83,
                ]) ?>
            </div>
            <?= $form->field($profileForm, 'avatar')
                ->fileInput(['id' => 'button-input', 'hidden' => true])
                ->label('Сменить аватар', ['class' => 'button button--black']) ?>
        </div>

        <?= $form->field($profileForm, 'name')->textInput(['value' => $user->name]) ?>

        <div class="half-wrapper">
        <?= $form->field($profileForm, 'email')->textInput(['type' => 'email', 'value' => $user->email]) ?>
        <?= $form->field($profileForm, 'birth_date')->textInput(['type' => 'date', 'value' => $user->birth_date ?? '']) ?>
        </div>

        <div class="half-wrapper">
            <?= $form->field($profileForm, 'phone')->textInput(['type' => 'tel', 'value' => $user->phone ?? '']) ?>
            <?= $form->field($profileForm, 'telegram')->textInput(['value' => $user->telegram ?? '']) ?>
        </div>

    <?= $form->field($profileForm, 'description')->textarea(['value' => $user->description ?? '']) ?>

    <div class="form-group--categories">
    <?php if ($user->is_performer === User::ROLE_PERFORMER): ?>
        <?= $form->field($profileForm, 'categories[]', [
            'template' => '{label}{input}',
        ])->checkboxList($categoriesList, [
            'tag' => 'div',
            'class' => 'checkbox-profile',
            'item' => function ($index, $label, $name, $checked, $value) use ($userCategoriesList) {
                $labelClass = 'control-label';
                $checked = in_array($value, $userCategoriesList) ? 'checked' : '';
                $input = "<input type='checkbox' name='$name' value='$value' $checked>";

                return "<label class={$labelClass}> {$input} {$label} </label>";
            },
            'unselect' => null,
        ]) ?>
    </div>
    <?php endif; ?>

    <?= Html::submitButton('Сохранить', ['class' => 'button button--blue']) ?>
        <?php ActiveForm::end() ?>
</div>
