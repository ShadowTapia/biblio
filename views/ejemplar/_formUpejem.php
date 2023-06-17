<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\switchinput\SwitchInput;


/* @var $this yii\web\View */
/* @var $model app\models\ejemplar\Ejemplar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ejemplar-form">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'id' => 'FormIngEjemplar',
        'class' => 'form-horizontal',
        'enableClientValidation' => true
    ]); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model, 'norden')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, 'edicion')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, 'ubicacion')->dropDownList(
                    [
                        'CRA' => 'CRA',
                        'UTP' => 'UTP',
                        'AULA' => 'AULA',
                        'DIRECCIÓN' => 'DIRECCIÓN',
                        'JARDÍN INFANTIL' => 'JARDÍN INFANTIL',
                    ],
                    ['class' => 'form-control', 'style' => 'width:100%;', 'prompt' => 'Seleccione']
                ) ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($model, "fechain")->widget(DatePicker::class, [
                    'dateFormat' => 'dd-MM-yyyy',
                    'language' => 'ES',
                    'clientOptions' => [
                        'yearRange' => '-115:+0',
                        'changeYear' => false
                    ],
                    'options' => ['class' => 'form-control datepicker', 'style' => 'width:80%']
                ])
                ?>
            </div>
            <div class="col-xs-offset-0">
                <?= $form->field($model, "disponible")->widget(
                    SwitchInput::class,
                    [
                        'type' => SwitchInput::CHECKBOX, 'pluginOptions' =>
                        [
                            'size' => 'small',
                            'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                            'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                        ],
                    ]
                ) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model, "fechaout")->widget(DatePicker::class, [
                    'dateFormat' => 'dd-MM-yyyy',
                    'language' => 'ES',
                    'clientOptions' => [
                        'yearRange' => '-115:+0',
                        'changeYear' => false
                    ],
                    'options' => ['class' => 'form-control datepicker', 'style' => 'width:80%']
                ])
                ?>
            </div>
        </div>
        <div class="row" style="text-align: center">
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>