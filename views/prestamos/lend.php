<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Prestar Libro';
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
<div class="libros-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'method' => 'post', 'id' => 'formPresBarra', 'class' => 'form-horizontal',
        'enableClientValidation' => false, 'enableAjaxValidation' => true,
    ]); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <?= $form->field($modelEjemplar, 'idejemplar')
                    ->textInput(['class' => 'form-control', 'placeholder' => 'Código Ejemplar', 'maxlength' => true, 'autofocus' => true])
                    ->label("Código") ?>
            </div>
            <div class="col-xs-3">
                <?= Html::submitButton("consultar", ["class" => "btn btn-primary"]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>