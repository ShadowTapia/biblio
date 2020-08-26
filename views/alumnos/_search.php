<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\alumnos\AlumnosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alumnos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'rutalumno') ?>

    <?= $form->field($model, 'digrut') ?>

    <?= $form->field($model, 'sexo') ?>

    <?= $form->field($model, 'nombrealu') ?>

    <?= $form->field($model, 'paternoalu') ?>

    <?php // echo $form->field($model, 'maternoalu') ?>

    <?php // echo $form->field($model, 'calle') ?>

    <?php // echo $form->field($model, 'nro') ?>

    <?php // echo $form->field($model, 'depto') ?>

    <?php // echo $form->field($model, 'block') ?>

    <?php // echo $form->field($model, 'villa') ?>

    <?php // echo $form->field($model, 'codRegion') ?>

    <?php // echo $form->field($model, 'idProvincia') ?>

    <?php // echo $form->field($model, 'codComuna') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'fono') ?>

    <?php // echo $form->field($model, 'fechanac') ?>

    <?php // echo $form->field($model, 'nacionalidad') ?>

    <?php // echo $form->field($model, 'fechaing') ?>

    <?php // echo $form->field($model, 'fecharet') ?>

    <?php // echo $form->field($model, 'idalumno') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
