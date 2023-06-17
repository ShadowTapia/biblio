<?php

/**
 * @author Marcelo
 * @copyright 2020
 */

use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Crear Cursos';
$this->params['breadcrumbs'][] = ['label' => 'Administrar Cursos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin(['method' => 'post', 'enableClientValidation' => true,]);
?>
<div class="form-group col-xs-2">
    <?= $form->field($model, "Nombre")->input("text", ['width:450px;'])->label('Nombre*') ?>
</div>
<div class="form-group col-xs-1">
    <?= $form->field($model, "Orden")->input("text", ['width: 200px;'])->label('Orden') ?>
</div>
<div class="form-group">
    <?= $form->field($model, "visible")->widget(SwitchInput::class, ['type' => SwitchInput::CHECKBOX, 'pluginOptions' => ['size' => 'small', 'onText' => '<i class="glyphicon glyphicon-ok"></i>', 'offText' => '<i class="glyphicon glyphicon-remove"></i>', 'onColor' => 'success', 'offColor' => 'danger',],])->label('Visible') ?>
</div>

<?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary']) ?>

<?php $form->end() ?>