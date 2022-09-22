<?php

/**
 * @var CreateTaskForm $createTaskForm
 * @var CreateTaskForm $categoriesList
 * @var CreateTaskForm $userLocationData
 */

use app\assets\AutocompleteAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

AutocompleteAsset::register($this);

?>

<div class="add-task-form regular-form">
    <?php $form = ActiveForm::begin([
        'id' => 'CreateTaskForm',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'errorOptions' => [
                'tag' => 'span',
                'class' => 'help-block'
            ]
        ]
    ]); ?>

    <h3 class="head-main head-main">Публикация нового задания</h3>
    <?= $form->field($createTaskForm, 'title') ?>
    <?= $form->field($createTaskForm, 'description')->textarea() ?>
    <?= $form->field($createTaskForm, 'category_id')->dropDownList($categoriesList) ?>

    <div class="form-group">
        <?= $form->field($createTaskForm, 'location', [
            'enableAjaxValidation' => true,
        ])->textInput([
            'id' => 'autoComplete', 'location',
            'class' => 'location-icon',
            'value' => $userLocationData['location']
        ])->hint("Укажите адрес из города, указанного при регистрации - " . ($userLocationData['city']) . ", либо оставьте пустым") ?>
        <?= $form->field($createTaskForm, 'city', [
            'template' => '{input}',
            'options' => [
                'tag' => false
            ],
        ])->hiddenInput(['value' => $userLocationData['city'], 'id' => 'city',]) ?>

        <?= $form->field($createTaskForm, 'address', [
            'template' => '{input}',
            'options' => [
                'tag' => false
            ],
        ])->hiddenInput(['value' => $userLocationData['address'], 'id' => 'address',]) ?>

        <?= $form->field($createTaskForm, 'lat', [
            'template' => '{input}',
            'options' => [
                'tag' => false
            ]
        ])->hiddenInput(['value' => $userLocationData['lat'],  'id' => 'lat']) ?>

        <?= $form->field($createTaskForm, 'long', [
            'template' => '{input}',
            'options' => [
                'tag' => false
            ],
        ])->hiddenInput(['value' => $userLocationData['long'],  'id' => 'long']) ?>

    </div>
    <div class="half-wrapper">
        <?= $form->field($createTaskForm, 'price')->input('number', ['min' => 1]) ?>
        <?= $form->field($createTaskForm, 'deadline')->input('date', ['min' => date('Y-m-d')]) ?>
    </div>
    <p class="form-label">Файлы</p>
    <?= $form->field($createTaskForm, 'files[]', ['options' => ['class' => 'new-file']])
        ->fileInput(['multiple' => true, 'class' => 'adding-files'])
        ->label('Добавить новый файл')
    ?>
    <?= Html::submitButton('Опубликовать', ['class' => 'button button--blue']) ?>
    <?php ActiveForm::end() ?>
</div>
