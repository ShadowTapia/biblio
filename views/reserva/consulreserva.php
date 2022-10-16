<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 02-02-2022
 * Time: 20:04
 */
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Consulta de Reservas realizadas';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="reserva-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        $gridColumns =[
                //Número
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['width' => '20px'],
                    'header' => 'N°',
                    'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
                ],
                //Título
                [
                    'attribute' => 'idLibros',
                    'label' => 'Título',
                    'format' => 'html',
                    'value' => function($model){
                        return $model->idLibros0->titulo;
                    }
                ],
                //Fecha Reserva
                [
                    'attribute' => 'fechaR',
                    'label' => 'F. Reserva',
                    'format' => 'html',
                    'headerOptions' => ['width' => '120px'],
                    'value' => function($model){
                        return Yii::$app->formatter->asDate($model->fechaR,'dd-MM-yyyy');
                    }
                ],
                //Estado reserva
                [
                    'attribute' => 'estado',
                    'label' => 'Estado',
                    'format' => 'html',
                    'headerOptions' => ['width' => '120px'],
                    'value' => function($model){
                        return $model->estado ? 'Validado' : 'No Validado';
                    }
                ],
        ];
    ?>
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'export' => false,
            'emptyText' => 'No hay Reservas registradas.-',
            'rowOptions' => function($model){
                if($model->estado == '1'){
                    return ['class' => 'info'];
                }
                else{
                    return ['class' => 'danger'];
                }
            },
            'showPageSummary' => false,
            'panel' => [
                'type' => 'primary',
                'heading' => '<h3 class="panel-title">Listado de Reservas realizadas ' .'</h3>',
        ]
    ]);

    ?>
</div>

