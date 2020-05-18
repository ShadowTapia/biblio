<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title='Administrar Usuarios';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
        <?= Html::a('Nuevo Usuario', ['register'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'UserName',
                'label' => 'Nombre',
                'value' => function($model){
                    return !empty($model->UserName) ? $model->UserName : '-';
                }
            ],
            [
                'attribute' => 'UserLastName',
                'label' => 'Apellido',
                'value' => function($model){
                    return !empty($model->UserLastName) ? $model->UserLastName : '-';
                }
            ],
            [
                'attribute' => 'UserMail',
                'label' => 'E-mail',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->UserMail) ? $model->UserMail : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                'attribute' => 'nombreRol',
                'label' => 'Rol'
            ],
            [
                'label' => 'Estado',
                'value' => function($model){
                    return ($model->activate === '1')? 'Activo':'Inactivo';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '150'],
                'template'=> '{view} {update} {delete}',
                'buttons' => [
                    'view' => function($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-refresh"></span>',['uppass','id' => $model->idUser],
                        [   'class' => 'btn btn-circle btn-success',
                            'title' => 'Resetear contraseña',
                            'data' => [
                                'confirm' => utf8_encode('Desea resetear la contrase�a de ' . $model->UserName . ' ' . $model->UserLastName . '?'),
                                'method' => 'post',
                            ],
                        ]);  
                    },
                    'update' => function ($url,$model){
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>",[
                            'updateuser','id' => $model->idUser],['class' => 'btn btn-circle btn-primary','title' => 'Actualizar']);                        
                    },
                    'delete' => function ($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id' => $model->idUser],
                        [   'class' => 'btn btn-circle btn-danger',
                            'title' => 'Borrar Usuario',
                            'data-toggle' => 'tooltip',                            
                            'data' => [
                                'confirm' => 'Estas seguro de borrar al Usuario ' . utf8_encode($model->UserName) . ' ' . utf8_encode($model->UserLastName) . '?',
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