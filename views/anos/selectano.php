<?php
/* @var $this yii\web\View */
/**
 * @author Marcelo
 * @copyright 2020
 */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title=utf8_encode('Seleccionar A�o');
$this->params['breadcrumbs'][] = ['label' => utf8_encode('Administrar A�os'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>

<div class="grid-view">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['style' => 'width: 60%; align: center;'],
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
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Accion',
                    'headerOptions' => ['width'=> '80'],
                    'template'=> '{update}',
                    'buttons' => [
                        'update' => function ($url,$model,$key){
                            return Html::a("<span class='glyphicon glyphicon-ok'></span>",[
                                'seleccionaano','id' => $model->idano],['class' => 'btn btn-circle btn-primary','title'=>'Seleccionar']);
                            },                        
                    ],
                ]
        ],
    ]) ?>
</div>
