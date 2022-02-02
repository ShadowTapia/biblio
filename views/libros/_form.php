<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\categorias\Categorias;
use app\models\editorial\Editorial;
use app\models\temas\Temas;
use app\models\autor\Autor;

/* @var $this yii\web\View */
/* @var $model app\models\libros\Libros */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libros-form">

    <?php $form = ActiveForm::begin(['method'=> 'post',
                                    'id' => 'formIngLibros',
                                    'class' => 'form-horizontal',
                                    'enableClientValidation' => true,
                                    'options'=> ['enctype'=> 'multipart/form-data']
                                    ]); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-4">
                <?= $form->field($model, 'isbn')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
            </div>
            <div class="col-sm-8">
                <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->field($model, 'subtitulo')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model, 'numpag')->textInput() ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model, 'ano')->textInput() ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, 'idioma')->dropDownList(
                    [
                        'Español' => 'Español',
                        'Inglés' => 'Inglés',
                        'Alemán' => 'Alemán',
                        'Frances' => 'Frances',
                        'Italiano' => 'Italiano',
                        'Chino' => 'Chino',
                        'Otro' => 'Otro',
                    ], ['class' => 'form-control', 'style'=>'width:100%;','prompt' => 'Seleccione Idioma']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model, 'formato')->dropDownList([
                    'Libro' => 'Libro',
                    'Enciclopedia' => 'Enciclopedia',
                    'Revista' => 'Revista',
                    'Comic' => 'Comic',
                    'Diccionario' => 'Diccionario',
                    'Otro' => 'Otro',
                    ],
                    ['class' => 'form-control', 'style'=>'width:90%;','prompt' => 'Selecciona el formato']) ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, 'idcategoria')->dropDownList(Categorias::comboBox(),
                    ['class' => 'form-control', 'style'=>'width:100%;','prompt'=>'Seleccione Categorías',
                    'id'=> 'idcategoria']) ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, 'ideditorial')->dropDownList(Editorial::comboBox(),
                    ['class' => 'form-control', 'style'=>'width:100%;','prompt'=>'Seleccione Editorial',
                        'id'=> 'ideditorial']) ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model, 'idtemas')->dropDownList(Temas::combobox(),
                    ['class' => 'form-control', 'style'=>'width:100%;','prompt'=>'Seleccione Temas',
                        'id'=> 'idtemas']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5">
                <?= $form->field($model, 'idautor')->dropDownList(Autor::comboBox(),
                    ['class' => 'form-control', 'style'=>'width:100%;','prompt'=>'Seleccione Autor',
                        'id'=> 'idautor']) ?>
            </div>
            <div class="col-xs-7">
                <?= $form->field($model, 'descripcion')->textarea(['rows' => 2,'maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <?= $form->field($model, 'imagen')->fileInput() ?>
            </div>
        </div>
        <div class="row" style="text-align: center">
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
