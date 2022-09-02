<?php

/**
 * @var Task $model
 * @var $this View
 */

use app\models\Task;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<div class="task-card">
    <div class="header-task">
        <a href="<?= Url::to(['/tasks/view/', 'id' => $model->id]); ?>" class="link link--block link--big">
            <?= Html::encode($model->title); ?>
        </a>
        <p class="price price--task"><?= !empty($model->price) ? Html::encode($model->price) . " ₽" : ''; ?> </p>
    </div>
    <p class="info-text">
        <span class="current-time"><?= Yii::$app->formatter->asRelativeTime($model->public_date); ?></span>
    </p>
    <p class="task-text"><?= Html::encode(BaseStringHelper::truncate($model->description, 200)); ?></p>
    <div class="footer-task">
        <?php if (isset($model->address)) : ?>
            <p class="info-text town-text"><?= Html::encode($model->address); ?></p>
        <?php endif; ?>
        <p class="info-text category-text"><?= Html::encode($model->category->name) ?></p>
        <a href="<?= Url::to(['/tasks/view/', 'id' => $model->id]); ?>" class="button button--black">Смотреть Задание</a>
    </div>
</div>