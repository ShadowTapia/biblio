<?php

/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 06-04-2021
 * Time: 10:20
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use app\models\cursos\Cursos;

$this->title = 'Prestar Libro ' . $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$this->registerJs(
    '$("#rutalumno").on("change", function(e){
                 var x = document.getElementById("togglesearch");
                 if(x.style.display==="none"){
                       x.style.display="block";
                 }
             });'
);
?>
<h1><?= Html::encode($this->title) ?></h1>
<h2>Prestamo para Alumnos <?= Yii::$app->session->get('nameAno') ?></h2>
<?php $form = ActiveForm::begin([
    'method' => 'post', 'id' => 'formIngPrestamo', 'class' => 'form-horizontal',
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
            <?= $form->field($modelAlumno, 'rutalumno')->widget(DepDrop::class, [
                'options' => ['id' => 'rutalumno', 'prompt' => 'Seleccione Alumno(a)'],
                'pluginOptions' => [
                    'depends' => ['idCurso'],
                    'placeholder' => 'Seleccione Alumno(a)',
                    'url' => Url::to(['prestamos/lista_alumnos']),
                    'loadingText' => 'Cargando Alumnos...',
                ]
            ])->label('Alumnos*') ?>
        </div>
    </div>
    <div id="togglesearch" style="display: none">
        <?= $this->render('_form', ['model' => $model, 'modelEjemplar' => $modelEjemplar]) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>