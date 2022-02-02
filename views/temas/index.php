<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\temas\TemasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Temas';
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
<div class="temas-index">

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
            //nombre
            [
                'attribute' => 'nombre',
                'label' => 'Nombre',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->nombre) ? $model->nombre : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //codTemas
            [
                'attribute' => 'codtemas',
                'label' => 'Temas',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->codtemas) ? $model->codtemas : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Acciones
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '150'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-info-sign'></span>",['temas/view','id' => $model->idtemas],
                            [   'class' => 'btn btn-circle btn-primary btn-sm',
                                'title' => 'Ver Temas'
                            ]);
                    },
                    'update' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['temas/update','id'=>$model->idtemas],
                            ['class'=>'btn btn-circle btn-success btn-sm','title'=>'Actualizar Temas']);
                    },
                    'delete' => function($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['temas/delete','id' => $model->idtemas],
                            [   'class' => 'btn btn-circle btn-danger btn-sm',
                                'title' => 'Borrar Tema',
                                'data-toggle' => 'tooltip',
                                'data' => [
                                    'confirm' => '¿Estas seguro de borrar el Tema ' . $model->nombre . '?',
                                    'method' => 'post',
                                ],
                            ]);
                    },
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
        'emptyText' => 'No hay autores registrados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'toolbar' => [
                'content' => Html::a('Crear Temas', ['create'], ['class' => 'btn btn-success']),
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Temas ' .'</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
