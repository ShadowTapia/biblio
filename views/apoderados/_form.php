<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\apoderados\Apoderados */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Ingreso de Apoderados";
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="apoderados-form">

    <?php $form = ActiveForm::begin(['id' => 'FormIngApos', 'class' => 'form-horizontal',
        'enableClientValidation' => false, 'enableAjaxValidation' => true,]); ?>
    <div class="container">
        <div class="row">

        </div>
    </div>

    <?= $form->field($model, 'rutapo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'digrut')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombreapo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apepat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apemat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'depto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'block')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'villa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codRegion')->textInput() ?>

    <?= $form->field($model, 'idProvincia')->textInput() ?>

    <?= $form->field($model, 'codComuna')->textInput() ?>

    <?= $form->field($model, 'fono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estudios')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'niveledu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profesion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trabajoplace')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'relacion')->dropDownList([ 'Madre' => 'Madre', 'Padre' => 'Padre', 'Abuela' => 'Abuela', 'Abuelo' => 'Abuelo', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'rutalumno')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
