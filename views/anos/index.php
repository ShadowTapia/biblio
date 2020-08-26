<?php
/* @var $this yii\web\View */

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title= 'Administrar Años';
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= Html::encode($this->title) ?></h1>


<?php
    $gridColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'header'=>'',
            'headerOptions' => ['width' => '20px'],
            'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
        ],
        [
            'attribute' => 'idano',
            'label' => 'Id'
        ],
        [
            'attribute' => 'nombreano',
            'label' => 'Nombre'
        ],
        [
            'attribute' => 'activo',
            'value' => function($model){
                return ($model->activo === '1')? 'Si':'No';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'headerOptions' => ['width'=> '110'],
            'template'=> '{update} {delete}',
            'buttons' => [
                'update' => function ($url,$model){
                    return Html::a("<span class='glyphicon glyphicon-pencil'></span>",[
                        'updateanos','id' => $model->idano],['class' => 'btn btn-circle btn-primary','title' => 'Actualizar']);
                },
                'delete' => function ($url,$model){
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id' => $model->idano],
                        [
                            'class' => ['btn btn-danger btn-circle','title' => 'Borrar'],
                            'data' => [
                                'confirm' => 'Estas seguro de borrar este Año?',
                                'title'=>'Confirmación',
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
    'columns'=> $gridColumns,
    'export'=>false,
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'emptyText' => 'No hay resultados aún para esta tabla',
    'responsive' => true,
    'hover' => true,
    'showPageSummary' => false,
    'toolbar'=>[
            [
                'content' =>
                    Html::a(Yii::t('app', 'Crear Años',['modelClass' => 'anos',]),['crearanos'],['class'=>'btn btn-success']),
            ],
    ],
    'panel'=> [
            'type'=>'primary',
            'footer'=> false,
    ]
]); ?>

