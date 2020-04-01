<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use app\models\Comunas;
use app\models\Provincias;
use app\models\Regiones;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Ingresar Docente';
$this->params['breadcrumbs'][] = ['label' => 'Administrar', 'url' => ['indexdocente']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'formulario', 'class' => 'form-horizontal', 
'enableClientValidation' => false, 'enableAjaxValidation' => true, ]);	
?>

<div class="container">
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model,"rutdocente")->widget(\yii\widgets\MaskedInput::className(),['mask'=>'99.999.999-*',],['style'=>'width:20%'])->label('RUN*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model, "nombres")->input("text",['style'=>'width:100%'])->label('Nombre*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model, "paterno")->input("text",['style'=>'width:100%'])->label('A. Paterno*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model, "materno")->input("text",['style'=>'width:100%'])->label('A. Materno*') ?>      
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model, "telefono")->input("text",['style'=>'width:100%'])->label('Telefono') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, "calle")->input("text",['style'=>'width:100%'])->label(utf8_encode('Direcci�n')) ?>
        </div>
        <div class="col-xs-1">
            <?= $form->field($model, "numero")->input("text",['style'=>'width:70%'])->label(utf8_encode('N�mero')) ?>
        </div>
        <div class="col-xs-1">
            <?= $form->field($model, "depto")->input("text",['style'=>'width:70%'])->label(utf8_encode('Depto.')) ?>        
        </div>
        <div class="col-xs-1">
            <?= $form->field($model, "block")->input("text",['style'=>'width:60%'])->label(utf8_encode('Block')) ?>
        </div>    
    </div>
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model, "villa")->input("text",['style'=>'width:100%'])->label(utf8_encode('Villa')) ?>
        </div>
        <div class="col-xs-4">
            <?= $form->field($model,"codRegion")->dropDownList(Regiones::getListRegiones(),        
                ['class' => 'form-control', 'style'=>'width:100%;','prompt'=>utf8_encode('Seleccione Regi�n'),'onchange' => 
                    '$.post("listprovi?id= " +$(this).val(),function( data ) { 
                            $("select#idProvincia").html( data );
                    });'])->label('Regiones*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model,"idProvincia")->dropDownList(Provincias::dropdown(),
                ['style' => 'width:100%;','prompt'=> 'Seleccione Provincia','id'=>'idProvincia','onchange' =>
                    '$.post("listcomu?id= " +$(this).val(),function( data ) {
                            $("select#codComuna").html( data );
                            });'])->label('Provincia*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model,"codComuna")->dropDownList(Comunas::combobx(),
                ['style' => 'width:80%;','prompt' => 'Seleccione Comuna','id' => 'codComuna'])->label('Comuna*') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <?= $form->field($model,"email")->input("text",['style' => 'width:100%;'])->label(utf8_encode('E-Mail')) ?>
        </div>
    </div>
    <div class="row" style="text-align: center;">
        <?= Html::submitButton("Registrar", ["class" => "btn btn-primary"]) ?>    
    </div>
</div>

<?php $form->end() ?>