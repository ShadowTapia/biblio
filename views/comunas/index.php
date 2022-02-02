<?php
/* @var $this yii\web\View */

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title='Administrar Comunas';
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
    <?= Html::button('Crear Comunas',['value' => Url::to('crearcomunas'), 'class'=>'btn btn-success', 'id' => 'modalButton']) ?>
</p>

<?php
Modal::begin([
    'header' => '<h4>Comunas</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";

Modal::end();
?>

<div class="grid-view">
    <?=GridView::widget([
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
                'attribute' => 'codComuna',
                'label' => utf8_encode('Id'),                
            ],
            [
                'attribute' => 'comuna',
                'label' => 'Comuna'
            ],
            [
                'attribute' => 'nombreProvincia',
                'label' => 'Provincia'
            ],
            [
                'attribute' => 'nombreRegion',
                'label' => 'Región'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '80'],
                'template'=> '{delete}',
                'buttons'=> [                    
                    'delete' => function ($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id' => $model->codComuna],
                        [   'class' => 'btn btn-danger btn-circle',
                            'data' => [
                                'confirm' => 'Estas seguro de borrar esta Comuna?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ]
    ]) ?>
</div>