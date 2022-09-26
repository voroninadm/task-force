<?php

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
                'url' => ['tasks/my-tasks', 'status' => 'new'],
                'active' => function ($item, $hasActiveChild, $isItemActive, $widget) {
                    $queryString = Yii::$app->request->queryString;
                    return $queryString === '' || $queryString === 'status=new';
                }
            ],
            [
                'label' => 'В процессе',
                'url' => ['tasks/my-tasks', 'status' => 'in_work'],
                'active' => function ($item, $hasActiveChild, $isItemActive, $widget) {
                    $queryString = Yii::$app->request->queryString;
                    return $queryString === 'status=in_work';
                }
            ],
            ['label' => 'Закрытые',
                'url' => ['tasks/my-tasks', 'status' => 'failed'],
                'active' => function ($item, $hasActiveChild, $isItemActive, $widget) {
                    $queryString = Yii::$app->request->queryString;
                    return $queryString === 'status=failed';
                }
            ],

        ],
        'linkTemplate' => '<a class="link link--nav" href="{url}">{label}</a>',
    ])
    ?>
</div>
<div class="left-column left-column--task">
    <h3 class="head-main head-regular">Новые задания</h3>
    <div class="task-card">
        <div class="header-task">
            <a href="#" class="link link--block link--big">Перевести войну и мир на клингонский</a>
            <p class="price price--task">3400 ₽</p>
        </div>
        <p class="info-text"><span class="current-time">4 часа </span>назад</p>
        <p class="task-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit
            amet tempor
            nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie. Mauris malesuada nisi sit amet
            augue accumsan tincidunt.
        </p>
        <div class="footer-task">
            <p class="info-text town-text">Санкт-Петербург, Центральный район</p>
            <p class="info-text category-text">Переводы</p>
            <a href="#" class="button button--black">Смотреть Задание</a>
        </div>
    </div>
    <div class="task-card">
        <div class="header-task">
            <a href="#" class="link link--block link--big">Перевести войну и мир на клингонский</a>
            <p class="price price--task">3400 ₽</p>
        </div>
        <p class="info-text"><span class="current-time">4 часа </span>назад</p>
        <p class="task-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit
            amet tempor
            nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie. Mauris malesuada nisi sit amet
            augue accumsan tincidunt.
        </p>
        <div class="footer-task">
            <p class="info-text town-text">Санкт-Петербург, Центральный район</p>
            <p class="info-text category-text">Переводы</p>
            <a href="#" class="button button--black">Смотреть Задание</a>
        </div>
    </div>
    <div class="task-card">
        <div class="header-task">
            <a href="#" class="link link--block link--big">Перевести войну и мир на клингонский</a>
            <p class="price price--task">3400 ₽</p>
        </div>
        <p class="info-text"><span class="current-time">4 часа </span>назад</p>
        <p class="task-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit
            amet tempor
            nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie. Mauris malesuada nisi sit amet
            augue accumsan tincidunt.
        </p>
        <div class="footer-task">
            <p class="info-text town-text">Санкт-Петербург, Центральный район</p>
            <p class="info-text category-text">Переводы</p>
            <a href="#" class="button button--black">Смотреть Задание</a>
        </div>
    </div>
</div>

