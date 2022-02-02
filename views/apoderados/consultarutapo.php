<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 27-09-2020
 * Time: 11:00
 */

use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\Html;

$this->title = "Consulta RUN Apoderado";
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>
    <div class="apoderados-form">
        <?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'formConRut', 'class' => 'form-horizontal',
        'enableClientValidation' => false, 'enableAjaxValidation' => true,]);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-2">
                    <?= $form->field($model,'rutapo')->widget(MaskedInput::className(),['mask'=>'99.999.999-*'],['style'=>'width:8%'])->label('RUN*') ?>
                </div>
            </div>
            <div class="row">
                <?= Html::submitButton("Consultar",["class"=>"btn btn-primary"]) ?>
            </div>
        </div>
        <?php $form->end() ?>
    </div>
