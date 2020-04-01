<?php
/* @var $this yii\web\View */

use app\models\Regiones;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title='Actualizar Provincia';
$this->params['breadcrumbs'][] = ['label' => 'Administrar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>

<div class="form-group">
    <?= $form->field($model,"Provincia")->input("text",['style'=>'width:450px; text-transform: uppercase;'])->label('Provincia*') ?>
</div>
<div class="form-group">
    <?php $region = ArrayHelper::map(Regiones::find()->where(['codRegion' => $model->codRegion])->all(),'codRegion','region'); ?>
    <?= $form->field($model,'codRegion')->dropDownList($region ,['style'=>'width:450px;'])->label('Regiones*') ?>
</div>

<?= Html::submitButton('Modificar',['class'=>'btn btn-primary']) ?>

<?php $form->end() ?>