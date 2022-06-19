<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 12-10-2020
 * Time: 14:34
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Actualización de Alumnos '. Yii::$app->session->get('nameAno');
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
<div class="alumnos-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <h6>*Incluye alumnos retirados</h6>
    <?php Pjax::begin(); ?>
    <?php
    $gridColumns = [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '20px'],
            'header' => 'N°',
            'contentOptions' => ['style' => 'width: 20px;', 'class' => 'text-center'],
        ],
        //Rut alumno
        [
            'attribute' => 'rutalumno',
            'label' => 'RUN',
            'format' => 'html',
            'headerOptions' => ['width' => '120px'],
            'value' => function($model) {
                return Yii::$app->formatter->asDecimal($model->rutalumno, 0) . "-" . $model->digrut;
            }
        ],
        //Apellido paterno
        [
            'attribute' => 'paternoalu',
            'label' => 'A. Paterno',
            'format' => 'html',
            'value' => function($model){
                return !empty($model->paternoalu) ? $model->paternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
            }
        ],
        //Apellido materno
        [
            'attribute' => 'maternoalu',
            'label' => 'A. Materno',
            'format' => 'html',
            'value' => function($model){
                return !empty($model->maternoalu) ? $model->maternoalu : '<span class="glyphicon glyphicon-question-sign"></span>';
            }
        ],
        //Nombre alumno
        [
            'attribute' => 'nombrealu',
            'label' => 'Nombres',
            'format' => 'html',
            'value' => function($model){
                return !empty($model->nombrealu) ? $model->nombrealu : '<span class="glyphicon glyphicon-question-sign"></span>';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'headerOptions' => ['width'=> '80'],
            'template' => '{update}',
            'buttons' => [
                'update' => function($url,$model){
                    return Html::a("<span class='glyphicon glyphicon-pencil'></span>",['alumnos/update','id'=>$model->idalumno,'fuente' => 1],
                        ['class'=>'btn btn-circle btn-success btn-sm','title'=>'Actualizar Alumno']);
                }
            ],
        ]
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'export' => false,
        'pjax' => true,
        'emptyText' => 'No hay Alumnos registrados.-',
        'showPageSummary' => false,
        'layout' => '{pager}', //Con esto logramos que se muestre la paginación
        'panel' => [
            'type' => 'primary',
            'heading' => '<h3 class="panel-title">Listado de Alumnos para actualización ' .'</h3>',
        ]
    ]); ?>

    <?php Pjax::end(); ?>
</div>
