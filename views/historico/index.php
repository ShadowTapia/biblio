<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;

$this->title = 'Registro Historico ' . Yii::$app->session->get('nameAno');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historico-index">
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
        //Usuario
        [
            'attribute' => 'idUser',
            'label' => 'Usuario',
            'format' => 'html',
            'value' => function ($model) {
                return $model->idUser0->UserName . ' ' . $model->idUser0->UserLastName;
            }
        ],
        //Rol Usuario
        [
            'attribute' => 'idUser',
            'label' => 'Rol',
            'format' => 'html',
            'value' => function ($model) {
                return $model->idUser0->idroles->nombre;
            }
        ],
        //Titulo de Libro
        [
            'attribute' => 'idejemplar0',
            'label' => 'Libro',
            'format' => 'html',
            'value' => function ($model) {
                return $model->idejemplar0->idLibros0->titulo;
            }
        ],
        //Fecha prestamo
        [
            'attribute' => 'fechapres',
            'label' => 'F. Prestamo',
            'format' => 'html',
            'headerOptions' => ['width' => '120px'],
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->fechapres, 'dd-MM-yyyy');
            }
        ],
        //Fecha de devolución
        [
            'attribute' => 'fechadev',
            'label' => 'F. Estipulada',
            'format' => 'html',
            'headerOptions' => ['width' => '120px'],
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->fechadev, 'dd-MM-yyyy');
            }
        ],
        //Fecha devolución real
        [
            'attribute' => 'fechadevReal',
            'label' => 'F. Devolución',
            'format' => 'html',
            'headerOptions' => ['width' => '120px'],
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->fechadevReal, 'dd-MM-yyyy');
            }
        ],
    ];

    $gridexportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'target' => ExportMenu::TARGET_BLANK,
        'pjaxContainerId' => 'kv-pjax-container',
        'exportContainer' => [
            'class' => 'btn-group mr-2'
        ],
        'dropdownOptions' => [
            'label' => 'Exportar',
            'class' => 'btn btn-outline-secondary',
            'itemsBefore' => [
                '<div class="dropdown-header">Exporta todo los datos</div>',
            ],
        ],
        //Elegimos los tipos de exportación admitidos
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_TEXT => false,
        ],
    ]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'export' => false,
        'pjax' => true,
        'emptyText' => 'No hay datos historicos registrados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'toolbar' => [
            $gridexportMenu,
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Registros Historicos ' . '</h3>',
        ]
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>