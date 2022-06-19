<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title='Ingresar Regiones';
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
    <?= $form->field($model,"codRegion")->input("text",['style'=>'width:120px','autofocus'=>true])->label('Código Región*') ?>
</div>
<div class="form-group">
    <?= $form->field($model,"region")->input("text",['style'=>'width:360px; text-transform: uppercase;'])->label(utf8_encode('Nombre*')) ?>
</div>
<div class="form-group">
    <?= $form->field($model,"orden")->input("text",['style'=>'width:120px'])->label('Orden') ?>
</div>

<?= Html::submitButton('Guardar',['class'=>'btn btn-primary']) ?>

<?php $form->end() ?>