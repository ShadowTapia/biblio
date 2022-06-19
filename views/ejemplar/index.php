<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ejemplar\EjemplarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ejemplares';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \lavrentiev\widgets\toastr\NotificationFlash::widget([
    'options' => [
        "closeButton" => true,
        "debug" => false,
        "newestOnTop" => false,
        "progressBar" => false,
        "positionClass" => \lavrentiev\widgets\toastr\NotificationFlash::POSITION_TOP_RIGHT,
        "preventDuplicates" => false,
        "onclick" => null,
        "showDuration" => "300",
        "hideDuration" => "1000",
        "timeOut" => "5000",
        "extendedTimeOut" => "1000",
        "showEasing" => "swing",
        "hideEasing" => "linear",
        "showMethod" => "fadeIn",
        "hideMethod" => "fadeOut"
    ]
]) ?>
<div class="ejemplar-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
        $gridColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'header' => 'N°',
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            //Libro
            [
                'attribute' => 'idLibros',
                'label' => 'Libro',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->idLibros0->titulo) ? ($model->idLibros0->titulo) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //norden
            [
                'attribute' => 'norden',
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 120px;'],
            ],
            //Ubicación
            [
                'attribute' => 'ubicacion',
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 120px;'],
            ],
            //disponible
            [
                'attribute' => 'fechain',
                'format' => ['date','php:d-m-Y'],
                'contentOptions' => ['style' => 'width: 120px;'],

            ],
            //disponible
            [
                'attribute' => 'disponible',
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 120px;'],
                'value' => function($model){
                    return !empty($model->disponible) ? 'Si' : 'No';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '150'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                        'view' => function($url,$model){

                        },
                        'update' => function($url,$model){
                            return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['ejemplar/update','id'=>$model->idejemplar],
                                ['class'=>'btn btn-circle btn-success btn-sm','title'=>'Actualizar Ejemplar']);
                        },
                        'delete' => function($url,$model){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['ejemplar/delete','id' => $model->idejemplar],
                            [   'class' => 'btn btn-circle btn-danger btn-sm',
                                'title' => 'Borrar Ejemplar',
                                'data-toggle' => 'tooltip',
                                'data' => [
                                    'confirm' => '¿Estas seguro de borrar este Ejemplar ' . $model->idLibros . '?',
                                    'method' => 'post',
                                ],
                            ]);
                        }

                ],
            ],
        ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'export' => false,
        'pjax' => true,
        'emptyText' => 'No hay Ejemplares registrados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Ejemplares ' .'</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
