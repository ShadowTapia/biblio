<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title='Administrar Regiones';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a(Yii::t('app','Crear Regiones', [
        'modelClass' => 'Regiones',]),['crearegiones'], ['class' => 'btn btn-success'])?>
</p>

<div class="grid-view">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "",
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        'columns' => [
            [
                'class'=>'yii\grid\SerialColumn',
                'headerOptions'=>['width'=>'20px'],
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            [
                'attribute' => 'region',
                'label' => 'Nombre Región'
            ],
            [
                'attribute' => 'orden',
                'label' => 'Orden',
                'headerOptions'=>['width'=>'80'],
            ],            
            [
                'class'=>'yii\grid\ActionColumn',
                'header'=>'Acciones',
                'headerOptions'=>['width'=>'110'],
                'template'=>'{update} {delete}',
                'buttons'=> [
                        //posibles variables que se pueden usar $key
                    'update' => function ($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>",[
                            'updateregion','id' => $model->codRegion],['class' => 'btn btn-circle btn-primary']);                        
                    },
                    'delete' => function ($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['remove','id' => $model->codRegion],
                        [   'class' => 'btn btn-circle btn-danger',
                            'data' => [
                                'confirm' => 'Estas seguro de borrar esta región?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
