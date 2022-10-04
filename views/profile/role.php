<?php

declare(strict_types=1);

/**
 * @var RoleForm $roleForm
 */

use app\models\RoleForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div>
    <?php $form = ActiveForm::begin([]) ?>
    <h2>Поздравляем!!!</h2>
    <h3>Вы успешно зарегистрированы и авторизованы через VKontakte!</h3>
    <br>
    <p>Сейчас нужно определиться с Вашей ролью. <strong>Внимание! Роль можно выбрать только сейчас!</strong></p>
    <p>Если Вы хотите продолжить как заказчик и создавать задания, то просто завешите регистрацию.</p>
    <p>Поставьте отметку ниже, если хотите откликаться на работы как исполнитель.</p>
    <br>
    <?= $form->field($roleForm, 'is_performer')->checkbox() ?>
    <?= Html::submitButton('Закончить регистрацию', ['class' => 'button button--blue']) ?>
    <?php ActiveForm::end() ?>
</div>

