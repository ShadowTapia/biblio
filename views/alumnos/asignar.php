<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use app\models\pivot\Pivot;
use yii\bootstrap\ActiveForm;


$this->title='Asignar Cursos';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= $this->title ." ". Yii::$app->session->get('nameAno') ?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'Alumnos',
    'method' => 'post',
    'enableAjaxValidation' => false,
]); ?>

<div class="form-group">
    <?= $form->field($model,"idalumno")->dropDownList(Pivot::getAlumnosSinCurso(),['style' => 'width:450px','prompt' => 'Seleccione Alumno','id'=>'idalumno'])->label('Alumnos*') ?>
</div>
<?php ActiveForm::end(); ?>