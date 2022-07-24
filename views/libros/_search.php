<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\libros\LibrosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libros-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idLibros') ?>

    <?= $form->field($model, 'isbn') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'subtitulo') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'numpag') ?>

    <?php // echo $form->field($model, 'ano') ?>

    <?php // echo $form->field($model, 'idioma') ?>

    <?php // echo $form->field($model, 'formato') ?>

    <?php // echo $form->field($model, 'idcategoria') ?>

    <?php // echo $form->field($model, 'ideditorial') ?>

    <?php // echo $form->field($model, 'idautor') ?>

    <?php // echo $form->field($model, 'idtemas') ?>

    <?php // echo $form->field($model, 'imagen') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
