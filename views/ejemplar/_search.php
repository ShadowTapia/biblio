<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ejemplar\EjemplarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ejemplar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idejemplar') ?>

    <?= $form->field($model, 'norden') ?>

    <?= $form->field($model, 'edicion') ?>

    <?= $form->field($model, 'ubicacion') ?>

    <?= $form->field($model, 'idLibros') ?>

    <?php // echo $form->field($model, 'fechain') ?>

    <?php // echo $form->field($model, 'fechaout') ?>

    <?php // echo $form->field($model, 'disponible') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
