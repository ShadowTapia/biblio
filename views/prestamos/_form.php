<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\prestamos\Prestamos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prestamos-form">
    <?php Pjax::begin(['id' => 'prestamoing', 'timeout' => false]) ?>
    <?php $form = ActiveForm::begin([
        'options' => [
            'data-pjax' => true
        ],
    ]); ?>
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($modelEjemplar, 'norden')
                ->textInput(['class' => 'form-control', 'placeholder' => 'N° Orden', 'disabled' => true])
                ->label('N° Orden') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($modelEjemplar, 'edicion')
                ->textInput(['class' => 'form-control', 'placeholder' => 'Edición', 'disabled' => true])
                ->label('Edición') ?>
        </div>
        <div class="col-xs-2">
            <?= $form->field($modelEjemplar, 'ubicacion')
                ->textInput(['class' => 'form-control', 'placeholder' => 'Ubicación', 'disabled' => true])
                ->label('Ubicación') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model, "fechapres")->widget(DatePicker::class, [
                'dateFormat' => 'dd-MM-yyyy',
                'language' => 'ES',
                'clientOptions' => [
                    'yearRange' => '-115:+0',
                    'changeYear' => true
                ],
                'options' => ['class' => 'form-control datepicker', 'style' => 'width:80%']
            ])->label('F. Prestamo*')
            ?>
        </div>
        <div class="col-xs-2">
            <?= $form->field($model, "fechadev")->widget(DatePicker::class, [
                'dateFormat' => 'dd-MM-yyyy',
                'language' => 'ES',
                'clientOptions' => [
                    'yearRange' => '-115:+0',
                    'changeYear' => true
                ],
                'options' => ['class' => 'form-control datepicker', 'style' => 'width:80%']
            ])->label('F. Devolución')
            ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'notas')
                ->textInput(['class' => 'form-control', 'placeholder' => 'Notas'])
                ->label('Notas') ?>
        </div>
    </div>
    <div class="row" style="text-align: center">
        <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>