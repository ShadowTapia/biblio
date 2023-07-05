<?php
/* @var $this yii\web\View */

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Administrar Roles';
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
    <?= Html::button('Crear Roles', ['value' => Url::to('crearroles'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
</p>
<?php
Modal::begin([
    'header' => '<h4>Roles</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";

Modal::end();
?>
<?php Pjax::begin([
    'id' => 'pjax-container'
]); ?>
<div class="grid-view">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "",
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        'options' => [
            'data-pjax' => 1
        ],
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
                'label' => 'Descripción'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width' => '80'],
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['delete', 'id' => $model->idroles],
                            [
                                'class' => 'btn btn-danger btn-circle',
                                'data' => [
                                    'confirm' => Html::encode('Estas seguro de borrar este Rol?'),
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ]
    ]) ?>
</div>
<?php Pjax::end(); ?>