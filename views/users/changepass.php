<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title= utf8_encode('Modificar Contraseņa');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= utf8_encode('Modificar contraseņa')?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="form-group">
    <?= $form->field($model,"password")->input("password",['style'=>'width:40%'])->label(utf8_encode('Antigua contraseņa')) ?>
</div>
<div class="form-group">
    <?= $form->field($model,"password_new")->input("password",['style'=>'width:40%'])->label(utf8_encode('Nueva contraseņa')) ?>
</div>
<div class="form-group">
    <?= $form->field($model,"password_repeat")->input("password",['style'=>'width:40%'])->label(utf8_encode('Repetir contraseņa')) ?>
</div>

<?= Html::submitButton(utf8_encode('Cambiar contraseņa'),['class'=>'btn btn-primary']) ?>

<?php $form->end() ?>