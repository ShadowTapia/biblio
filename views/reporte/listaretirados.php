<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 09-05-2021
 * Time: 21:51
 */
use  yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Lista de Alumnos retirados';
?>

<h1 style="text-align: center"><?= Html::encode($this->title) ?></h1>

<div class="grid-view">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "",
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            //Curso del alumno
            [
                'attribute' => 'idCurso',
                'header' => 'Curso',
                'headerOptions' => ['width' => '80px'],
                'value' => function($data){
                    return $data->idCurso0->Nombre;
                }
            ],
            //Run Alumno
            [
                'attribute' => 'rutalumno',
                'header' => 'RUN',
                'headerOptions' => ['width' => '90px'],
                'value' => function($data){
                    return Yii::$app->formatter->asDecimal($data->idalumno0->rutalumno, 0). "-" . $data->idalumno0->digrut;
                }
            ],
            //Apellido paterno
            [
                'attribute' => 'paternoalu',
                'header' => 'A. Paterno',
                'headerOptions' => ['width' => '120px'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function($data){
                    return $data->idalumno0->paternoalu;
                }
            ],
            //Apellido materno
            [
                'attribute' => 'maternoalu',
                'header' => 'A. Materno',
                'headerOptions' => ['width' => '120px'],
                'contentOptions' => ['style' => 'text-align: center'],
                'value' => function($data){
                    return $data->idalumno0->maternoalu;
                }
            ],
            //Nombre alumno
            [
                'attribute' => 'nombrealu',
                'contentOptions' => ['style' => 'text-align: center'],
                'header' => 'Nombre',
                'value' => function($data){
                    return $data->idalumno0->nombrealu;
                }
            ],
            //Fecha retiro
            [
                'attribute' => 'fecharet',
                'header' => 'Fecha R.',
                'headerOptions' => ['width' => '80px'],
                'value' => function($data){
                    return Yii::$app->formatter->asDate($data->idalumno0->fecharet,'dd/MM/yyyy');
                }
            ]
        ],
    ]) ?>
</div>

