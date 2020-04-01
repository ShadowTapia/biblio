<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProvinciasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Provincias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provincias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Provincia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "",
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions'=>['width'=>'20px'],
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            [
                'attribute' => 'idProvincia',
                'label' => 'Id Provincia',
                'visible' => false
            ],
            [
                'attribute' => 'Provincia',
                'label' => 'Provincia',
            ],           
            [
                'attribute' => 'regionNombre',
                'label' => utf8_encode('Regi�n'), 
            ],            
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '110'],
                'template'=>'{update} {delete}',
                'buttons'=> [
                    'update' => function ($url,$model,$key){
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>",[
                            'update','id' => $model->idProvincia],['class' => 'btn btn-circle btn-primary']);                        
                    },
                    'delete' => function ($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id' => $model->idProvincia],
                        [   'class' => 'btn btn-circle btn-danger',
                            'data' => [
                                'confirm' => utf8_encode('Estas seguro de borrar esta Provincia?'),
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
