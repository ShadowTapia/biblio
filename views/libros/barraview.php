<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\detail\DetailView;

?>

<div class="libros-view">
    <?= DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'enableEditMode' => false,
        'mode' => DetailView::MODE_VIEW,
        'fadeDelay' => 6,
        'panel' => [
            'type' => DetailView::TYPE_INFO,
            'heading' => '<i class="glyphicon glyphicon-book"></i> ' . $model->titulo
        ],
        'attributes' => [
            [
                'group' => true,
                'label' => 'Sección 1: Identificación',
                'rowOptions' => ['class' => 'table-info']
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'idLibros',
                        'label' => 'Libro #',
                        'displayOnly' => true,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'isbn',
                        'format' => 'raw',
                        'value' => '<kbd>' . $model->isbn . '</kbd>',
                        'displayOnly' => true,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'subtitulo',
                        'label' => 'Subtitulo',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'idautor',
                        'label' => 'Autor',
                        'format' => 'raw',
                        'value' => $model->idautor0->nombre,
                        'valueColOptions' => ['style' => 'width:30%'],
                    ],
                ],
            ],
            [
                'group' => true,
                'label' => 'Sección 1: Detalles',
                'rowOptions' => ['class' => 'table-info']
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'ano',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'idioma',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'formato',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'numpag',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'idcategoria',
                        'format' => 'raw',
                        'value' => $model->idcategoria0->categoria,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'ideditorial',
                        'format' => 'raw',
                        'value' => $model->ideditorial0->nombre,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'imagen',
                        'label' => 'Imagen referencial',
                        'value' => Yii::getAlias('@libroImgUrl') . '/' . $model->imagen,
                        'format' => ['image', ['width' => '120', 'height' => '120']]
                    ],
                    [
                        'attribute' => 'idtemas',
                        'format' => 'raw',
                        'value' => $model->idtemas0->nombre,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                ],
            ],
        ],
    ]) ?>

    <?php
    $gridColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '20px'],
            'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
        ],
        //N° orden
        [
            'attribute' => 'norden',
            'label' => 'N° Orden',
        ],
        //Edición
        [
            'attribute' => 'edicion',
            'label' => 'Edición',
        ],
        //ubicación
        [
            'attribute' => 'ubicacion',
            'label' => 'Ubicación',
        ],
        //Accion
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'headerOptions' => ['width' => '200'],
            //Definir a las entidades a las que se les genarara los prestamos
            'template' => '{barra}',
            'buttons' => [
                'barra' => function ($url, $model) {
                    return Html::a(
                        "<span class='glyphicon glyphicon-barcode'> Cod. Barra</span>",
                        ['generarbarra', 'id' => $model->idejemplar, 'codigo' => $model->norden, 'titulo' => $model->idLibros0->titulo],
                        ['class' => 'btn btn-circle btn-warning btn-sm', 'title' => 'Generar Código de barra']
                    );
                }
            ],
        ]
    ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'columns' => $gridColumns,
        'export' => false,
        'emptyText' => 'No hay Ejemplares',
        'showPageSummary' => false,
        'panel' => [
            'type' => 'success',
            'heading' => '<h3 class="panel-title">Ejemplares ' . '</h3>',
        ]
    ]) ?>
</div>