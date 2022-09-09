<?php
/**
 * @var Task $task
 * @var Task $taskStatusNameRu
 * @var TasksController $responses
 * @var TasksController $taskUserActions
 * @var ReviewController $reviewForm
 * @var ResponseController $responseForm
 */

use app\widgets\RatingStars;
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="left-column">
    <div class="head-wrapper">
        <h3 class="head-main"><?= Html::encode($task->title) ?></h3>
        <?php if (!empty($task->price)) : ?>
            <p class="price price--big"><?= Html::encode($task->price) ?> ₽</p>
        <?php endif; ?>
    </div>
    <p class="task-description"><?= Html::encode($task->description) ?></p>

    <?php foreach ($taskUserActions as $availableAction): ?>
        <?= $availableAction ?>
    <?php endforeach; ?>

    <div class="task-map">
        <img class="map" src="/img/map.png" width="725" height="346" alt="Новый арбат, 23, к. 1">
        <p class="map-address town">Москва</p>
        <p class="map-address">Новый арбат, 23, к. 1</p>
    </div>

    <?php if (Yii::$app->user->id === $task->customer_id
        || in_array(Yii::$app->user->id, array_column($responses, 'user_id'))): ?>
        <h4 class="head-regular">Отклики на задание</h4>
        <?php if (!empty($responses)) : ?>
            <?php foreach ($responses as $response): ?>
                <?php if (Yii::$app->user->id === $task->customer_id || Yii::$app->user->id === $response->user_id): ?>
                    <div class="response-card">
                        <img class="customer-photo" src="<?= $response->user->avatarFile->url ?>" width="146"
                             height="156"
                             alt="Фото заказчиков">
                        <div class="feedback-wrapper">
                            <a href="<?= Url::to(['user/view', 'id' => $response->user_id]) ?>"
                               class="link link--block link--big"><?= Html::encode($response->user->name) ?></a>
                            <div class="response-wrapper">
                                <div class="stars-rating small">
                                    <?= RatingStars::widget(['rating' => floor($response->user->rating)]) ?>
                                </div>
                                <p class="reviews"><?= Yii::$app->inflection->pluralize(count($response->user->reviews),
                                        'отзыв') ?></p>
                            </div>
                            <p class="response-message">
                                <?= $response->comment ? Html::encode($response->comment) : "<i>Пользователь оставил отклик без комментария</i>" ?>
                            </p>
                        </div>
                        <div class="feedback-wrapper">
                            <p class="info-text">
                <span class="current-time"><?= Yii::$app->formatter->asRelativeTime($response->create_date); ?>
                            </p>
                            <p class="price price--small"><?= $response->price ? Html::encode($response->price) . ' ₽' : '' ?></p>
                        </div>
                        <?php if (Yii::$app->user->can('customerCanAcceptResponse', ['task' => $task])
                        && $response->is_blocked !== 1): ?>
                            <div class="button-popup">
                                <a class="button button--blue button--small" href="<?= Url::toRoute(['response/accept', 'id' => $response->id]) ?>">Принять</a>
                                <a class="button button--orange button--small" href="<?= Url::toRoute(['response/refuse', 'id' => $response->id]) ?>">Отказать</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p> У задания пока нет откликов </p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="right-column">
    <div class="right-card black info-card">
        <h4 class="head-card">Информация о задании</h4>
        <dl class="black-list">
            <dt>Категория</dt>
            <dd><?= $task->category->name ?></dd>
            <dt>Дата публикации</dt>
            <dd><?= Yii::$app->formatter->asRelativeTime($task->public_date); ?></dd>
            <dt>Срок выполнения</dt>
            <?php if (isset($task->deadline)) : ?>
                <dd><?= Yii::$app->formatter->asDate($task->deadline, 'long') ?></dd>
            <?php else: ?>
                <dd>не указан</dd>
            <?php endif; ?>
            <dt>Статус</dt>
            <dd><?= $taskStatusNameRu ?></dd>
        </dl>
    </div>

    <?php if (!empty($files)) : ?>
        <div class="right-card white file-card">
            <h4 class="head-card">Файлы задания</h4>
            <ul class="enumeration-list">
                <?php foreach ($files as $file): ?>
                    <li class="enumeration-item">
                        <a href="<?= Url::to($file->url) ?>"
                           class="link link--block link--clip" download> <?= basename($file->url) ?> </a>
<!--                                            <p class="file-size">--><?//= $file->size ?><!--</p>-->
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

</main>

<section class="pop-up pop-up--cancel pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Отмена задания</h4>
        <p class="pop-up-text">
            <b>Внимание!</b><br>
            Вы собираетесь отменить это задание.<br>
            Задание будет переведено в статус "Отменено" <br> и недоступно для дальнейших действий
        </p>
        <a class="button button--pop-up button--yellow" href="<?= Url::toRoute(['tasks/cancel', 'id' => $task->id]) ?>">Отменить</a>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>

<section class="pop-up pop-up--completion pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <?php $form = ActiveForm::begin([
                'action' => ['review/create'],
                'id' => 'reviewForm',
                'enableAjaxValidation' => true
            ]) ?>
            <?= $form->field($reviewForm, 'task_id', [
                'template' => '{input}',
                'options' => ['tag' => false],
            ])->hiddenInput(['value' => $task->id]) ?>

            <?= $form->field($reviewForm, 'author_id', [
                'template' => '{input}',
                'options' => ['tag' => false],
            ])->hiddenInput(['value' => $task->customer_id]) ?>

            <?= $form->field($reviewForm, 'user_id', [
                'template' => '{input}',
                'options' => ['tag' => false],
            ])->hiddenInput(['value' => $task->performer_id]) ?>

            <?= $form->field($reviewForm, 'description')->textarea() ?>

            <p class="completion-head control-label">Оценка работы</p>

            <?= $form->field($reviewForm, 'grade')->widget(StarRating::class, [
                'pluginOptions' => [
                    'size' => 'md',
                    'min' => 0,
                    'max' => 5,
                    'step' => 1,
                    'starCaptions' => [
                        1 => 'Хуже некуда',
                        2 => 'Плохо',
                        3 => 'Средне',
                        4 => 'Хорошо',
                        5 => 'Замечательно',
                    ],
                ]
            ])->label(false); ?>

            <?= Html::submitButton('Завершить', ['class' => 'button button--pop-up button--blue']) ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>

<section class="pop-up pop-up--refusal pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Отказ от задания</h4>
        <p class="pop-up-text">
            <b>Внимание!</b><br>
            Вы собираетесь отказаться от выполнения этого задания.<br>
            Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.
        </p>
        <a class="button button--pop-up button--orange" href="<?= Url::toRoute(['tasks/refuse', 'id' => $task->id]) ?>">Отказаться</a>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>

<section class="pop-up pop-up--act_response pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Добавление отклика к заданию</h4>
        <p class="pop-up-text">
            Вы собираетесь оставить свой отклик к этому заданию.
            Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
        </p>
        <div class="addition-form pop-up--form regular-form">
            <?php $form = ActiveForm::begin([
                'id' => 'responseForm',
                'action' => ['response/create'],
                'enableAjaxValidation' => true
            ]) ?>

            <?= $form->field($responseForm, 'task_id', [
                'template' => '{input}',
                'options' => ['tag' => false],
            ])->hiddenInput(['value' => $task->id]) ?>

            <?= $form->field($responseForm, 'comment')->textarea() ?>

            <?= $form->field($responseForm, 'price')->textInput([
                'type' => 'number',
                'min' => 1
            ]) ?>

            <?= Html::submitButton('Завершить', ['class' => "button button--pop-up button--blue"]) ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>