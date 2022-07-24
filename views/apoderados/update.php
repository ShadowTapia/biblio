<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 17-02-2022
 * Time: 23:52
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Regiones;
use kartik\depdrop\DepDrop;


$this->title = 'Modificar Apoderados';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="apoderados-form">
    <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'formModApos', 'class' => 'form-horizontal',
        'enableClientValidation' => false, 'enableAjaxValidation' => true, ]);
    ?>
    <div class="container">
        <div class="row">
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
                    [
                        'class'=>'form-control',
                        'style'=>'width:100%;',
                        'prompt'=>'Selecciona Región',
                        'id'=>'codRegion'])->label('Región'); ?>
            </div>
            <?php echo Html::hiddenInput('selected_id', $model->idProvincia, ['id'=>'selected_id']) ?>
            <div class="col-xs-3">
                <?= $form->field($model,'idProvincia')->widget(DepDrop::class,[
                        'options'=>['id'=>'idProvincia','prompt'=>'Seleccione Provincia'],
                        'pluginOptions'=>[
                            'depends'=>['codRegion'],
                            'placeholder'=>'Seleccione Provincia',
                            'url'=>Url::to(['apoderados/lista_provincia']),
                            'loadingText' => 'Cargando Provincias...',
                            'initialize' => true,
                            'params' => ['selected_id'],
                        ]
                ])->label('Provincia*') ?>
            </div>
            <?php echo Html::hiddenInput('selected_ic', $model->codComuna, ['id' => 'selected_ic']) ?>
            <div class="col-xs-3">
                <?= $form->field($model,"codComuna")->widget(DepDrop::class,[
                    'options'=>['id'=>'codComuna','prompt' => 'Seleccione Comuna','style' => 'width:80%;'],
                    'pluginOptions'=>[
                        'depends'=>['idProvincia'],
                        'placeholder'=>'Seleccione Comuna',
                        'url'=>Url::to(['apoderados/listcomu']),
                        'loadingText' => 'Cargando Comunas...',
                        'params' => ['selected_ic'],
                    ]
                ])->label('Comuna*') ?>
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
        </div>
        <div class="row" style="text-align: center">
            <?= Html::submitButton('Modificar',["class" => "btn btn-primary"]) ?>
        </div>
    </div>
    <?php $form->end() ?>
</div>
