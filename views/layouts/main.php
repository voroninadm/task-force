<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use app\services\LayoutService;


AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>

<?php if (!str_contains(Yii::$app->request->url, 'registration')) : ?>
    <?php $user = Yii::$app->user->identity; ?>
    <header class="page-header">
        <nav class="main-nav">
            <a href='<?= Url::home() ?>' class="header-logo">
                <img class="logo-image" src="/img/logotype.png" width=227 height=60 alt="taskforce">
            </a>
            <div class="nav-wrapper">
                <?= Menu::widget([
                    'options' => [
                        'class' => 'nav-list',
                    ],
                    'itemOptions' => [
                        'class' => 'list-item',
                    ],
                    'activeCssClass' => 'list-item--active',
                    'items' => [
                        ['label' => 'Новое', 'url' => ['tasks/']],
                        ['label' => 'Мои задания', 'url' => ['my-tasks/']],
                        [
                            'label' => 'Создать задание',
                            'url' => ['tasks/create'],
                            'visible' => Yii::$app->user->identity->is_performer === User::ROLE_CUSTOMER,
                        ],
                        ['label' => 'Настройки', 'url' => ['/profile']]
                    ],
                    'linkTemplate' => '<a class="link link--nav" href="{url}">{label}</a>',
                ]) ?>
            </div>
        </nav>

        <div class="user-block">
            <a href="<?= Url::to("/user/view/$user->id") ?>">
                <img class="user-photo" src="<?= $user->avatarFile->url ?>" width="55" height="55" alt="Аватар">
            </a>
            <div class="user-menu">
                <p class="user-name"><?= Html::encode($user->name) ?></p>
                <div class="popup-head">
                    <?= Menu::widget([
                        'options' => [
                            'class' => 'popup-menu',
                        ],
                        'itemOptions' => [
                            'class' => 'menu-item',
                        ],
                        'items' => [
                            ['label' => 'Настройки', 'url' => ['#']],
                            ['label' => 'Связаться с нами', 'url' => ['#']],
                            ['label' => 'Выход из системы', 'url' => ['user/logout']]
                        ],
                        'linkTemplate' => '<a class="link" href="{url}">{label}</a>',
                    ]) ?>
                </div>
            </div>
        </div>

    </header>
<?php endif; ?>

<main class="main-content container <?= LayoutService::addClassToMain(Yii::$app->controller->route) ?>">

    <?= $content ?>

    <div class="overlay"></div>
</main>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
