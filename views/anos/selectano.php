<?php
/* @var $this yii\web\View */
/**
 * @author Marcelo
 * @copyright 2020
 */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title='Seleccionar Año';
$this->params['breadcrumbs'][] = ['label' => 'Administrar Años', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \lavrentiev\widgets\toastr\NotificationFlash::widget([
    'options' => [
        "closeButton" => true,
        "debug" => false,
        "newestOnTop" => false,
        "progressBar" => false,
        "positionClass" => \lavrentiev\widgets\toastr\NotificationFlash::POSITION_TOP_RIGHT,
        "preventDuplicates" => false,
        "onclick" => null,
        "showDuration" => "300",
        "hideDuration" => "1000",
        "timeOut" => "5000",
        "extendedTimeOut" => "1000",
        "showEasing" => "swing",
        "hideEasing" => "linear",
        "showMethod" => "fadeIn",
        "hideMethod" => "fadeOut"
    ]
]) ?>
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
                        'update' => function ($url,$model){
                            return Html::a("<span class='glyphicon glyphicon-ok'></span>",[
                                'seleccionaano','id' => $model->idano],['class' => 'btn btn-circle btn-primary','title'=>'Seleccionar']);
                            },                        
                    ],
                ]
        ],
    ]) ?>
</div>
