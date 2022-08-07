<?php

/**
 * @var Task[] $models
 * @var $this View
 */

use app\models\Task;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Новые задания';

?>


<div class="left-column">
    <h3 class="head-main head-task">Новые задания</h3>
    <?php foreach ($models as $model): ?>
        <div class="task-card">
            <div class="header-task">
                <a href="#" class="link link--block link--big"><?= Html::encode($model->title); ?></a>
                <p class="price price--task"><?= Html::encode($model->price); ?> ₽</p>
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
                <a href="#" class="button button--black">Смотреть Задание</a>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="pagination-wrapper">
        <ul class="pagination-list">
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">1</a>
            </li>
            <li class="pagination-item pagination-item--active">
                <a href="#" class="link link--page">2</a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">3</a>
            </li>
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
        </ul>
    </div>
</div>
<div class="right-column">
    <div class="right-card black">
        <div class="search-form">
            <form>
                <h4 class="head-card">Категории</h4>
                <div class="form-group">
                    <div class="checkbox-wrapper">
                        <label class="control-label" for="сourier-services">
                            <input type="checkbox" id="сourier-services" checked>
                            Курьерские услуги</label>
                        <label class="control-label" for="cargo-transportation">
                            <input id="cargo-transportation" type="checkbox">
                            Грузоперевозки</label>
                        <label class="control-label" for="translations">
                            <input id="translations" type="checkbox">
                            Переводы</label>
                    </div>
                </div>
                <h4 class="head-card">Дополнительно</h4>
                <div class="form-group">
                    <label class="control-label" for="without-performer">
                        <input id="without-performer" type="checkbox" checked>
                        Без исполнителя</label>
                </div>
                <h4 class="head-card">Период</h4>
                <div class="form-group">
                    <label for="period-value"></label>
                    <select id="period-value">
                        <option>1 час</option>
                        <option>12 часов</option>
                        <option>24 часа</option>
                    </select>
                </div>
                <input type="submit" class="button button--blue" value="Искать">
            </form>
        </div>
    </div>
</div>