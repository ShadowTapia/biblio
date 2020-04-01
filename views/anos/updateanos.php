<?php
/* @var $this yii\web\View */
/**
 * @author Marcelo
 * @copyright 2019
 */

use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title=utf8_encode('Actualizar A�os');
$this->params['breadcrumbs'][] = ['label' => utf8_encode('Administrar A�os'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,    
]);
?>

<div class="form-group col-xs-2">
    <?= $form->field($model,"nombreano")->input("text",['width:450px;'])->label(utf8_encode('A�o*')) ?>
</div>

<div class="form-group">
    <?= $form->field($model,"activo")->widget(SwitchInput::className(),['type' => SwitchInput::CHECKBOX,'pluginOptions' => ['size' => 'small','onText' => '<i class="glyphicon glyphicon-ok"></i>','offText'=>'<i class="glyphicon glyphicon-remove"></i>','onColor' => 'success','offColor' => 'danger',],])->label('Activo') ?>
</div>

<?= Html::submitButton('Modificar',['class'=>'btn btn-primary']) ?>
<?php $form->end() ?>