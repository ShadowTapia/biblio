<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\jui\DatePicker;
use app\models\Regiones;
use kartik\depdrop\DepDrop;
use kartik\switchinput\SwitchInput;
/* @var $this yii\web\View */
/* @var $model app\models\alumnos\Alumnos */

$this->title = 'Actualizar Alumno: ' . $model->nombrealu . ' ' . $model->paternoalu;
$this->params['breadcrumbs'][] = ['label' => 'Listado de Alumnos para actualizar', 'url' => ['upgeneral']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
    function isInternalRetiro() {
        $('#retirado').on('change', function() {
            showOrHideActivateFecha();
        });
    }

    function showOrHideActivateFecha() {
        if ($('#retirado').is(':checked')) {
            $('#fecharetiro').show()
        } else {
            $('#fecharetiro').hide();
        }
    }
    $(document).ready(function() {
        <?php
        if ($modelPivot->retirado) {
            echo "
                 showOrHideActivateFecha();
                ";
        }
        ?>
    })
</script>
<div class="alumnos-update">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php $form = ActiveForm::begin([
        'id' => 'formUpdateAlus',
        'class' => 'form-horizontal',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
    ]); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model, "rutalumno")->widget(MaskedInput::class, ['mask' => '999.999.999-*',], ['style' => 'width:20%'])->label('RUN*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, "nombrealu")->input("text", ['style' => 'width:100%'])->label('Nombres*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, "paternoalu")->input("text", ['style' => 'width:100%'])->label('A. Paterno*') ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, "maternoalu")->input("text", ['style' => 'width:100%'])->label('A. Materno*') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model, "fechanac")->widget(DatePicker::class, [
                    'dateFormat' => 'dd-MM-yyyy',
                    'language' => 'ES',
                    'clientOptions' => [
                        'yearRange' => '-115:+0',
                        'changeYear' => true
                    ],
                    'options' => ['class' => 'form-control datepicker', 'style' => 'width:80%']
                ])->label('F. Nacimiento*')
                ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'calle')->input("text", ['style' => 'width:100%'])->label('Dirección') ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model, 'nro')->input("text", ['style' => 'width:100%'])->label('Nro') ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model, 'depto')->input("text", ['style' => 'width:70%'])->label('Depto') ?>
            </div>
            <div class="col-xs-1">
                <?= $form->field($model, 'block')->input("text", ['style' => 'width:70%'])->label('Block') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model, 'villa')->input("text", ['style' => 'width:100%'])->label('Villa') ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model, "codRegion")->dropDownList(
                    Regiones::getListRegiones(),
                    [
                        'class' => 'form-control', 'style' => 'width:100%;', 'prompt' => 'Seleccione Región',
                        'id' => 'codRegion'
                    ]
                )->label('Regiones*') ?>
            </div>
            <?php echo Html::hiddenInput('selected_id', $model->idProvincia, ['id' => 'selected_id']) ?>
            <div class="col-xs-3">
                <?= $form->field($model, "idProvincia")->widget(DepDrop::class, [
                    'options' => ['id' => 'idProvincia', 'prompt' => 'Seleccione Provincia'],
                    'pluginOptions' => [
                        'depends' => ['codRegion'],
                        'placeholder' => 'Seleccione Provincia',
                        'url' => Url::to(['apoderados/lista_provincia']),
                        'loadingText' => 'Cargando Provincias...',
                        'initialize' => true,
                        'params' => ['selected_id'],
                    ]
                ])->label('Provincia*') ?>
            </div>
            <?php echo Html::hiddenInput('selected_ic', $model->codComuna, ['id' => 'selected_ic']) ?>
            <div class="col-xs-3">
                <?= $form->field($model, "codComuna")->widget(DepDrop::class, [
                    'options' => ['id' => 'codComuna', 'prompt' => 'Seleccione Comuna', 'style' => 'width:80%;'],
                    'pluginOptions' => [
                        'depends' => ['idProvincia'],
                        'placeholder' => 'Seleccione Comuna',
                        'url' => Url::to(['apoderados/listcomu']),
                        'loadingText' => 'Cargando Comunas...',
                        'params' => ['selected_ic'],
                    ]
                ])->label('Comuna*') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <div class="form-group">
                    <?= $form->field($model, "sexo")->radioList(['F' => 'Femenino', 'M' => 'Masculino'], ['style' => 'inline:true']) ?>
                </div>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'email')->input("text", ['style' => 'width:100%'])->label('Email') ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'fono')->input("text", ['style' => 'width:100%'])->label('Teléfono') ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($model, 'nacionalidad')->dropDownList(
                    ['1' => 'Chilena', '2' => 'Extranjera'],
                    ['style' => 'width:100%;', 'prompt' => 'Seleccione', 'id' => 'Nacionalidad']
                )->label('Nacionalidad') ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($model, "fechaing")->widget(DatePicker::class, [
                    'dateFormat' => 'dd-MM-yyyy',
                    'clientOptions' => [
                        'yearRange' => '-115:+0',
                        'changeYear' => true
                    ],
                    'options' => ['class' => 'form-control', 'style' => 'width:80%']
                ])->label('F. Ingreso')
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($model, 'sangre')->textInput(['style' => 'width:100%']) ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model, 'enfermedades')->textInput(['style' => 'width:100%']) ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($model, 'alergias')->textInput(['style' => 'width:100%']) ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model, 'medicamentos')->textInput(['style' => 'width:100%']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <?= $form->field($modelPivot, 'retirado')->widget(SwitchInput::class, [
                    'type' => SwitchInput::CHECKBOX,
                    'pluginOptions' => [
                        'size' => 'small',
                        'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                        'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                        'onColor' => 'success',
                        'offColor' => 'danger',
                    ],
                ])->label('Retirar') ?>
            </div>
            <div id="fecharetiro" class="col-xs-2">
                <?= $form->field($model, "fecharet")->widget(DatePicker::class, [
                    'dateFormat' => 'dd-MM-yyyy',
                    'language' => 'ES',
                    'clientOptions' => [
                        'yearRange' => '-115:+0',
                        'changeYear' => true
                    ],
                    'options' => ['class' => 'form-control datepicker', 'style' => 'width:80%']
                ])->label('F. Retiro')
                ?>
            </div>
        </div>
        <div class="row" style="text-align: center">
            <?= Html::submitButton("Actualizar", ["class" => "btn btn-primary"]) ?>
        </div>
    </div>
    <?php $form->end() ?>

</div>