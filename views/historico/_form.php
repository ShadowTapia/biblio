<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\historico\Historico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historico-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idhistorico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idUser')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idejemplar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechapres')->textInput() ?>

    <?= $form->field($model, 'fechadev')->textInput() ?>

    <?= $form->field($model, 'fechadevReal')->textInput() ?>

    <?= $form->field($model, 'observacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'User')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UserMail')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
