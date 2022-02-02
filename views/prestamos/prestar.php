<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 03-04-2021
 * Time: 22:15
 */
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\ejemplar\EjemplarSearch;
use yii\widgets\Pjax;

$this->title = 'Prestar';
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
                    $searchModel = new EjemplarSearch();
                    $searchModel->idLibros = $model->idLibros;
                    $searchModel->disponible = 1;
                    $dataProvider2 = $searchModel->searchEjemplares(Yii::$app->request->queryParams);
                    if($model->numejem->numdispos>0)
                    {
                        return Yii::$app->controller->renderPartial('view', ['model'=> $model, 'dataProvider2' => $dataProvider2]);
                    }else{
                        return null;
                    }

                },
                'expandOneOnly' => true
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
            //Subtítulo
            [
                'attribute' => 'subtitulo',
                'label' => 'Sub Título',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->subtitulo) ? $model->subtitulo : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Autor
            [
                'attribute' => 'idautor',
                'headerOptions' => ['width' => '300'],
                'label' => 'Autor',
                'format' => 'html',
                'value' => function($model){
                    return !empty($model->idautor0->nombre) ? $model->idautor0->nombre : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Número de ejemplares
            [
                'attribute' => 'numejem',
                'headerOptions' => ['width' => '120'],
                'label' => 'N° Ejemplares',
                'format' => 'html',
                'value' => function($model){
                    return $model->numejem->numlibros;
                }
            ],
            //N°s disponibles
            [
                'attribute' => 'numdispos',
                'headerOptions' => ['width' => '120'],
                'label' => 'N° Disponibles',
                'format' => 'html',
                'value' => function($model){
                    return $model->numejem->numdispos;
                }
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
        'toolbar' => [
            Html::a('Prestamos Realizados', ['index'], ['class' => 'btn btn-success']),
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Libros a prestar ' .'</h3>',
            ]
        ]);
    ?>
    <?php Pjax::end(); ?>

</div>
