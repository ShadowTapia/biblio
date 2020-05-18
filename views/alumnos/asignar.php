<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use app\models\cursos\Cursos;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title='Asignar Cursos';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= $this->title ." ". Yii::$app->session->get('nameAno') ?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'Alumnos',
    'method' => 'post',
    'enableAjaxValidation' => true,
]); ?>
    <div class="form-group">
        <?= $form->field($model,'idCurso')->dropDownList(Cursos::getListCursos(),
            ['class' => 'form-control', 'style' => 'width:300px;','prompt' => 'Seleccione Curso','id' => 'idCurso'])->label('Curso*') ?>
    </div>
<?= Html::submitButton('Matricular Alumno(s)',['class'=>'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>