<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = utf8_encode('Administrar Cursos');
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
    <?= Html::a(Yii::t('app', utf8_encode('Crear Cursos'),['modelClass' => 'cursos',]),['crearcursos'],['class'=>'btn btn-success','id'=>'modalButton']) ?>
</p>

<?php Pjax::begin(['id'=>'pjax-container']); ?>
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
                    'attribute' => 'Nombre',
                    'label' => 'Nombre'
                ],
                [
                    'attribute' => 'Orden',
                    'label' => 'Orden'
                ],
                [
                    'attribute' => 'visible',
                    'value' => function($model){
                        return ($model->visible === '1')? 'Si':'No';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Acción',
                    'headerOptions' => ['width'=> '110'],
                    'template'=> '{update}',
                    'buttons' => [
                        'update' => function ($url,$model){
                               return Html::a("<span class='glyphicon glyphicon-pencil'></span>",[
                               'updatecurso','id' => $model->idCurso],['class' => 'btn btn-circle btn-primary','title' => 'Actualizar']);   
                        },      
                    ],  
                ],
        ]
    ]) ?>
</div>
<?php Pjax::end(); ?>