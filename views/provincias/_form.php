<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Provincias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="provincias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Provincia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codRegion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
