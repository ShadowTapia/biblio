<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 28-04-2020
 * Time: 0:23
 */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title='Curso ';
$this->params['breadcrumbs'][] = ['label' => 'Alumnos por Curso', 'url' => ['aluxcurso']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ." ". $_GET['nomcurso'] . " " . Yii::$app->session->get('nameAno') ?></h1>

<p>
    <?= Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir', ['reporte'],['class' => 'btn btn-warning','target'=>'_blank','data-toggle'=>'tooltip', 'title'=>'Generara un reporte en formato pdf']) ?>
</p>

<div class="grid-view">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['style' => 'width: 65%; align:center;'],
        'emptyCell' => '-',
        'summary' => "",
        'emptyText' => 'No hay resultados para este Curso',
        'tableOptions' => ['class' => 'table table-bordered table-hover table-condensed table-striped'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
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