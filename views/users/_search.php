<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchUsers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idUser') ?>

    <?= $form->field($model, 'UserName') ?>

    <?= $form->field($model, 'UserLastName') ?>

    <?= $form->field($model, 'UserPass') ?>

    <?= $form->field($model, 'Idroles') ?>

    <?php // echo $form->field($model, 'UserRut') ?>

    <?php // echo $form->field($model, 'UserMail') ?>

    <?php // echo $form->field($model, 'authkey') ?>

    <?php // echo $form->field($model, 'accessToken') ?>

    <?php // echo $form->field($model, 'activate') ?>

    <?php // echo $form->field($model, 'verification_code') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
