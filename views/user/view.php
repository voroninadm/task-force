<?php
/**
 * @var UserController $user
 * @var UserController $categories
 * @var UserController $reviews
 */

use app\widgets\RatingStars;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="left-column">
    <h3 class="head-main"><?= Html::encode($user->name) ?></h3>

    <div class="user-card">
        <div class="photo-rate">
            <img class="card-photo" src="<?= $user->avatarFile->url ?>" width="191" height="190"
                 alt="Фото пользователя">
            <div class="card-rate">
                <div class="stars-rating big">
                    <?= RatingStars::widget(['rating' => floor($user->rating)]) ?>
                </div>
                <span class="current-rate"><?= $user->rating ?></span>
            </div>
        </div>
        <p class="user-description"><?= $user->description ? Html::encode($user->description) : '<i>Пользователь не добавил описание</i>' ?></p>
    </div>

    <div class="specialization-bio">
        <div class="specialization">
            <p class="head-info">Специализации</p>
            <?php if ($categories): ?>
                <ul class="special-list">
                    <?php foreach ($categories as $category) : ?>
                        <li class="special-item">
                            <a href="#" class="link link--regular"><?= $category->name ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <span> <i>Нет выбранных категорий</i></span>
            <?php endif; ?>
        </div>

        <div class="bio">
            <p class="head-info">Био</p>
            <p class="bio-info">
                <span class="country-info">Россия</span>,
                <span class="town-info"><?= $user->city->name ?></span>,
                <?php if (!empty($user->birth_date)) : ?>
                    <span class="age-info"><?= $user->age ?></span>
                    лет
                <?php else: ?>
                    <span><i>Возраст не указан></i></span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <?php if (!empty($categories)) : ?>
        <h4 class="head-regular">Отзывы заказчиков</h4>
        <?php foreach ($reviews as $review) : ?>
            <div class="response-card">
                <img class="customer-photo" src="<?= $review->author->avatarFile->url ?>" width="120" height="127"
                     alt="Фото заказчиков">
                <div class="feedback-wrapper">
                    <p class="feedback"><?= Html::encode($review->description) ?></p>
                    <p class="task">Задание «
                        <a href="<?= Url::to(['tasks/view', 'id' => $review->task->id]) ?>"
                           class="link link--small"><?= Html::encode($review->task->title) ?></a>
                        » выполнено
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="right-column">
    <div class="right-card black">
        <h4 class="head-card">Статистика исполнителя</h4>
        <dl class="black-list">
            <dt>Всего заказов</dt>
            <dd><?= $user->done_task ?> выполнено, <?= $user->failed_task ?> провалено</dd>
            <dt>Место в рейтинге</dt>
            <dd><?= $user->ratingPlace ?> место</dd>
            <dt>Дата регистрации</dt>
            <dd><?= Yii::$app->formatter->asDate($user->reg_date, 'long') ?></dd>
            <dt>Статус</dt>
            <dd><?= $user->is_busy ? 'Занят' : 'Открыт для новых заказов' ?>
        </dl>
    </div>
    <div class="right-card white">
        <h4 class="head-card">Контакты</h4>
        <ul class="enumeration-list">
            <?php if (!empty($user->phone)) : ?>
                <li class="enumeration-item">
                    <a href="tel:<?= Html::encode($user->phone) ?>"
                       class="link link--block link--phone"><?= Html::encode($user->phone) ?></a>
                </li>
            <?php endif; ?>
            <li class="enumeration-item">
                <a href="mailto:<?= Html::encode($user->email) ?>"
                   class="link link--block link--email"><?= Html::encode($user->email) ?></a>
            </li>
            <?php if (!empty($user->telegram)) : ?>
                <li class="enumeration-item">
                    <a href="https://t.me/<?= Html::encode($user->telegram) ?>"
                       class="link link--block link--tg"><?= Html::encode($user->telegram) ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
