<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\prestamos\PrestamosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prestamos realizados';
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
<div class="prestamos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?php
    $gridColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '20px'],
            'header' => 'N°',
            'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
        ],
        //Usuario
        [
            'attribute' => 'idUser',
            'label' => 'Usuario',
            'format' => 'html',
            'value' => function ($model) {
                return $model->idUser0->UserName . ' ' . $model->idUser0->UserLastName;
            }
        ],
        //Titulo del libro
        [
            'attribute' => 'idejemplar0',
            'label' => 'Libro',
            'format' => 'html',
            'value' => function ($model) {
                return $model->idejemplar0->idLibros0->titulo;
            }
        ],
        //Rol
        [
            'label' => 'Rol',
            'format' => 'html',
            'value' => function ($model) {
                return $model->idUser0->idroles->nombre;
            }
        ],
        //N° orden
        [
            'attribute' => 'norden',
            'label' => 'N° Orden',
            'format' => 'html',
            'headerOptions' => ['width' => '100px'],
            'value' => function ($model) {
                return $model->norden;
            }
        ],
        //Fecha Prestamo
        [
            'attribute' => 'fechapres',
            'label' => 'F. Prestamo',
            'format' => 'html',
            'headerOptions' => ['width' => '120px'],
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->fechapres, 'dd-MM-yyyy');
            }
        ],
        //Fecha devolución
        [
            'attribute' => 'fechadev',
            'label' => 'F. Devolución',
            'format' => 'html',
            'headerOptions' => ['width' => '120px'],
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->fechadev, 'dd-MM-yyyy');
            }
        ],
        //Acciones
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'headerOptions' => ['width' => '120'],
            'template' => '{devolver}', // {extender},
            'buttons' => [
                'devolver' => function ($url, $model) {
                    return Html::a(
                        "<span class='glyphicon glyphicon-download'> Devolver</span>",
                        ['devolver', 'id' => $model->idPrestamo],
                        [
                            'class' => 'btn btn-circle btn-danger btn-sm',
                            'title' => 'Devolver Prestamo',
                            'data' => [
                                'confirm' => '¿Estas seguro de devolver este prestamo?',
                                'method' => 'post',
                            ],
                        ]
                    );
                },
                // Opción no resuelta para actualización de prestamos 
                // 'extender' => function ($url, $model) {
                //     return Html::a(
                //         "<span class='glyphicon glyphicon-refresh'> Renovar</span>",
                //         ['update', 'id' => $model->idPrestamo],
                //         ['class' => 'btn btn-circle btn-warning btn-sm', 'title' => 'Extender Prestamo']
                //     );
                // }
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
        'emptyText' => 'No hay Prestamos registrados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'toolbar' => [
            Html::a('Prestar', ['prestar'], ['class' => 'btn btn-success']),

        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Prestamos realizados ' . '</h3>',
        ]
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>