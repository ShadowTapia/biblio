<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title='Actualizar Correo';
$this->params['breadcrumbs'][] = $this->title;

?>
<?= \lavrentiev\widgets\toastr\NotificationFlash::widget([
    'options' => [
        "closeButton" => true,
        "debug" => false,
        "newestOnTop" => false,
        "progressBar" => false,
        "positionClass" => \lavrentiev\widgets\toastr\NotificationFlash::POSITION_TOP_RIGHT,
        "preventDuplicates" => false,
        "onclick" => null,
        "showDuration" => "300",
        "hideDuration" => "1000",
        "timeOut" => "5000",
        "extendedTimeOut" => "1000",
        "showEasing" => "swing",
        "hideEasing" => "linear",
        "showMethod" => "fadeIn",
        "hideMethod" => "fadeOut"
    ]
]) ?>
<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="form-group">
    <?= $form->field($model,"UserMail")->input("text",['style'=>'width:360px'],['autofocus'=>true])->label('E-mail Usuario') ?>
</div>

<?= Html::submitButton('Cambiar E-mail',['class'=>'btn btn-primary']) ?>

<?php $form->end() ?>