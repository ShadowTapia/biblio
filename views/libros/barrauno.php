<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\ejemplar\EjemplarSearch;

$this->title = 'Codigo de barras por Libro';
$this->params['breadcrumbs'][] = $this->title;

?>

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
        //Id
        [
            'attribute' => 'idLibros',
            'visible' => false,
            'label' => 'Id',
            'format' => 'html',
            'contentOptions' => ['style' => 'width: 120px;'],
        ],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                $searchModel = new EjemplarSearch();
                $searchModel->idLibros = $model->idLibros;
                $dataProvider2 = $searchModel->searchEjemplares(Yii::$app->request->queryParams);

                return Yii::$app->controller->renderPartial('barraview', ['model' => $model, 'dataProvider2' => $dataProvider2]);
            },
            'expandOneOnly' => true
        ],
        //Título
        [
            'attribute' => 'titulo',
            'label' => 'Título',
            'format' => 'html',
            'value' => function ($model) {
                return !empty($model->titulo) ? $model->titulo : '<span class="glyphicon glyphicon-question-sign"></span>';
            }
        ],
        //Autor
        [
            'attribute' => 'idautor',
            'label' => 'Autor',
            'format' => 'html',
            'value' => function ($model) {
                return !empty($model->idautor0->nombre) ? $model->idautor0->nombre : '<span class="glyphicon glyphicon-question-sign"></span>';
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
            Html::a('Imprimir todos los códigos de barra', ['allbarras'], ['class' => 'btn btn-success']),
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Imprimir códigos de barra por ejemplar ' . '</h3>',
        ]
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>