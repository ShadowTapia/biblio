<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idUser')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UserName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UserLastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UserPass')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Idroles')->textInput() ?>

    <?= $form->field($model, 'UserRut')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UserMail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authkey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accessToken')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activate')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'verification_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
