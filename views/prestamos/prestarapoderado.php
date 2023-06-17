<?php

/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 18-05-2021
 * Time: 23:41
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\cursos\Cursos;
use kartik\depdrop\DepDrop;

$this->title = 'Prestar Libro ' . $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$this->registerJs(
    '$("#rutapo").on("change", function(e){
                 var x = document.getElementById("togglesearch");
                 if(x.style.display==="none"){
                       x.style.display="block";
                 }
             });'
);
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
<h1><?= Html::encode($this->title) ?></h1>
<h2>Prestamo Apoderados <?= Yii::$app->session->get('nameAno') ?></h2>
<?php $form = ActiveForm::begin([
    'method' => 'post', 'id' => 'formIngApoderados', 'class' => 'form-horizontal',
    'enableClientValidation' => false, 'enableAjaxValidation' => true,
]);
?>
<div class="container">
    <div class="row">
        <div class="row">
            <div class="col-xs-2">
                <?= Html::label('Curso') ?>
            </div>
        </div>
        <div class="col-xs-4">
            <?= Html::dropDownList('idCurso', null,  ArrayHelper::map(Cursos::find()->where(['visible' => '1'])->indexBy('idCurso')->orderBy('Orden')->all(), 'idCurso', 'Nombre'), ['id' => 'idCurso']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($modelApoderado, 'rutapo')->widget(DepDrop::class, [
                'options' => ['id' => 'rutapo', 'prompt' => 'Seleccione Apoderado(a)'],
                'pluginOptions' => [
                    'depends' => ['idCurso'],
                    'placeholder' => 'Seleccione Apoderado(a)',
                    'url' => Url::to(['prestamos/lista_apoderados']),
                    'loadingText' => 'Cargando Apoderados...',
                ]
            ])->label('Apoderados*') ?>
        </div>
    </div>
    <div id="togglesearch" style="display: none">
        <?= $this->render('_form', ['model' => $model, 'modelEjemplar' => $modelEjemplar]) ?>
    </div>
</div>
<?php $form->end() ?>