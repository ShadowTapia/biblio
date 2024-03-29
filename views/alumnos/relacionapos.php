<?php

use app\models\alumnos\AlumnosSearch;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\alumnos\AlumnosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de Alumnos para Asignar Apoderados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="variable" style="display: none;"><?= $count ?></div>
<?php
$this->registerJs(
    '$("document").ready(function(){                    
                    var x = document.getElementById("toggleSearch");
                    var myParam = document.getElementById("variable").innerHTML;
                    if(myParam>0){
                        if(x.style.display==="none"){
                            x.style.display="block";
                        }
                    }else{
                         x.style.display="none";
                    }
    });
    function init_click_handlers(){
        $(".custom_button").on("click", function(){
            $("#modal").modal("show").find("#modalContent").load($(this).attr("value"));           
        });        
    }
    init_click_handlers();//first run
    $("#alumnos").on("pjax:success", function(){
        init_click_handlers();
    });'
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
<div class="alumnos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Modal::begin([
        'header' => '<h4>Ingreso Apoderado</h4>',
        'id' => 'modal',
        'size' => 'modal-sm',
    ]);
    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <h6>Incluye alumnos retirados</h6>
    <!-- Render consulta form -->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <div id="toggleSearch">
        <?php Pjax::begin([
            'id' => 'alumnos',
            'timeout' => false,
            'enablePushState' => false,
            'clientOptions' => ['method' => 'GET']
        ]); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>
        <?php
        $gridColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '20px'],
                'header' => 'N°',
                'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            //Run alumno
            [
                'attribute' => 'rutalumno',
                'label' => 'Run',
                'headerOptions' => ['width' => '120px'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDecimal($model->rutalumno, 0) . "-" .  $model->digrut;
                }
            ],
            //Nombre alumno
            [
                'attribute' => 'nombrealu',
                'label' => 'Nombre',
                'format' => 'html',
                'value' => function ($model) {
                    return !empty($model->nombrealu) ? $model->nombrealu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            // A. Paterno
            [
                'attribute' => 'paternoalu',
                'label' => 'A. Paterno',
                'format' => 'html',
                'value' => function ($model) {
                    return !empty($model->paternoalu) ? $model->paternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //A. Materno
            [
                'attribute' => 'maternoalu',
                'label' => 'A. Materno',
                'format' => 'html',
                'value' => function ($model) {
                    return !empty($model->maternoalu) ? $model->maternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
                }
            ],
            //Nombre apoderado
            [
                'label' => 'Nombre Apoderado',
                'format' => 'html',
                'value' => function ($data) {
                    return !empty(AlumnosSearch::getNombreTrigger($data->idalumno)) ? AlumnosSearch::getNombreTrigger($data->idalumno) : '<span class="glyphicon glyphicon-question-sign"></span>';
                },
            ],
            //Botones de acción
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['width' => '80'],
                'template' => ' {update} ',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::button(
                            "<span class='glyphicon glyphicon-pencil'></span>",
                            [
                                'value' => Url::to(['apoderados/consultarutapo', 'id' => $model->idalumno, 'run' => $model->rutalumno]),
                                'class' => 'btn btn-circle btn-success btn-sm custom_button',
                                'title' => 'Ingresar Apoderado'
                            ]
                        );
                    },
                ],
            ],
        ];
        ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'export' => false,
            'pjax' => true,
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                    'enableReplaceState' => true,
                ]
            ],
            //'filterModel' => $searchModel,
            'emptyText' => 'No hay resultados para este Curso',
            'showPageSummary' => false,
            'panel' => [
                'type' => 'primary',
                'heading' => '<h3 class="panel-title">Listado Curso ' . ' ' . $nomcurso . ' ' . Yii::$app->session->get('nameAno') . '</h3>',
                'footer' => false
            ]
        ]); ?>

        <?php Pjax::end(); ?>
    </div>


</div>