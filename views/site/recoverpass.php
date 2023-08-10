<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>Recuperar Contraseña</h1>

<?php
$form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="row">
    <div class="col-xs-5">
        <?= $form->field($model, "UserMail")->input("email")->label("E-Mail") ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= Html::submitButton("Recuperar", ["class" => "btn btn-primary"]) ?>
    </div>
</div>
<?php $form->end() ?>