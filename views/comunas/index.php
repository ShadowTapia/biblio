<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title='Administrar Comunas';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a(Yii::t('app','Crear Comunas', ['modelClass' => 'Comunas',]),['crearcomunas'],['class'=>'btn btn-success']) ?>
</p>

<div class="grid-view">
    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "",
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            [
                'attribute' => 'codComuna',
                'label' => utf8_encode('Id'),                
            ],
            [
                'attribute' => 'comuna',
                'label' => 'Comuna'
            ],
            [
                'attribute' => 'nombreProvincia',
                'label' => 'Provincia'
            ],
            [
                'attribute' => 'nombreRegion',
                'label' => 'Región'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '80'],
                'template'=> '{delete}',
                'buttons'=> [                    
                    'delete' => function ($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id' => $model->codComuna],
                        [   'class' => 'btn btn-danger btn-circle',
                            'data' => [
                                'confirm' => 'Estas seguro de borrar esta Comuna?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ]
    ]) ?>
</div>