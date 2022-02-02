<?php
/* @var $this yii\web\View */

use app\models\Regiones;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title='Ingresar Provincias';
$this->params['breadcrumbs'][] = ['label' => 'Administrar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>

<div class="form-group">
    <?= $form->field($model,"idProvincia")->input("text",['style'=>'width:120px','autofocus'=>true])->label('Código Provincia*') ?>
</div>
<div class="form-group">
    <?= $form->field($model,"Provincia")->input("text",['style'=>'width:450px; text-transform: uppercase;'])->label('Provincia*') ?>
</div>
<div class="form-group">
    <?= $form->field($model,"codRegion")->dropDownList(
        ArrayHelper::map(Regiones::find()->orderBy('orden')->all(),'codRegion','region'),
        ['style'=>'width:450px;','prompt'=>'Seleccione Región']
    )->label('Regiones*') ?>
</div>
<?= Html::submitButton('Guardar',['class'=>'btn btn-primary']) ?>

<?php $form->end() ?>