<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Actualizar Región';

?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="row">
    <div class="form-group col-xs-4">
        <?= $form->field($model, "region")->input("text", ['style' => 'width:450px; text-transform: uppercase;'])->label('Región') ?>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-2">
        <?= $form->field($model, "orden")->input("text", ['style' => 'width:100px;'])->label('Orden') ?>
    </div>
</div>

<?= Html::submitButton('Modificar', ['class' => 'btn btn-primary']) ?>

<?php $form->end() ?>