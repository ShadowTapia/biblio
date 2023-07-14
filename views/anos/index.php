<?php
/* @var $this yii\web\View */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Administrar Años';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$this->registerJs(
    "$('.custom_button').on('click', function(){
        $('#modal').modal('show').find('#modalContent').load($(this).attr('value'));           
    });",
    View::POS_READY,
    'my-button-handler'
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

<h1><?= Html::encode($this->title) ?></h1>

<?php
Modal::begin([
    'header' => '<h4>Años</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";

Modal::end();
?>

<?php
$gridColumns = [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => '',
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
        'attribute' => 'activo',
        'value' => function ($model) {
            return ($model->activo === '1') ? 'Si' : 'No';
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Acciones',
        'headerOptions' => ['width' => '110'],
        'template' => '{update} {delete}',
        'buttons' => [
            'update' => function ($url, $model) {
                return Html::button(
                    "<span class='glyphicon glyphicon-pencil'></span>",
                    [
                        'value' => Url::to(['updateanos', 'id' => $model->idano]), 'class' => 'btn btn-circle btn-primary custom_button', 'title' => 'Actualizar'
                    ]
                );
            },
            'delete' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-trash"></span>',
                    ['delete', 'id' => $model->idano],
                    [
                        'class' => ['btn btn-danger btn-circle', 'title' => 'Borrar'],
                        'data' => [
                            'confirm' => 'Estas seguro de borrar este Año?',
                            'title' => 'Confirmación',
                            'method' => 'post',
                        ],
                    ]
                );
            },
        ],
    ],
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'export' => false,
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'emptyText' => 'No hay resultados aún para esta tabla',
    'responsive' => true,
    'hover' => true,
    'showPageSummary' => false,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => [
            'enablePushState' => false,
            'enableReplaceState' => true,
        ]
    ],
    'toolbar' => [
        [
            'content' =>
            Html::button('Crear Años', ['value' => Url::to('crearanos'), 'class' => 'btn btn-success', 'id' => 'modalButton']),
        ],
    ],
    'panel' => [
        'type' => 'primary',
        'footer' => false,
    ]
]); ?>