<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\apoderados\ApoderadosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apoderados-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'rutapo') ?>

    <?= $form->field($model, 'digrut') ?>

    <?= $form->field($model, 'nombreapo') ?>

    <?= $form->field($model, 'apepat') ?>

    <?= $form->field($model, 'apemat') ?>

    <?php // echo $form->field($model, 'calle') ?>

    <?php // echo $form->field($model, 'nro') ?>

    <?php // echo $form->field($model, 'depto') ?>

    <?php // echo $form->field($model, 'block') ?>

    <?php // echo $form->field($model, 'villa') ?>

    <?php // echo $form->field($model, 'codRegion') ?>

    <?php // echo $form->field($model, 'idProvincia') ?>

    <?php // echo $form->field($model, 'codComuna') ?>

    <?php // echo $form->field($model, 'fono') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'estudios') ?>

    <?php // echo $form->field($model, 'niveledu') ?>

    <?php // echo $form->field($model, 'profesion') ?>

    <?php // echo $form->field($model, 'trabajoplace') ?>

    <?php // echo $form->field($model, 'relacion') ?>

    <?php // echo $form->field($model, 'rutalumno') ?>

    <?php // echo $form->field($model, 'idApo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
