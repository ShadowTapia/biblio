<?php

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProvinciasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Provincias';
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
<div class="provincias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Crear Provincia',['value' => Url::to('create'), 'class'=>'btn btn-success', 'id' => 'modalButton']) ?>
    </p>

    <?php
        Modal::begin([
            'header' => '<h4>Provincias</h4>',
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>
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
                'label' => 'Región',
            ],            
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '110'],
                'template'=>'{update} {delete}',
                'buttons'=> [
                    'update' => function ($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>",[
                            'update','id' => $model->idProvincia],['class' => 'btn btn-circle btn-primary']);                        
                    },
                    'delete' => function ($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id' => $model->idProvincia],
                        [   'class' => 'btn btn-circle btn-danger',
                            'data' => [
                                'confirm' => 'Estas seguro de borrar esta Provincia?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
