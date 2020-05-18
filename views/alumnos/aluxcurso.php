<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 27-04-2020
 * Time: 12:45
 */
use app\models\cursos\Cursos;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title='Alumno(s) por Curso ';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin([
    'id' => 'Alumnos',
    'method' => 'post',
    'enableAjaxValidation' => true,
]); ?>

<div class="form-group">
        <?= $form->field($model,'idCurso')->dropDownList(Cursos::getListCursos(),
            ['class' => 'form-control', 'style' => 'width:200px;','prompt' => 'Seleccione Curso'])->label(' ')?>
</div>

<div class="col-xs-1">
    <?= Html::submitButton('Buscar',['class'=>'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
