<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistoricoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idhistorico') ?>

    <?= $form->field($model, 'idUser') ?>

    <?= $form->field($model, 'idejemplar') ?>

    <?= $form->field($model, 'fechapres') ?>

    <?= $form->field($model, 'fechadev') ?>

    <?php // echo $form->field($model, 'fechadevReal') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'User') ?>

    <?php // echo $form->field($model, 'UserMail') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
