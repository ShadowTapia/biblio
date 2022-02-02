<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\editorial\Editorial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="editorial-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-5">
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true,'autofocus'=> true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
