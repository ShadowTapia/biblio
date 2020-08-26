<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\categorias\CategoriasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categorías';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-index">

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
            //Id de la categoría
            [
                'attribute' => 'idcategoria',
                'label' => 'Id',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->idcategoria) ? $model->idcategoria : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Nombre de la categoría
            [
                'attribute' => 'categoria',
                'label' => 'Categoría',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->categoria) ? $model->categoria : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Acciones
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width' => '150'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-info-sign'></span>",['categorias/view','id' => $model->idcategoria],
                            [   'class' => 'btn btn-circle btn-primary btn-sm',
                                'title' => 'Ver Categorías'
                            ]);
                    },
                    'update' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['categorias/update','id'=>$model->idcategoria],
                            ['class'=>'btn btn-circle btn-success btn-sm','title'=>'Actualizar Categorías']);
                    },
                    'delete' => function($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['categorias/delete','id' => $model->idcategoria],
                            [   'class' => 'btn btn-circle btn-danger btn-sm',
                                'title' => 'Borrar Categoría',
                                'data-toggle' => 'tooltip',
                                'data' => [
                                    'confirm' => '¿Estas seguro de borrar esta Categoría ' . $model->categoria . '?',
                                    'method' => 'post',
                                ],
                            ]);
                    }
                ],
            ]
        ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'export' => false,
        'pjax' => true,
        'emptyText' => 'No hay categorías registradas.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'toolbar' => [
            Html::a('Crear Categorías', ['create'], ['class' => 'btn btn-success']),
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Categorías ' .'</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
