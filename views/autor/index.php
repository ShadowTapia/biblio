<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\autor\AutorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Autores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="autor-index">

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
            //Nombre autor
            [
                'attribute' => 'nombre',
                'label' => 'Nombre',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->nombre) ? $model->nombre : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Nacionalidad
            [
                'attribute' => 'nacionalidad',
                'label' => 'Nacionalidad',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->nacionalidad) ? $model->nacionalidad : '<span class="glyphicon glyphicon-question-sign"></span>';
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
                            return Html::a("<span class='glyphicon glyphicon-info-sign'></span>",['autor/view','id' => $model->idautor],
                                [   'class' => 'btn btn-circle btn-primary btn-sm',
                                    'title' => 'Ver Autor'
                                ]);
                        },
                        'update' => function($url,$model){
                            return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['autor/update','id'=>$model->idautor],
                                ['class'=>'btn btn-circle btn-success btn-sm','title'=>'Actualizar Autor']);
                        },
                        'delete' => function($url,$model){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['autor/delete','id' => $model->idautor],
                                [   'class' => 'btn btn-circle btn-danger btn-sm',
                                    'title' => 'Borrar Autor',
                                    'data-toggle' => 'tooltip',
                                    'data' => [
                                        'confirm' => '¿Estas seguro de borrar al Autor ' . $model->nombre . '?',
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
        'emptyText' => 'No hay autores registrados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'toolbar' => [
                  'content' => Html::a('Ingresar', ['create'], ['class' => 'btn btn-success']),
        ],
        'panel' => [
                'type' => 'primary',
                'heading' => '<h3 class="panel-title">Listado de Autores ' .'</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
