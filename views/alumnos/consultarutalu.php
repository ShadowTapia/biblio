<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 15-04-2022
 * Time: 21:12
 */
 use yii\helpers\Html;
 use yii\widgets\ActiveForm;
 use yii\widgets\MaskedInput;

 $this->title = "Consultar Rut Alumno";
 $this->params['breadcrumbs'][] = $this->title;
 ?>

<h1><?= Html::encode($this->title) ?></h1>
    <div class="alumnos-form">
        <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'formConRutalu', 'class' => 'form-horizontal',
            'enableClientValidation' => false, 'enableAjaxValidation' => true,]);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-2">
                    <?= $form->field($model,'rutalumno')->widget(MaskedInput::class,['mask'=>'999.999.999-*'],['style'=>'width:8%'])->label('RUN*') ?>
                </div>
            </div>
            <div class="row">
                <?= Html::submitButton("Consultar",["class"=>"btn btn-primary"]) ?>
            </div>
        </div>
        <?php $form->end() ?>
    </div>
