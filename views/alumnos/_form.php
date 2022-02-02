<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\cursos\Cursos;

/* @var $this yii\web\View */
/* @var $model app\models\alumnos\Alumnos */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $this->registerJs(
            '$("document").ready(function(){
                    $("#select_curso").on("pjax:send", function() {
                        var wellShow = document.getElementById("well");
                        wellShow.style.display="block";
                    });    
                    $("#select_curso").on("pjax:end", function() {
                        $.pjax.reload({container:"#alumnos"});
                        var wellHide = document.getElementById("well");
                        wellHide.style.display="none";                                                       
                    });                                            
             });'

    );
?>

<div class="alumnos-search">
    <?php Pjax::begin(['id' => 'select_curso','timeout' => false]) ?>

    <?php $form = ActiveForm::begin([
            'options' => [
                    'data-pjax' => true
            ],
    ]); ?>
    <div class="row">
        <div class="col-xs-2">
            <?= $form->field($model,'idCurso')->dropDownList(Cursos::getListCursos(),
                ['class' => 'form-control', 'style' => 'width: 100%;', 'prompt' => 'Seleccione Curso','id' => 'Curso'])->label(false) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Buscar', ['class' => 'btn btn-success', 'id' => 'buscaButton']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
