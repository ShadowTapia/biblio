<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\editorial\EditorialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Editorial';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="editorial-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
        $gridColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'header' => 'N°',
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            //Nombre
            [
                    'attribute' => 'nombre',
                    'label' => 'Nombre',
                    'format' => 'html',
                    'value' => function($model){
                        return !empty($model->nombre) ? $model->nombre : '<span class="glyphicon glyphicon-question-sign"></span>';
                    }
            ],
            //Telefono
            [
                'attribute' => 'telefono',
                'label' => 'Telefóno',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->telefono) ? $model->telefono : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //mail
            [
                'attribute' => 'mail',
                'label' => 'E-mail',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->mail) ? $model->mail : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Acciones
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width' => '150'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-info-sign'></span>",['editorial/view','id' => $model->ideditorial],
                            [   'class' => 'btn btn-circle btn-primary btn-sm',
                                'title' => 'Ver Editorial'
                            ]);
                    },
                    'update' => function($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['editorial/update','id'=>$model->ideditorial],
                            ['class'=>'btn btn-circle btn-success btn-sm','title'=>'Actualizar Editorial']);
                    },
                    'delete' => function($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['editorial/delete','id' => $model->ideditorial],
                            [   'class' => 'btn btn-circle btn-danger btn-sm',
                                'title' => 'Borrar Editorial',
                                'data-toggle' => 'tooltip',
                                'data' => [
                                    'confirm' => '¿Estas seguro de borrar esta Editorial ' . $model->nombre . '?',
                                    'method' => 'post',
                                ],
                            ]);
                    }
                ],
            ],
        ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'export' => false,
        'pjax' => true,
        'emptyText' => 'No hay editoriales registradas.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'toolbar' => [
                'content' => Html::a('Crear Editorial', ['create'], ['class' => 'btn btn-success']),
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Editoriales ' .'</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
