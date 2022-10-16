<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 19-04-2022
 * Time: 0:26
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\jui\DatePicker;
use app\models\Regiones;
use app\models\cursos\Cursos;
use kartik\depdrop\DepDrop;

$this->title = "Ingresa Alumno(a) a partir de alumnos ya retirados";
$this->params['breadcrumbs'][]= $this->title;
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
<div class="alumnos-form">
    <?php $form = ActiveForm::begin(['method' => 'post',
        'id' => 'formPupilExist',
        'class' => 'form-horizontal',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,]);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model,"rutalumno")->widget(MaskedInput::class,['mask'=>'999.999.999-*'],['style'=>'width:20%'])->label('RUN*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,"nombrealu")->textInput(['style'=> 'width:100%'])->label('Nombres*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,"paternoalu")->textInput(['style'=> 'width:100%'])->label('A. Paterno*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,"maternoalu")->textInput(['style'=> 'width:100%'])->label('A. Materno*') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model,"fechanac")->widget(DatePicker::class,[
                    'dateFormat' => 'dd-MM-yyyy',
                    'language' => 'ES',
                    'clientOptions' => [
                        'yearRange' => '-115:+0',
                        'changeYear' => true
                    ],
                    'options' => ['class' => 'form-control datepicker', 'style' => 'width:80%']])->label('F. Nacimiento*')
                ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model,'calle')->input("text",['style' => 'width:100%'])->label('Dirección') ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model,'nro')->input("text",['style' => 'width:100%'])->label('Nro') ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model,'depto')->input("text",['style' => 'width:70%'])->label('Depto') ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model,'block')->input("text",['style' => 'width:70%'])->label('Block') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model,'villa')->input("text",['style' => 'width:100%'])->label('Villa') ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model,"codRegion")->dropDownList(Regiones::getListRegiones(),
                    ['class' => 'form-control', 'style'=>'width:100%;','prompt'=>'Seleccione Región',
                        'id'=>'codRegion'])->label('Regiones*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,"idProvincia")->widget(DepDrop::class,[
                    'options'=>['id'=>'idProvincia','prompt'=>'Seleccione Provincia'],
                    'pluginOptions'=>[
                        'depends'=>['codRegion'],
                        'placeholder'=>'Seleccione Provincia',
                        'initialize' => true,
                        'url'=>Url::to(['apoderados/lista_provincia']),
                        'loadingText' => 'Cargando Provincias...',
                    ]
                ])->label('Provincia*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model,"codComuna")->widget(DepDrop::class,[
                    'options'=>['id'=>'codComuna','prompt' => 'Seleccione Comuna','style' => 'width:80%;'],
                    'pluginOptions'=>[
                        'depends'=>['idProvincia'],
                        'placeholder'=>'Seleccione Comuna',
                        'initialize' => true,
                        'url'=>Url::to(['apoderados/listcomu']),
                        'loadingText' => 'Cargando Comunas...',
                    ]
                ])->label('Comuna*') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <div class="form-group">
                    <?= $form->field($model,"sexo")->radioList(['F' => 'Femenino', 'M' => 'Masculino']) ?>
                </div>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model,'email')->input("text",['style' => 'width:100%'])->label('Email') ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model,'fono')->input("text",['style' => 'width:100%'])->label('Teléfono') ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($model,'nacionalidad')->dropDownList(['1' => 'Chilena', '2' => 'Extranjera'],
                    ['style' => 'width:100%;','prompt' => 'Seleccione','id' => 'Nacionalidad'])->label('Nacionalidad') ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($model,"fechaing")->widget(DatePicker::class,[
                    'dateFormat' => 'dd-MM-yyyy',
                    'clientOptions' => [
                        'yearRange' => '-115:+0',
                        'changeYear' => true
                    ],
                    'options' => ['class' => 'form-control', 'style' => 'width:80%']])->label('F. Ingreso')
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model,'sangre')->textInput(['style' => 'width:100%']) ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model,'enfermedades')->textInput(['style' => 'width:100%']) ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($model,'alergias')->textInput(['style' => 'width:100%']) ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model,'medicamentos')->textInput(['style' => 'width:100%']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <?= $form->field($modelPivot,'idCurso')->dropDownList(Cursos::getListCursos(),
                    ['class' => 'form-control', 'style' => 'width:100%;','prompt' => 'Seleccione Curso', 'id' => 'idCurso'])->label('Curso*') ?>
            </div>
        </div>
        <div class="row" style="text-align: center">
            <?= Html::submitButton("Registrar", ["class" => "btn btn-primary"]) ?>
        </div>
    </div>
    <?php $form->end() ?>
</div>
