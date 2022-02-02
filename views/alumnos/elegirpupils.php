<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 22-04-2020
 * Time: 3:43
 */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title='Alumno(s) para el Curso ';
$this->params['breadcrumbs'][] = ['label' => 'Asignar Cursos', 'url' => ['asignar']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ." ". $_GET['nomcurso'] . " " . Yii::$app->session->get('nameAno') ?></h1>

<?=Html::beginForm(['ingresacurso'],'post'); ?>

<div class="grid-view">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['style' => 'width: 65%; align:center;'],
        'emptyCell' => '-',
        'summary' => "",
        'tableOptions' => ['class' => 'table table-bordered table-hover table-condensed table-striped'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            //Checkbox
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function($d)
                {
                    return ['value' => $d['idalumno']];
                }
            ],
            //Run alumno
            [
                'attribute' => 'rutalumno',
                'label' => 'Run',
                'headerOptions' => ['width' => '120px'],
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->rutalumno,0). "-" .  $model->digrut;
                }
            ],
            //Apellido paterno
            [
                'attribute' => 'paternoalu',
                'label' => 'A. Paterno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->paternoalu) ? $model->paternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Apellido materno
            [
                'attribute' => 'maternoalu',
                'label' => 'A. Materno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->maternoalu) ? $model->maternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Nombre alumno
            [
                'attribute' => 'nombrealu',
                'label' => 'Nombres',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->nombrealu) ? $model->nombrealu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ]
        ]
    ]) ?>
</div>
<p>
    <?=Html::submitButton('<span class="glyphicon glyphicon-check"></span> Asignar al Curso', ['class' => 'btn btn-success', 'data-toggle' => 'tooltip','title'=>'Ingresa alumno(s) a un Curso']); ?>
</p>

<?=Html::endForm(); ?>