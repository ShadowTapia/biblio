<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\libros\LibrosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $this->registerJs(
            '$("document").ready(function(){
                $("#campo_busqueda").on("Pjax:end", function() {
                    $.pjax.reload({container:"#libros"});
                 });
             });'
    );
?>

<div class="libros-search">
    <?php Pjax::begin(['id' => 'campo_busqueda', 'timeout'=>false]) ?>
    <?php $form = ActiveForm::begin([
        'options' => [
            'data-pjax' => true
        ],
    ]); ?>

    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'autofocus'=>true, 'placeholder' => 'Ingrese título del ejemplar a buscar'])->label('') ?>
        </div>
        <div class="col-xs-3" style= "margin-top: 1.5%">
            <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Buscar', ['class' => 'btn btn-success', 'id' => 'buscaButton']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

    <?php // echo $form->field($model, 'idLibros') ?>

    <?php // echo $form->field($model, 'isbn') ?>



    <?php //$form->field($model, 'subtitulo') ?>

    <?php //$form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'numpag') ?>

    <?php // echo $form->field($model, 'ano') ?>

    <?php // echo $form->field($model, 'idioma') ?>

    <?php // echo $form->field($model, 'formato') ?>

    <?php // echo $form->field($model, 'idcategoria') ?>

    <?php // echo $form->field($model, 'ideditorial') ?>

    <?php // echo $form->field($model, 'idautor') ?>

    <?php // echo $form->field($model, 'idtemas') ?>

    <?php // echo $form->field($model, 'imagen') ?>





</div>
