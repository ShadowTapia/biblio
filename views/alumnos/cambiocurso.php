<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 13-05-2020
 * Time: 9:47
 */
use app\models\alumnos\Alumnos;
use app\models\cursos\Cursos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Cambio de curso';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin([
    'id' => 'formulariocambioclase','class' => 'form-horizontal',
    'method' => 'post','enableClientValidation' => false,'enableAjaxValidation' => true, ]);
?>


    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <?= $form->field($model, 'idCurso')->dropDownList(Cursos::getListCursos(),
                    ['class' => 'form-control', 'style' => 'width:200px;','prompt' => 'Seleccione Curso', 'id' => 'idorigen','onchange' =>
                        '$.post("listalumnos?id= " +$(this).val(),function( data ) {
                            $("select#idalumno").html( data );
                           });'])->label('Curso Origen') ?>
            </div>
            <div class="col-xs-5">
                <?= $form->field($model,'idalumno')->dropDownList(Alumnos::dropdownalus(),
                    ['style' => 'width:100%', 'prompt' => 'Seleccione Alumno', 'id' => 'idalumno'])->label('Alumno(a)') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <?= $form->field($model2,'idCurso')->dropDownList(Cursos::getListCursos(),
                    ['class' => 'form-control', 'style' => 'width:200px;','prompt' => 'Seleccione Destino', 'id' => 'idCurso'])->label('Curso Destino') ?>
            </div>
            <div class="col-xs-5">
                <?= $form->field($model2,'motivo')->input("text",['style' => 'width:100%'])->label('Motivo') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <?= Html::submitButton("Cambiar Curso",["class" => "btn btn-primary"]) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>



