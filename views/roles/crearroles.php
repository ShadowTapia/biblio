<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Ingresar Roles';
$this->params['breadcrumbs'][] = ['label' => 'Administrar Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'id' => $model->formName(),
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="form-group">
    <?= $form->field($model, "nombre")->input("text", ['style' => 'width:360px;'], ['autofocus' => true])->label('Nombre Rol') ?>
</div>
<div class="form-group">
    <?= $form->field($model, "descripcion")->input("text", ['style' => 'width:450px;'])->label(Html::encode('Descripción')) ?>
</div>

<?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
<?php $form->end() ?>