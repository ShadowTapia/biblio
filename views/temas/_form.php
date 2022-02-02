<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\temas\Temas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="temas-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-5">
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true,'autofocus'=>true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model, 'codtemas')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
