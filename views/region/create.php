<?php
/* @var $this yii\web\View */

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Administrar Regiones';
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

<p>
    <?= Html::button('Crear Regiones', ['value' => Url::to('crearegiones'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
</p>

<?php
Modal::begin([
    'header' => '<h4>Regiones</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<?php Pjax::begin(['id' => 'pjax-container']); ?>

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
                'attribute' => 'region',
                'label' => 'Nombre Región'
            ],
            [
                'attribute' => 'orden',
                'label' => 'Orden',
                'headerOptions' => ['width' => '80'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width' => '110'],
                'template' => '{update} {delete}',
                'buttons' => [
                    //posibles variables que se pueden usar $key
                    'update' => function ($url, $model) {
                        return Html::button(
                            "<span class='glyphicon glyphicon-pencil'></span>",
                            [
                                'value' => Url::to(['updateregion', 'idregion' => $model->codRegion]), 'class' => 'btn btn-circle btn-primary custom_button', 'title' => 'Actualizar'
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['remove', 'id' => $model->codRegion],
                            [
                                'class' => 'btn btn-circle btn-danger',
                                'data' => [
                                    'confirm' => 'Estas seguro de borrar esta región?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
<?php Pjax::end(); ?>