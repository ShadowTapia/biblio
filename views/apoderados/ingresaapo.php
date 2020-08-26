<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 16-06-2020
 * Time: 0:51
 */
use app\models\Regiones;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = "Ingreso de Apoderados";
$this->params['breadcrumbs'][] = ['label' => 'Asignar Apoderados','url' => ['alumnos/relacionapos']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="apoderados-form">
    <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'formIngApos', 'class' => 'form-horizontal',
        'enableClientValidation' => false, 'enableAjaxValidation' => true, ]);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model,'rutapo')->widget(MaskedInput::className(),['mask'=>'99.999.999-*',],['style'=>'width:10%'])->label('RUN*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,'nombreapo')->textInput(['style' => 'width:100%'])->label('Nombres*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,'apepat')->textInput(['style' => 'width:100%'])->label('A. Paterno*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,'apemat')->textInput(['style' => 'width:100%'])->label('A. Materno*') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model,'calle')->textInput(['style' => 'width:100%'])->label('Dirección') ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model,'nro')->textInput(['style' => 'width:100%'])->label('Nro') ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model,'depto')->textInput(['style' => 'width:70%'])->label('Depto') ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model,'block')->textInput(['style' => 'width:70%'])->label('Block') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,'villa')->textInput(['style' => 'width:70%'])->label('Villa o Población') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <?= $form->field($model,'codRegion')->dropDownList(Regiones::getListRegiones(),
                        ['class'=>'form-control','style'=>'width:100%;','prompt'=>'Selecciona Región',
                            'id'=>'codRegion'])->label('Regiones') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,'idProvincia')->widget(DepDrop::className(),[
                        'options'=>['id'=>'idProvincia','prompt'=> 'Seleccione Provincia'],
                        'pluginOptions'=>[
                                'depends'=>['codRegion'],
                                'placeholder'=>'Seleccione Provincia',
                                'url'=>Url::to(['apoderados/lista_provincia']),
                                'loadingText' => 'Cargando Provincias...',
                        ]
                ])->label('Provincia') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,'codComuna')->widget(DepDrop::className(),[
                        'options'=>['id'=>'codComuna','prompt'=>'Seleccione Comuna'],
                        'pluginOptions'=>[
                                'depends'=>['idProvincia'],
                                'placeholder'=>'Seleccione Comuna',
                                'url'=>Url::to(['apoderados/listcomu']),
                                'loadingText' => 'Cargando Comunas...',
                        ]
                ])->label('Comuna') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model,'fono')->textInput(['style'=>'width:100%'])->label('Teléfono') ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model,'celular')->textInput(['style'=>'width:100%'])->label('Celular') ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model,'email')->textInput(['style'=>'width:100%'])->label('Email') ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model,'niveledu')->textInput(['style'=>'width:100%'])->label('Nivel Educacional') ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model,'estudios')->textInput(['style'=>'width:80%'])->label('Estudios') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model,'profesion')->textInput(['style'=>'width:100%'])->label('Profesion') ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model,'trabajoplace')->textInput(['style'=>'width:100%'])->label('Lugar de Trabajo') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,'relacion')->dropDownList([
                            'Madre'=>'Madre','Padre'=>'Padre','Abuela'=>'Abuela','Abuelo'=>'Abuelo','Tío(a)'=>'Tío(a)',
                            'Hermano(a)'=>'Hermano(a)','Otro'=>'Otro'],['style'=>'width:180px;','prompt'=>'Seleccione Relación'])->label('Relación') ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model,'apoderado')->checkbox(['label'=>'¿Asume como apoderado?']) ?>
            </div>
        </div>
        <div class="row" style="text-align: center">
            <?= Html::submitButton("Registrar",["class"=>"btn btn-primary"]) ?>
        </div>
    </div>
    <?php $form->end() ?>
</div>
