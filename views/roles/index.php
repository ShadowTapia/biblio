<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;

$this->title='Administrar Roles';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a(Yii::t('app','Crear Roles',['modelClass' => 'roles',]),['crearroles'],['class'=>'btn btn-success']) ?>
</p>

<div class="grid-view">
    <?= GridView::widget([
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
                    'attribute' => 'idroles',
                    'label' => 'Id'
                ],
                [
                    'attribute' => 'nombre',
                    'label' => 'Nombre'
                ],
                [
                    'attribute' => 'descripcion',
                    'label' => utf8_encode('Descripci�n') 
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Acciones',
                    'headerOptions' => ['width'=> '80'],
                    'template'=> '{delete}',
                    'buttons' => [
                        'delete' => function ($url,$model){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id' => $model->idroles],
                            [
                                'class' => 'btn btn-danger btn-circle',
                                'data' => [
                                    'confirm' => utf8_encode('Estas seguro de borrar este Rol?'),
                                    'method' => 'post',
                                ],
                            ]);
                        },
                    ],  
                ],
        ]
    ]) ?>
</div>


