<?php

use yii\helpers\Html;
use kartik\detail\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\libros\Libros */


?>
<div class="libros-view">

    <!--<p>
        <?/*= Html::a('Update', ['update', 'id' => $model->idLibros], ['class' => 'btn btn-primary']) */?>
        <?/*= Html::a('Delete', ['delete', 'id' => $model->idLibros], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>-->

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

</div>
