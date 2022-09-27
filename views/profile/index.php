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
use yii\widgets\Menu;

?>

<div class="left-menu left-menu--edit">
    <h3 class="head-main head-task">Настройки</h3>
    <?= Menu::widget([
        'options' => [
            'class' => 'side-menu-list',
        ],
        'itemOptions' => [
            'class' => 'side-menu-item',
        ],
        'activeCssClass' => 'side-menu-item--active',
        'items' => [
            ['label' => 'Мой профиль', 'url' => ['profile/index']],
            ['label' => 'Безопасность', 'url' => ['profile/security']]
        ],
        'linkTemplate' => '<a class="link link--nav" href="{url}">{label}</a>',
    ]) ?>
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

        <?= $form->field($profileForm, 'name')->textInput() ?>

        <div class="half-wrapper">
        <?= $form->field($profileForm, 'email')->textInput(['type' => 'email']) ?>
        <?= $form->field($profileForm, 'birth_date')->textInput(['type' => 'date']) ?>
        </div>

        <div class="half-wrapper">
            <?= $form->field($profileForm, 'phone')->textInput(['type' => 'tel']) ?>
            <?= $form->field($profileForm, 'telegram')->textInput() ?>
        </div>

    <?= $form->field($profileForm, 'description')->textarea() ?>

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
    <?php endif; ?>

    <?= Html::submitButton('Сохранить', ['class' => 'button button--blue']) ?>
        <?php ActiveForm::end() ?>
</div>
