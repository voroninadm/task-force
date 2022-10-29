<?php

/**
 * @var Task $models
 * @var $this View
 * @var $filterForm
 * @var Task $categoriesList
 * @var TaskFilterForm $tasksDataProvider
 */

use app\models\Task;
use app\models\TaskFilterForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

?>


<div class="left-column">
    <h3 class="head-main head-task">Новые задания</h3>
    <?= ListView::widget([
        'dataProvider' => $tasksDataProvider,
        'itemView' => '_task',
        'itemOptions' => [
            'tag' => false
        ],
        'pager' => [
            'hideOnSinglePage' => true,
            'options' => [
                'class' => 'pagination-list'
            ],
            'activePageCssClass' => 'pagination-item--active',
            'linkContainerOptions' => [
                'class' => 'pagination-item'
            ],
            'linkOptions' => [
                'class' => 'link link--page'
            ],
            'nextPageCssClass' => 'mark',
            'prevPageCssClass' => 'mark',
            'nextPageLabel' => '',
            'prevPageLabel' => '',
            'disabledPageCssClass' => ''
        ],
        'summary' => '',
        'separator' => '',
        'id' => false,
        'options' => [
            'tag' => false,
        ]
    ]); ?>
</div>

<div class="right-column">
    <div class="right-card black">
        <div class="search-form">

            <?php $form = ActiveForm::begin([
                'id' => null,
                'action' => '',
                'method' => 'get',
                'options' => ['class' => 'search-form'],
                'fieldConfig' => [
                    'errorOptions' => [
                        'tag' => 'span',
                        'class' => 'help-block'
                    ]
                ]
            ]); ?>

            <h4 class="head-card">Категории</h4>

            <?= $form->field($filterForm, 'categories')
                ->checkboxList($categoriesList, [
                    'tag' => false,
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $checked = $checked ? 'checked' : '';
                        return
                            "<div>
                                <label class='control-label'>
                                    <input type='checkbox'  name='$name' value='$value' $checked>
                                $label</label>
                            </div>";
                    },
                ])->label(false) ?>

            <h4 class="head-card">Дополнительно</h4>

            <?= $form->field($filterForm, 'withoutPerformer')->checkbox([
                'labelOptions' => ['class' => 'control-label']
            ], true); ?>

            <?= $form->field($filterForm, 'remote')->checkbox([
                'labelOptions' => ['class' => 'control-label']
            ], true); ?>

            <h4 class="head-card">Период</h4>

            <?= $form->field($filterForm, 'period')
                ->dropDownList(TaskFilterForm::PERIOD_VALUES, [
                    'prompt' => 'Выберите период...',
                ])
                ->label(false) ?>

            <?= Html::submitButton('Искать', ['class' => 'button button--blue']) ?>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>