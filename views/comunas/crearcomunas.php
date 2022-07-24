<?php

/**
 * @author Marcelo
 * @copyright 2019
 */
use app\models\Provincias;
use app\models\Regiones;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title='Ingresar Comunas';
$this->params['breadcrumbs'][] = ['label' => 'Administrar Comunas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
<div class="form-group">
    <?= $form->field($model,"codComuna")->input("text",['style'=>'width:120px','autofocus'=>true])->label('Código Comuna*') ?>
</div>
<div class="form-group">
    <?= $form->field($model,"comuna")->input("text",['style'=>'width:450px; text-transform: uppercase;'])->label('Comuna*') ?>
</div>
<div class="form-group">
    <?= $form->field($model,"codRegion")->dropDownList(Regiones::getListRegiones(),        
        ['class' => 'form-control', 'style'=>'width:450px;','prompt'=>'Seleccione Región','onchange' =>
        '$.post("lists?id= " +$(this).val(),function( data ) {
            $("select#idProvincia").html( data );
            });']
    )->label('Regiones*') ?>
</div>
<div class="form-group">
     <?= $form->field($model,"idProvincia")->dropDownList(Provincias::dropdown(),
                ['style' => 'width:450px;','prompt'=> 'Seleccione Provincia','id'=>'idProvincia']
        )->label('Provincia*') ?>
</div>

<?= Html::submitButton('Guardar',['class'=>'btn btn-primary']) ?>

<?php $form->end() ?>