<?php

/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 13-05-2020
 * Time: 9:47
 */

use app\models\cursos\Cursos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Cambio de curso para alumno(a) ' . $name;
$this->params['breadcrumbs'][] = ['label' => 'Listado de alumnos para cambio de curso.-', 'url' => ['alumnos/listacambiocurso']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h3><?= $this->title ?></h3>
<?php $form = ActiveForm::begin([
    'id' => $model->formName(), 'class' => 'form-horizontal',
    'method' => 'post', 'enableClientValidation' => false, 'enableAjaxValidation' => true,
]);
?>


<div class="container">

    <div class="row">
        <div class="col-xs-3">
            <?= $form->field($model, 'idCurso')->dropDownList(
                Cursos::getListCursos(),
                ['class' => 'form-control', 'style' => 'width:200px;', 'prompt' => 'Seleccione Destino', 'id' => 'idCurso']
            )->label('Curso Destino') ?>
        </div>
        <div class="col-xs-5">
            <?= $form->field($model, 'motivo')->input("text", ['style' => 'width:100%'])->label('Motivo') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <?= Html::submitButton("Cambiar Curso", ["class" => "btn btn-primary"]) ?>
        </div>
    </div>
</div>

<?php $form->end(); ?>