<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\prestamos\Prestamos */

$this->title = 'Actualizar Prestamo: ' . $libro;
$this->params['breadcrumbs'][] = ['label' => 'Prestamos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualizar';
?>

<div class="prestamos-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h2><?= 'Prestado a: ' . $name ?></h2>
    <?php $form=ActiveForm::begin([
        'method'=>'post', 'id'=>'formUpdatePrestamo', 'class'=>'form-horizontal',
        'enableClientValidation' => false, 'enableAjaxValidation' => true,
    ]); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model,"fechapres")->widget(DatePicker::className(),[
                    'dateFormat' => 'dd-MM-yyyy',
                    'language' => 'ES',
                    'clientOptions' => [
                        'yearRange' => '-115:+0',
                        'changeYear' => true
                    ],
                    'options' => ['class' => 'form-control datepicker', 'style' => 'width:80%']])->label('F. Prestamo*')
                ?>
            </div>
            <?php echo Html::hiddenInput('idpres',$model->idPrestamo,['id'=>'idpres']) ?>
            <div class="col-xs-2">
                <?= $form->field($model,"fechadev")->widget(DatePicker::className(),[
                    'dateFormat' => 'dd-MM-yyyy',
                    'language' => 'ES',
                    'clientOptions' => [
                        'yearRange' => '-115:+0',
                        'changeYear' => true
                    ],
                    'options' => ['class' => 'form-control datepicker', 'style' => 'width:80%']])->label('F. Devolución')
                ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model,'notas')
                    ->textInput(['class'=> 'form-control', 'placeholder'=>'Notas'])
                    ->label('Notas') ?>
            </div>
        </div>
        <div class="row" style="text-align: center">
                <?= Html::submitButton('Actualizar',['class'=>'btn btn-primary']) ?>
        </div>
    </div>
    <?php $form->end() ?>
</div>
