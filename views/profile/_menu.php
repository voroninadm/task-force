<?php

use yii\widgets\Menu;

?>
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