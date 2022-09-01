<?php

/**
 * @var CreateTaskForm $createTaskForm
 * @var CreateTaskForm $categoriesList
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
        <label class="control-label" for="location">Локация</label>
        <input class="location-icon" id="location" type="text">
        <span class="help-block">Error description is here</span>
    </div>
    <div class="half-wrapper">
        <?= $form->field($createTaskForm, 'price')->input('number', ['min' => 1]) ?>
        <?= $form->field($createTaskForm, 'deadline')->input('date', ['min' => date('Y-m-d')]) ?>
    </div>
    <p class="form-label">Файлы</p>
    <?= $form->field($createTaskForm, 'files[]')
        ->fileInput(['multiple' => true, 'class' => 'new-file'])
        ->label(false)
    ?>
    <?= Html::submitButton('Опубликовать', ['class' => 'button button--blue']) ?>
    <?php ActiveForm::end() ?>
</div>
