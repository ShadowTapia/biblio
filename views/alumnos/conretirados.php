<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 26-04-2021
 * Time: 11:40
 */

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Consulta de Alumnos retirados '. Yii::$app->session->get('nameAno');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="alumnos-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        $gridColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'header' => 'N°',
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            //Curso del alumno
            [
                'attribute' => 'idCurso',
                'headerOptions' => ['width' => '120px'],
                'header' => 'Curso',
                'value' => function($model){
                    return $model->idCurso0->Nombre;
                }
            ],
            //Rut Alumno
            [
                'attribute' => 'rutalumno',
                'label' => 'RUN',
                'format' => 'html',
                'headerOptions' => ['width' => '120px'],
                'value' => function($model) {
                    return Yii::$app->formatter->asDecimal($model->idalumno0->rutalumno, 0) . "-" . $model->idalumno0->digrut;
                }
            ],
            //Apellido paterno
            [
                'attribute' => 'paternoalu',
                'label' => 'A. Paterno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->idalumno0->paternoalu) ? $model->idalumno0->paternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Apellido materno
            [
                'attribute' => 'maternoalu',
                'label' => 'A. Materno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->idalumno0->maternoalu) ? $model->idalumno0->maternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Nombre alumno
            [
                'attribute' => 'nombrealu',
                'label' => 'Nombres',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->idalumno0->nombrealu) ? $model->idalumno0->nombrealu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Fecha Retiro
            [
                'attribute' => 'fecharet',
                'label' => 'F. Retiro',
                'format' => 'html',
                'value' => function($model){
                    return !empty(Yii::$app->formatter->asDate($model->idalumno0->fecharet,'dd/MM/yyyy')) ? Yii::$app->formatter->asDate($model->idalumno0->fecharet,'dd/MM/yyyy') : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
        ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'export' => false,
        'emptyText' => 'No hay Alumnos retirados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'toolbar' => [
                Html::a('Imprimir',['reportretirado'],['class' => 'btn btn-warning','target'=>'_blank','data-toggle'=>'tooltip','title'=>'Generara un reporte en formato pdf'])
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Alumnos retirados ' .'</h3>',
        ]
    ]) ?>
</div>
