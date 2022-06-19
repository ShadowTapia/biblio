<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title='Administrar Docentes';
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
<h1><?= Html::encode($this->title) ?></h1>

<p>
        <?= Html::a('<span class="glyphicon glyphicon-user"></span> Nuevo Docente', ['register'], ['class' => 'btn btn-success','data-toggle'=>'tooltip','title'=>'Ingresa un nuevo docente']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Imprimir', ['reporte'],['class' => 'btn btn-warning','target'=>'_blank','data-toggle'=>'tooltip', 'title'=>'Generara un reporte en formato pdf']) ?>        
</p>
<div class="grid-view">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyCell' => '-', 
        'summary' => "",
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            [
                'attribute' => 'rutdocente',
                'label' => 'Run',
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->rutdocente,0) . "-" . $model->digito;
                }
            ],
            [
                'attribute' => 'nombres',
                'label' => 'Nombre',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->nombres) ? strtoupper($model->nombres)  : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                'attribute' => 'paterno',
                'label' => 'Paterno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->paterno) ? strtoupper($model->paterno)  : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                'attribute' => 'materno',
                'label' => 'Materno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->materno) ? strtoupper($model->materno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                'attribute' => 'email',
                'label' => 'E-Mail',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->email) ? $model->email : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '120'],
                'template'=> '{update} {delete}',
                'buttons' => [
                    'update' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>",[
                            'updateprofe','id' => $model->rutdocente],['class' => 'btn btn-circle btn-primary','title'=>'Actualizar docente','data-toggle'=>'tooltip']);  
                    },
                    'delete' => function ($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id' => $model->rutdocente],
                        [   'class' => 'btn btn-circle btn-danger',
                            'title' => 'Borrar Docente',
                            'data-toggle' => 'tooltip',                            
                            'data' => [
                                'confirm' => utf8_encode('Estas seguro de borrar al Docente ' . $model->nombres . ' ' . $model->paterno . ' ' . $model->materno . '?'),
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ]
        
    ])
        
     ?>
</div>