<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\libros\LibrosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Libros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libros-index">

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
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function($model, $key, $index, $column){
                    return Yii::$app->controller->renderPartial('view', ['model'=> $model]);
                },
                'expandOneOnly' => true
            ],
            //Id
            [
                'attribute' => 'idLibros',
                'label' => 'Id',
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 120px;'],
            ],
            //Título
            [
                'attribute' => 'titulo',
                'label' => 'Título',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->titulo) ? $model->titulo : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Autor
            [
                'attribute' => 'idautor',
                'label' => 'Autor',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->idautor0->nombre) ? $model->idautor0->nombre : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Número de ejemplares
            [
                'attribute' => 'numejem',
                'label' => 'N° Ejem',
                'format' => 'html',
                'value' => function($model){
                    return $model->numejem->numlibros;
                }
            ],
            //N°s disponibles
            [
                'attribute' => 'numdispos',
                'label' => 'N° Dispo',
                'format' => 'html',
                'value' => function($model){
                    return $model->numejem->numdispos;
                }
            ],
            //categoría
            [
                'attribute' => 'idcategoria',
                'label' => 'Categoría',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->idcategoria0->categoria) ?  $model->idcategoria0->categoria : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '150'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                        'view' => function($url,$model){
                            return Html::a("<span class='glyphicon glyphicon-book'></span>",['ejemplar/create','id'=>$model->idLibros,'name'=>$model->titulo],
                                ['class'=>'btn btn-circle btn-warning btn-sm','title'=>'Ingresar Ejemplar']);
                        },
                        'update' => function($url,$model){
                            return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['libros/update','id'=>$model->idLibros],
                            ['class'=>'btn btn-circle btn-success btn-sm','title'=>'Actualizar Libro']);
                        },
                        'delete' => function($url,$model){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['libros/delete','id' => $model->idLibros],
                                [   'class' => 'btn btn-circle btn-danger btn-sm',
                                    'title' => 'Borrar Libro',
                                    'data-toggle' => 'tooltip',
                                    'data' => [
                                        'confirm' => '¿Estas seguro de borrar este Libro ' . $model->titulo . '?',
                                        'method' => 'post',
                                    ],
                                ]);
                        }
                ],
            ],
        ];

        $gridexportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'target' => ExportMenu::TARGET_BLANK,
            'pjaxContainerId' => 'kv-pjax-container',
            'exportContainer' => [
                'class' => 'btn-group mr-2'
            ],
            'dropdownOptions' => [
                'label' => 'Exportar',
                'class' => 'btn btn-outline-secondary',
                'itemsBefore' => [
                    '<div class="dropdown-header">Exporta todo los datos</div>',
                ],
            ],
            //Elegimos los tipos de exportación admitidos
            'exportConfig' => [
                ExportMenu::FORMAT_TEXT =>false,
                ExportMenu::FORMAT_TEXT => false,
            ],
        ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'export' => false,
        'pjax' => true,
        'emptyText' => 'No hay Libros registrados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'toolbar' => [
            Html::a('Alta Libros', ['create'], ['class' => 'btn btn-success']),
            $gridexportMenu,
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Libros ' .'</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
