<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title= utf8_encode('Actualizar Regi�n');
$this->params['breadcrumbs'][] = ['label' => 'Administrar', 'url' => ['create']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="form-group">
    <?= $form->field($model,"region")->input("text",['style'=>'width:450px; text-transform: uppercase;'])->label(utf8_encode('Regi�n')) ?>
</div>
<div class="form-group">
    <?= $form->field($model,"orden")->input("text",['style'=>'width:100px;'])->label('Orden') ?>
</div>

<?= Html::submitButton('Modificar',['class'=>'btn btn-primary']) ?>

<?php $form->end() ?>