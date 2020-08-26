<?php

/**
 * @author Marcelo
 * @copyright 2019
 */


use app\models\Regiones;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

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
            <?= $form->field($model,"rutdocente")->widget(MaskedInput::className(),['mask'=>'99.999.999-*',],['style'=>'width:20%'])->label('RUN*') ?>
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
            <?= $form->field($model, "telefono")->input("text",['style'=>'width:100%'])->label('Teléfono') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, "calle")->input("text",['style'=>'width:100%'])->label('Dirección') ?>
        </div>
        <div class="col-xs-1">
            <?= $form->field($model, "numero")->input("text",['style'=>'width:70%'])->label('Número') ?>
        </div>
        <div class="col-xs-1">
            <?= $form->field($model, "depto")->input("text",['style'=>'width:70%'])->label('Depto.') ?>
        </div>
        <div class="col-xs-1">
            <?= $form->field($model, "block")->input("text",['style'=>'width:60%'])->label('Block') ?>
        </div>    
    </div>
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model, "villa")->input("text",['style'=>'width:100%'])->label(utf8_encode('Villa')) ?>
        </div>
        <div class="col-xs-4">
            <?= $form->field($model,"codRegion")->dropDownList(Regiones::getListRegiones(),        
                ['class' => 'form-control', 'style'=>'width:100%;','prompt'=>'Seleccione Región',
                    'id'=>'codRegion'])->label('Regiones*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model,"idProvincia")->widget(DepDrop::className(),[
                    'options'=>['id'=>'idProvincia','style' => 'width:100%;','prompt'=> 'Seleccione Provincia'],
                    'pluginOptions'=>[
                        'depends'=>['codRegion'],
                        'placeholder'=>'Seleccione Provincia',
                        'url'=>Url::to(['apoderados/lista_provincia']),
                        'loadingText' => 'Cargando Provincias...',
                    ]
            ])->label('Provincia*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model,"codComuna")->widget(DepDrop::className(),[
                    'options'=>['style' => 'width:80%;','prompt' => 'Seleccione Comuna','id' => 'codComuna'],
                    'pluginOptions'=>[
                            'depends'=>['idProvincia'],
                            'placeholder'=>'Seleccione Comuna',
                            'url'=>Url::to(['apoderados/listcomu']),
                            'loadingText' => 'Cargando Comunas...',
                    ]
            ])->label('Comuna*') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <?= $form->field($model,"email")->input("text",['style' => 'width:100%;'])->label(utf8_encode('E-Mail*')) ?>
        </div>
    </div>
    <div class="row" style="text-align: center;">
        <?= Html::submitButton("Registrar", ["class" => "btn btn-primary"]) ?>    
    </div>
</div>

<?php $form->end() ?>