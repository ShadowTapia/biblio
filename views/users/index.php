<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUsers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Administrar Usuarios';
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
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Nuevo Usuario', ['register'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if ($model->activate == '1') {
                return ['class' => 'info'];
            } else {
                return ['class' => 'danger'];
            }
        },
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            [
                'attribute' => 'UserName',
                'label' => 'Nombre',
                'value' => function ($model) {
                    return !empty($model->UserName) ? $model->UserName : '-';
                }
            ],
            [
                'attribute' => 'UserLastName',
                'label' => 'Apellido',
                'value' => function ($model) {
                    return !empty($model->UserLastName) ? $model->UserLastName : '-';
                }
            ],
            [
                'attribute' => 'UserMail',
                'label' => 'E-mail',
                'format' => 'html',
                'value' => function ($model) {
                    return !empty($model->UserMail) ? $model->UserMail : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            [
                'attribute' => 'nombreRol',
                'label' => 'Rol'
            ],
            [
                'label' => 'Estado',
                'value' => function ($model) {
                    return ($model->activate === '1') ? 'Activo' : 'Inactivo';
                }
            ],
            //Acciones
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width' => '150'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-refresh"></span>',
                            ['uppass', 'id' => $model->idUser, 'fuente' => 1],
                            [
                                'class' => 'btn btn-circle btn-success',
                                'title' => 'Resetear contraseña',
                                'data' => [
                                    'confirm' => 'Desea resetear la contraseña de ' . $model->UserName . ' ' . $model->UserLastName . '?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-pencil'></span>", [
                            'updateuser', 'id' => $model->idUser, 'fuente' => 1
                        ], ['class' => 'btn btn-circle btn-primary', 'title' => 'Actualizar']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['delete', 'id' => $model->idUser],
                            [
                                'class' => 'btn btn-circle btn-danger',
                                'title' => 'Borrar Usuario',
                                'data-toggle' => 'tooltip',
                                'data' => [
                                    'confirm' => 'Estas seguro de borrar al Usuario ' . $model->UserName . ' ' . $model->UserLastName . '?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>