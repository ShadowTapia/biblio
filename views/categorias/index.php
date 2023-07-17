<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\categorias\CategoriasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categorías';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$this->registerJs(
    '
    function init_click_handlers(){
        $(".mdl_button").on("click", function(){
            $("#modal").modal("show").find("#modalContent").load($(this).attr("value"));
        });

        $(".custom_button").on("click", function(){
            $("#modal").modal("show").find("#modalContent").load($(this).attr("value"));           
        });        
    }
    init_click_handlers();//first run
    $("#pjax-container").on("pjax:success", function(){
        init_click_handlers();
    });    
'
);
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
<div class="categorias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Modal::begin([
        'header' => '<h4>Categorías</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <?php Pjax::begin(['id' => 'pjax-container']); ?>
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
        //Id de la categoría
        [
            'attribute' => 'idcategoria',
            'label' => 'Id',
            'format' => 'html',
            'value' => function ($model) {
                return !empty($model->idcategoria) ? $model->idcategoria : '<span class="glyphicon glyphicon-question-sign"></span>';
            }
        ],
        //Nombre de la categoría
        [
            'attribute' => 'categoria',
            'label' => 'Categoría',
            'format' => 'html',
            'value' => function ($model) {
                return !empty($model->categoria) ? $model->categoria : '<span class="glyphicon glyphicon-question-sign"></span>';
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
                    return Html::button(
                        "<span class='glyphicon glyphicon-info-sign'></span>",
                        [
                            'value' => Url::to(['categorias/view', 'id' => $model->idcategoria]), 'class' => 'btn btn-circle btn-primary btn-sm custom_button',
                            'title' => 'Ver Categorías',
                        ]
                    );
                },
                'update' => function ($url, $model) {
                    return Html::button(
                        "<span class='glyphicon glyphicon-pencil'></span>",
                        [
                            'value' => Url::to(['categorias/update', 'id' => $model->idcategoria]), 'class' => 'btn btn-circle btn-success btn-sm custom_button',
                            'title' => 'Actualizar Categorías'
                        ]
                    );
                },
                'delete' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        ['categorias/delete', 'id' => $model->idcategoria],
                        [
                            'class' => 'btn btn-circle btn-danger btn-sm',
                            'title' => 'Borrar Categoría',
                            'data-toggle' => 'tooltip',
                            'data' => [
                                'confirm' => '¿Estas seguro de borrar esta Categoría ' . $model->categoria . '?',
                                'method' => 'post',
                            ],
                        ]
                    );
                }
            ],
        ]
    ];
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'export' => false,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
                'enableReplaceState' => true,
            ]
        ],
        'emptyText' => 'No hay categorías registradas.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'toolbar' => [
            Html::button('Crear Categorías', ['value' => Url::to('create'), 'class' => 'btn btn-success mdl_button']),
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Categorías ' . '</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>