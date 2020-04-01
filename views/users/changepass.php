<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title= utf8_encode('Modificar Contraseña');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= utf8_encode('Modificar contraseña')?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="form-group">
    <?= $form->field($model,"password")->input("password",['style'=>'width:40%'])->label(utf8_encode('Antigua contraseña')) ?>
</div>
<div class="form-group">
    <?= $form->field($model,"password_new")->input("password",['style'=>'width:40%'])->label(utf8_encode('Nueva contraseña')) ?>
</div>
<div class="form-group">
    <?= $form->field($model,"password_repeat")->input("password",['style'=>'width:40%'])->label(utf8_encode('Repetir contraseña')) ?>
</div>

<?= Html::submitButton(utf8_encode('Cambiar contraseña'),['class'=>'btn btn-primary']) ?>

<?php $form->end() ?>