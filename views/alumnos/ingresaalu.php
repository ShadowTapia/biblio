<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 17-05-2020
 * Time: 14:31
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;


$this->title = "Ingresa Alumno(a)";
$this->params['breadcrumbs'][]= $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $form = ActiveForm::begin(['method' => 'post', 'id' => 'formIngAlus', 'class' => 'form-horizontal',
    'enableClientValidation' => false, 'enableAjaxValidation' => true, ]);
?>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model,"rutalumno")->widget(MaskedInput::className(),['mask'=>'99.999.999-*',],['style'=>'width:20%'])->label('RUN*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model,"nombrealu")->input("text",['style'=> 'width:100%'])->label('Nombres*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model,"paternoalu")->input("text",['style'=> 'width:100%'])->label('A. Paterno*') ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model,"maternoalu")->input("text",['style'=> 'width:100%'])->label('A. Materno*') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model,"fechanac")->widget()
        </div>
    </div>
</div>
<?php $form->end() ?>