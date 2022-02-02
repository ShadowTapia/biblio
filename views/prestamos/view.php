<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\models\Roles;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\prestamos\Prestamos */


?>
<div class="prestamos-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'enableEditMode' => false,
        'mode' => DetailView::MODE_VIEW,
        'fadeDelay' => 6,
        'panel' => [
            'type' => DetailView::TYPE_INFO,
            'heading' => '<i class="glyphicon glyphicon-book"></i> '. $model->titulo
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
                        'value' => '<kbd>' .$model->isbn. '</kbd>',
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
                        'format' => ['image',['width' => '120', 'height' => '120']]
                    ],
                    [
                        'attribute' => 'idtemas',
                        'format' => 'raw',
                        'value' => $model->idtemas0->nombre,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                ],
            ],
            [
                'attribute' => 'descripcion',
                'format' => 'raw',
                'value' => '<span class="text-justify"><em>' . $model->descripcion . '</em></span>',
                'type' => DetailView::INPUT_TEXTAREA,
                'options' => ['rows' => 3]
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
                'label' => 'Ubicación'
            ],
            //Acciones
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '430'],
                //Definir a las entidades a las que se les genarara los prestamos
                'template'=> '{alumnos} {apoderado} {Profesor} {Funcionario}',
                'buttons' => [
                    'alumnos' => function ($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-share'> Alumno</span>",['prestarlibro','id' => $model->idejemplar ,'titulo' => $model->idLibros0->titulo],
                            ['class' => 'btn btn-circle btn-warning btn-sm','title' => 'Prestar Alumnos']);
                    },
                    'apoderado' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-share'> Apoderado</span>",['prestarapoderado','id' => $model->idejemplar, 'titulo' => $model->idLibros0->titulo],
                            ['class' => 'btn btn-circle btn-success btn-sm','title' => 'Prestar Apoderado']);
                    },
                    'Profesor' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-share'> Profesor</span>",['prestarprofesor','id' => $model->idejemplar, 'titulo' => $model->idLibros0->titulo],
                            ['class' => 'btn btn-circle btn-info btn-sm','title' => 'Prestar Profesor']);
                    },
                    'Funcionario' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-share'> Funcionario</span>",['prestarfuncionario','id' => $model->idejemplar, 'titulo' => $model->idLibros0->titulo],
                            ['class' => 'btn btn-circle btn-primary btn-sm','title' => 'Prestar Funcionario']);
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
