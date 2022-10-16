<?php
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Consulta de Reservas realizadas';
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
<div class="reserva-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        $gridColumns = [
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
            //Usuario
            [
                'attribute' => 'idUser',
                'label' => 'Usuario',
                'value' => function($model){
                    return $model->idUser0->UserName . ' ' . $model->idUser0->UserLastName;
                }
            ],
            //Roles
            [
                'attribute' => 'idroles',
                'label' => 'Rol',
                'value' => function($model){
                    return $model->idUser0->idroles->nombre;
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
            //Acciones
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width'=> '100'],
                'template' => '{delete}',
                'buttons' => [
                        'delete' => function($url,$model){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['reserva/delete','id' => $model->idreserva],
                                [   'class' => 'btn btn-circle btn-danger btn-sm',
                                    'title' => 'Borrar Reserva',
                                    'data-toggle' => 'tooltip',
                                    'data' => [
                                        'confirm' => '¿Estas seguro de borrar la Reserva de ' . $model->idUser0->UserName . ' ' . $model->idUser0->UserLastName . ' del Titulo ' . $model->idLibros0->titulo . '?',
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
            'layout' => '{pager}',
            'toolbar' => [
                Html::a('Prestar', ['/prestamos/prestar'], ['class' => 'btn btn-success']),

            ],
            'panel' => [
                'type' => 'primary',
                'heading' => '<h3 class="panel-title">Listado de Reservas realizadas ' .'</h3>',
            ]
        ]);
    ?>
</div>


