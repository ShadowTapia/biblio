<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 11-09-2021
 * Time: 22:27
 */
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;


$this->title = 'Busqueda en Catálogo completo de  Libros';
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
<div class="libros-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    $gridColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '20px'],
            'header' => 'N°',
            'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
        ],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function($model, $key, $index, $column){
                return Yii::$app->controller->renderPartial('view', ['model'=> $model]);
            },
            'expandOneOnly' => true
        ],
        //Id
        [
            'attribute' => 'idLibros',
            'label' => 'Id',
            'format' => 'html',
            'contentOptions' => ['style' => 'width: 120px;'],
            'visible' => false,
        ],
        //Título
        [
            'attribute' => 'titulo',
            'label' => 'Título',
            'format' => 'html',
            'value' => function($model){
                return !empty($model->titulo) ? $model->titulo : '<span class="glyphicon glyphicon-question-sign"></span>';
            }
        ],
        //Autor
        [
            'attribute' => 'idautor',
            'label' => 'Autor',
            'format' => 'html',
            'value' => function($model){
                return !empty($model->idautor0->nombre) ? $model->idautor0->nombre : '<span class="glyphicon glyphicon-question-sign"></span>';
            }
        ],
        //Número de ejemplares
        [
            'attribute' => 'numejem',
            'label' => 'N° Ejem',
            'format' => 'html',
            'value' => function($model){
                return $model->numejem->numlibros;
            }
        ],
        //N°s disponibles
        [
            'attribute' => 'numdispos',
            'label' => 'N° Dispo',
            'format' => 'html',
            'value' => function($model){
                return $model->numejem->numdispos;
            }
        ],
        //categoría
        [
            'attribute' => 'idcategoria',
            'label' => 'Categoría',
            'format' => 'html',
            'value' => function($model){
                return !empty($model->idcategoria0->categoria) ?  $model->idcategoria0->categoria : '<span class="glyphicon glyphicon-question-sign"></span>';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'headerOptions' => ['width'=> '90'],
            'template' => '{delete}',
            'buttons' => [
                'delete' => function($url,$model){
                    return Html::a('<span class="glyphicon glyphicon-floppy-saved"></span>',['reserva/reservar','id' => $model->idLibros],
                        [   'class' => 'btn btn-circle btn-danger btn-sm',
                            'title' => 'Reservar este Libro',
                            'data-toggle' => 'tooltip',
                            'data' => [
                                'confirm' => '¿Estas seguro de reservar este Título ' . $model->titulo . '?',
                                'method' => 'post',
                            ],
                        ]);
                }
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
        'emptyText' => 'No hay Libros registrados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Catálogo de Libros ' .'</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
