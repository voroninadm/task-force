<?php

/**
 * @var MyTasksController $tasksDataProvider
 * @var MyTasksController $title
 */

use app\models\User;
use yii\widgets\ListView;
use yii\widgets\Menu;

?>

<div class="left-menu">
    <h3 class="head-main head-task">Мои задания</h3>
    <?= Menu::widget([
        'options' => [
            'class' => 'side-menu-list',
        ],
        'itemOptions' => [
            'class' => 'side-menu-item',
        ],
        'activeCssClass' => 'side-menu-item--active',
        'items' => [
            [
                'label' => 'Новые',
                'url' => ['', 'status' => 'new'],
                'active' => function ($item, $hasActiveChild, $isItemActive, $widget) {
                    $queryString = Yii::$app->request->queryString;
                    return $queryString === '' || $queryString === 'status=new';
                },
                'visible' => Yii::$app->user->identity->is_performer === User::ROLE_CUSTOMER
            ],
            [
                'label' => 'В процессе',
                'url' => ['', 'status' => 'in_work'],
                'active' => function ($item, $hasActiveChild, $isItemActive, $widget) {
                    $queryString = Yii::$app->request->queryString;
                    if (Yii::$app->user->identity->is_performer) {
                        return $queryString === '' || $queryString === 'status=in_work';
                    } else {
                       return $queryString === 'status=in_work';
                    }
                }
            ],
            [
                'label' => 'Просрочено',
                'url' => ['my-tasks/index', 'status' => 'overdue'],
                'visible' => Yii::$app->user->identity->is_performer === User::ROLE_PERFORMER
            ],
            [
                'label' => 'Закрытые',
                'url' => ['my-tasks/index', 'status' => 'closed'],
                'active' => function ($item, $hasActiveChild, $isItemActive, $widget) {
                    $queryString = Yii::$app->request->queryString;
                    return $queryString === 'status=closed';
                }
            ],

        ],
        'linkTemplate' => '<a class="link link--nav" href="{url}">{label}</a>',
    ])
    ?>
</div>
<div class="left-column left-column--task">
    <h3 class="head-main head-regular"><?= $title ?></h3>
    <?= ListView::widget([
        'dataProvider' => $tasksDataProvider,
        'itemView' => '..\tasks\_task',
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

