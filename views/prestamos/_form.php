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
            ])->label('F. Devolución*')
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