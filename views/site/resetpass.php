<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h1>Reseteado de Contraseña</h1>

<?php
$form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="container">
    <div class="row">
        <div class="col-xs-5">
            <?= $form->field($model, "UserMail")->input("email")->label("E-mail") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, "UserPass")->input("password")->label("Contraseña") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, "password_repeat")->input("password")->label("Confirmar Contraseña") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <?= $form->field($model, "verification_code")->input("text")->label("Código de verificación") ?>
        </div>
    </div>
    <div class="form-group">
        <?= $form->field($model, "recover")->input("hidden")->label(false) ?>
    </div>
    <div class="row">
        <div class="col-md-5">
            <?= Html::submitButton("Resetear contraseña", ["class" => "btn btn-primary"]) ?>
        </div>
    </div>
</div>
<?php $form->end() ?>