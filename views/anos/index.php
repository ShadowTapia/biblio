<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;

$this->title= 'Administrar Años';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a(Yii::t('app', 'Crear Años',['modelClass' => 'anos',]),['crearanos'],['class'=>'btn btn-success']) ?>
</p>

<div class="grid-view">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['style' => 'width: 60%; align:center;'],
        'summary' => "",
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
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
                                    'method' => 'post',
                                ],
                            ]);
                        },
                    ],  
                ],
        ]
    ]) ?>
</div>
